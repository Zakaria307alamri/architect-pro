<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutSettings extends Page
{
    protected static string|\UnitEnum|null $navigationGroup = 'إعدادات الموقع';

    protected static ?string $navigationLabel = 'عن المهندس';

    protected static ?string $title = 'إعدادات صفحة عن المهندس';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'settings/about';

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
                Section::make('البيانات الأساسية')
                    ->schema([
                        TextInput::make('profile_name')
                            ->label('اسم المهندس'),
                        TextInput::make('profile_title')
                            ->label('المسمى الوظيفي'),
                        TextInput::make('profile_section_title')
                            ->label('عنوان قسم الملف الشخصي'),
                        Textarea::make('about_description')
                            ->label('نبذة')
                            ->rows(5),
                    ]),

                Section::make('قسم الهيرو')
                    ->schema([
                        TextInput::make('about_hero_title')
                            ->label('عنوان الهيرو'),
                        Textarea::make('about_hero_subtitle')
                            ->label('الوصف أسفل العنوان')
                            ->rows(3),
                    ]),

                Section::make('الصورة الشخصية')
                    ->schema([
                        FileUpload::make('profile_image')
                            ->label('صورة المهندس')
                            ->image()
                            ->directory('profile')
                            ->disk('public'),
                    ]),

                Section::make('فلسفة التصميم')
                    ->schema([
                        TextInput::make('philosophy_title')
                            ->label('عنوان قسم الفلسفة'),
                        Textarea::make('philosophy_text')
                            ->label('نص الفلسفة')
                            ->rows(5),
                    ]),

                Section::make('الخبرات')
                    ->schema([
                        TextInput::make('experience_title')
                            ->label('عنوان قسم الخبرات'),
                        Textarea::make('experience_list')
                            ->label('الخبرات (JSON format)')
                            ->rows(6)
                            ->helperText('مثال:
[
 {"period":"2024 - الآن","description":"إدارة مشاريع سكنية"},
 {"period":"2020 - 2024","description":"تصميم مشاريع مستدامة"}
]
'),
                    ]),

                Section::make('CTA صفحة عن المهندس')
                    ->schema([
                        TextInput::make('about_cta_title')
                            ->label('عنوان CTA'),
                        Textarea::make('about_cta_subtitle')
                            ->label('الوصف'),
                        TextInput::make('about_cta_button')
                            ->label('نص الزر'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $setting = Setting::firstOrCreate([]);
        $data = $this->form->getState();

        $setting->update($data);

        Notification::make()
            ->title('تم حفظ إعدادات صفحة عن المهندس بنجاح')
            ->success()
            ->send();
    }
}
