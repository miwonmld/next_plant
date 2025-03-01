<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarcodeResource\Pages;
use App\Filament\Resources\BarcodeResource\RelationManagers;
use App\Models\Barcode;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarcodeResource extends Resource
{
    protected static ?string $model = Barcode::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Barcode Management';
    protected static ?string $navigationLabel = 'Barcode QC';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'barcode-qc';
    protected static ?string $recordTitleAttribute = 'Barcode QC';
    protected static ?string $pluralLabel = 'List Barcode QC'; // Label untuk daftar record
    protected static ?string $modelLabel = 'Barcode QC'; // Label untuk satu record


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('barcode')
                    ->label('Barcode')
                    ->required()
                    ->maxLength(12) // Sesuai dengan CHAR(12)
                    ->unique(ignoreRecord: true), // Ignore unique check saat edit

                TextInput::make('c_date')
                    ->label('Created Date')
                    ->required(),

                TextInput::make('c_time')
                    ->label('Created Time')
                    ->required(),

                TextInput::make('nprint')
                    ->label('Print Count')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barcode')
                    ->label('Barcode')
                    ->searchable(),

                TextColumn::make('c_date')
                    ->label('Created Date')
                    ->sortable(),

                TextColumn::make('c_time')
                    ->label('Created Time')
                    ->sortable(),

                TextColumn::make('nprint')
                    ->label('Print Count')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make()->modal(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarcodes::route('/'),
            // 'create' => Pages\CreateBarcode::route('/create'),
            // 'edit' => Pages\EditBarcode::route('/{record}/edit'),
        ];
    }
}
