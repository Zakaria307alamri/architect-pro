<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeSettings extends Page
{
    protected static string|\UnitEnum|null $navigationGroup = 'إعدادات الموقع';

    protected static ?string $navigationLabel = 'الرئيسية';

    protected static ?string $title = 'إعدادات الصفحة الرئيسية';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'settings/home';

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
                Section::make('قسم الهيرو')
                    ->schema([
                        TextInput::make('hero_title')
                            ->label('العنوان الرئيسي')
                            ->required(),
                        Textarea::make('hero_subtitle')
                            ->label('الوصف المختصر')
                            ->rows(3),
                    ]),

                Section::make('قسم نبذة الرئيسية')
                    ->schema([
                        TextInput::make('about_headline')
                            ->label('عنوان قسم النبذة'),
                        Textarea::make('about_description')
                            ->label('نص النبذة')
                            ->rows(5),
                    ]),
            ]);
    }

    public function save(): void
    {
        $setting = Setting::firstOrCreate([]);
        $data = $this->form->getState();

        $setting->update($data);

        Notification::make()
            ->title('تم حفظ إعدادات الصفحة الرئيسية بنجاح')
            ->success()
            ->send();
    }
}
