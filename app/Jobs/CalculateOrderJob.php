<?php

namespace App\Jobs;

use App\Domain\Contexts\Calculate\CalculateDomainCommandPrepareData;
use App\Enum\ExportOrderStatus;
use App\Enum\Measurement;
use App\Export\OrderDetailsExport;
use App\Models\Accessory;
use App\Models\AutomaticForGate;
use App\Models\Fence;
use App\Models\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class CalculateOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected CalculateDomainCommandPrepareData $prepareData
    )
    {
    }

    public function handle(): void
    {
        \Cache::put($this->prepareData->report_id, [
            'status' => ExportOrderStatus::Pending->value
        ]);

        $goodsCollection = $this->getExportCollections();

        $this->transformCollection($goodsCollection);

        $this->exportToPdf($goodsCollection);
        $this->exportToExcel($goodsCollection);

        $cache = \Cache::get($this->prepareData->report_id);
        $cache['status'] = ExportOrderStatus::Success->value;

        \Cache::put($this->prepareData->report_id, $cache);
    }

    private function getExportCollections(): Collection
    {
        $goodsCollection = collect();

        $this->calculateFence($goodsCollection);
        $this->calculateGate($goodsCollection);
        $this->calculateAccessories($goodsCollection);

        return $goodsCollection;
    }

    private function transformCollection(Collection $goodsCollection): void
    {
        $goodsCollection->each(function ($item) use ($goodsCollection) {
            $item->blankPosition = $goodsCollection->search($item) + 1;
            $item->blankDate = date('d.m.y');
        });
    }

    private function calculateFence(
        Collection $goodsCollection
    ): void
    {
        $fence = Fence::query()
            ->select([
                'fences.name',
                'fences.measurement_type',
                'fence_specs.price as price',
                'fence_specs.width as width',
            ])
            ->join('fence_specs', function (JoinClause $query) {
                $query->on('fence_specs.fence_id', '=', 'fences.id')
                    ->where('fence_specs.id', '=', $this->prepareData->fence['specId']);
            })
            ->where('fences.id', '=', $this->prepareData->fence['variantId'])
            ->firstOrFail();

        $length = $this->prepareData->fence['length'] * 1000;

        $fence->quantity = ceil($length / $fence->width);

        $fence->totalPrice = $fence->quantity * $fence->price;

        $fence->measurement = $fence->measurement_type->label();

        unset($fence->width, $fence->measurement_type);

        $goodsCollection->push($fence);
    }

    private function calculateGate(Collection $goodsCollection): void
    {
        if (!$this->prepareData->gates['needGates']) {
            return;
        }

        $gate = Gate::query()
            ->select([
                'gates.name',
                'gate_specs.price as price',
            ])
            ->join('gate_specs', function (JoinClause $query) {
                $query->on('gate_specs.gate_id', '=', 'gates.id')
                    ->where('gate_specs.id', '=', $this->prepareData->gates['specId']);
            })
            ->where('gates.id', '=', $this->prepareData->gates['variantId'])
            ->firstOrFail();

        $gate->quantity = 1;
        $gate->measurement = Measurement::PIECE->label();

        $gate->totalPrice = $gate->quantity * $gate->price;

        $goodsCollection->push($gate);

        if ($this->prepareData->gates['automation']) {
            $this->calculateAutomatic($goodsCollection);
        }
    }

    private function calculateAutomatic(Collection $goodsCollection): void
    {
        $automatic = AutomaticForGate::query()
            ->select([
                'automatic_for_gates.name',
                'automatic_for_gate_specs.price as price',
            ])
            ->join('automatic_for_gate_specs', function (JoinClause $query) {
                $query->on('automatic_for_gate_specs.id', '=', 'automatic_for_gates.id');
            })
            ->firstOrFail();

        $automatic->quantity = 1;
        $automatic->measurement = Measurement::PIECE->label();

        $automatic->totalPrice = $automatic->quantity * $automatic->price;

        $goodsCollection->push($automatic);
    }

    private function calculateAccessories(Collection $goodCollection): void
    {
        $accessories = array_merge(
            $this->prepareData->fence['accessories'],
            $this->prepareData->gates['accessories'],
        );

        foreach ($accessories as $accessory) {
            $accessoryModel = Accessory::query()
                ->select([
                    \DB::raw('CONCAT(accessories.name, " (", accessory_specs.dimension, ")") as name'),
                    'accessory_specs.price as price',
                ])
                ->where('accessories.id', '=', $accessory['id'])
                ->join('accessory_specs', function (JoinClause $query) use ($accessory) {
                    $query->on('accessory_specs.accessory_id', '=', 'accessories.id')
                        ->where('accessory_specs.id', '=', $accessory['spec_id']);
                })
                ->firstOrFail();

            $accessoryModel->quantity = $accessory['quantity'];
            $accessoryModel->measurement = Measurement::PIECE->label();
            $accessoryModel->totalPrice = $accessoryModel->quantity * $accessoryModel->price;

            $goodCollection->push($accessoryModel);
        }
    }

    private function exportToPdf(Collection $goodsCollection): void
    {
        $formatter = new \NumberFormatter('ru_RU', \NumberFormatter::SPELLOUT);

        try {
            $data = $goodsCollection->toArray();

            $orderTotalSum =  $goodsCollection->sum('totalPrice');

            $orderTotalSumAsString = str(
                $formatter->format(
                    $orderTotalSum
                )
            )
                ->ucfirst()
                ->toString();

            $totalGoodsCount = $goodsCollection->sum('quantity');

            //TODO Придумать заказ
            $orderNumber = 1;

            $orderDetails = compact(
                'orderTotalSum',
                'orderTotalSumAsString',
                'totalGoodsCount',
                'orderNumber'
            );

            $pdf = Pdf::loadView('pdf.order_details', compact('data', 'orderDetails'));

            $filePath = \Storage::path('orders/' . $this->prepareData->report_id . '.pdf');

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            $pdf->save($filePath);

            $cache = \Cache::get($this->prepareData->report_id);
            $cache['pdf_status'] = ExportOrderStatus::PdfSuccess->value;
            $cache['pdf_path'] = $filePath;

            \Cache::put($this->prepareData->report_id, $cache);
        } catch (\Throwable $e) {
            $cache = \Cache::get($this->prepareData->report_id);
            $cache['pdf_status'] = ExportOrderStatus::PdfFailed->value;
            $cache['pdf_message'] = $e->getMessage();

            \Cache::put($this->prepareData->report_id, $cache);
        }
    }

    private function exportToExcel(Collection $goodsCollection): void
    {
        try {
            $filePath = 'orders/' . $this->prepareData->report_id . '.xlsx';

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            Excel::store(new OrderDetailsExport($goodsCollection), $filePath, 'public');

            $cache = \Cache::get($this->prepareData->report_id);
            $cache['excel_status'] = ExportOrderStatus::ExcelSuccess->value;
            $cache['excel_path'] = $filePath;

            \Cache::put($this->prepareData->report_id, $cache);
        } catch (\Throwable $e) {
            $cache = \Cache::get($this->prepareData->report_id);
            $cache['excel_status'] = ExportOrderStatus::ExcelFailed->value;
            $cache['excel_message'] = $e->getMessage();

            \Cache::put($this->prepareData->report_id, $cache);
        }
    }
}
