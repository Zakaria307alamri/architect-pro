<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSettings extends Page
{
    protected static string|\UnitEnum|null $navigationGroup = 'إعدادات الموقع';

    protected static ?string $navigationLabel = 'التواصل';

    protected static ?string $title = 'إعدادات صفحة التواصل';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'settings/contact';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = Setting::firstOrCreate([]);
        $this->form->fill($setting->toArray());
    }

    public function getView(): string
    {
        return 'filament.pages.site-settings';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema([
                Section::make('بيانات التواصل')
                    ->schema([
                        TextInput::make('phone')
                            ->label('رقم الهاتف'),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email(),
                        TextInput::make('location')
                            ->label('الموقع'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $setting = Setting::firstOrCreate([]);
        $data = $this->form->getState();

        $setting->update($data);

        Notification::make()
            ->title('تم حفظ إعدادات صفحة التواصل بنجاح')
            ->success()
            ->send();
    }
}
