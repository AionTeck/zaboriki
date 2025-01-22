<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;

class About extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.about';

    public array $data = [];

    protected static ?string $title = 'О нас';

    public function mount(): void
    {
        $this->form->fill(\App\Models\Settings::query()->firstOrNew()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()
                    ->columnSpanFull()
                    ->schema([
                        MarkdownEditor::make('about_text')
                            ->translateLabel()
                            ->required()
                            ->columnSpanFull(),

                        FileUpload::make('about_image')
                            ->translateLabel()
                            ->required()
                            ->directory('about')
                            ->columnSpanFull(),
                    ]),
            ])
            ->model(\App\Models\Settings::query()->firstOrNew())
            ->statePath('data')
            ;
    }

    public function save(): void
    {
        $model = $this->form->model;
        $this->form->validate();

        try {
            $data = $this->form->getState();
            $model->fill($data);
            $model->save();

            Notification::make()
                ->success()
                ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
                ->send()
            ;
        } catch (\Throwable $exception) {
            Notification::make()
                ->success()
                ->title($exception->getMessage())
                ->send()
            ;
            Log::info($exception->getMessage());
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
}
