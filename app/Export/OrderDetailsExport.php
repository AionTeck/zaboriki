<?php

namespace App\Export;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderDetailsExport implements FromCollection,
    WithStrictNullComparison,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
{
    public function __construct(
        protected Collection $collection
    )
    {
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            '№',
            'Дата',
            'Наименование товара',
            'Кол-во',
            'Ед.',
            'Цена',
            'Сумма',
        ];
    }

    public function map($row): array
    {
        return [
            $row->blankPosition,
            $row->blankDate,
            $row->name,
            $row->quantity,
            $row->measurement,
            $row->price,
            $row->totalPrice,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
