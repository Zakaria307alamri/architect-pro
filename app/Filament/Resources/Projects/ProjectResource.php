<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Models\Project;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Textarea::make('short_description')
                    ->rows(3),

                RichEditor::make('description')
                    ->columnSpanFull(),

                TextInput::make('client'),
                TextInput::make('location'),
                TextInput::make('area'),
                TextInput::make('year'),

                Select::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'ongoing' => 'Ongoing',
                        'concept' => 'Concept',
                    ])
                    ->default('completed'),

                Toggle::make('featured'),

                DateTimePicker::make('published_at'),

                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->image()
                    ->imageEditor()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->previewable()
                    ->customProperties(fn (Get $get): array => [
                        'caption' => $get('gallery_caption'),
                    ]),

                Textarea::make('gallery_caption')
                    ->label('وصف صورة المعرض (اختياري)')
                    ->rows(2)
                    ->dehydrated(false)
                    ->helperText('اكتب وصف الصورة قبل رفعها. إذا رفعت أكثر من صورة دفعة واحدة سيُطبّق نفس الوصف عليها جميعًا.'),

                TextInput::make('plan_title')
                    ->label('اسم المخطط (اختياري)')
                    ->dehydrated(false)
                    ->helperText('اكتب اسم المخطط قبل الرفع. عند رفع ملف واحد سيظهر هذا الاسم بدل اسم الملف.'),

                SpatieMediaLibraryFileUpload::make('plans')
                    ->collection('plans')
                    ->multiple()
                    ->customProperties(fn (Get $get): array => [
                        'title' => $get('plan_title'),
                    ])
                    ->acceptedFileTypes([
                        'application/pdf',
                        '.pdf',
                        '.dwg',
                        '.rvt',
                        '.skp',
                        '.pln',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category'),

                TextColumn::make('status'),

                IconColumn::make('featured')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
