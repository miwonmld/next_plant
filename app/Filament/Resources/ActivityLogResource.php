<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Filament\Resources\ActivityLogResource\RelationManagers;
use App\Models\ActivityLog;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Activity Logs';
    protected static ?int $navigationSort = 9;
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('id')
                ->label('ID')
                ->required(),

            TextInput::make('action')
                ->label('Action')
                ->required(),

            TextInput::make('model_type')
                ->label('Type Model')
                ->required(),

            TextInput::make('model_id')
                ->label('ID Model')
                ->required(),
            KeyValue::make('changes')
                ->label('Changes')
                ->disabled(), 
            Textarea::make('reason')
                ->label('Reason'),
        ]);
        // ->afterSave(function ($record) {
        //     ActivityLog::create([
        //         'action'     => 'create',
        //         'model_type' => get_class($record),
        //         'model_id'   => $record->id,
        //         'changes'    => json_encode($record->toArray()),
        //         'reason'     => request()->input('reason'),
        //     ]);
        // })
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    // Kolom ID dari log aktivitas
                    Tables\Columns\TextColumn::make('id')
                        ->label('Log ID')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('action')
                        ->label('Action')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('model_type')
                        ->label('Model Type'),
                    Tables\Columns\TextColumn::make('model_id')
                        ->label('Model ID'),
                    Tables\Columns\TextColumn::make('reason')
                        ->label('Reason')
                        ->searchable()
                        ->wrap(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Created At')
                        ->sortable()
                        ->dateTime('Y-m-d H:i:s'),
                ])
                ->filters([
                    // Menambahkan filter berdasarkan action
                    Tables\Filters\SelectFilter::make('action')
                        ->options([
                            'create' => 'Create',
                            'update' => 'Update',
                            'delete' => 'Delete',
                        ])
                        ->label('Action'),
                ])
                ->actions([
                    Tables\Actions\ViewAction::make(),
                ])
                ->bulkActions([
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ]),
                ]);

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
            'index' => Pages\ListActivityLogs::route('/'),
            // 'view' => Pages\ViewActivityLog::route('/{record}'),
            // 'create' => Pages\CreateActivityLog::route('/create'),
            // 'edit' => Pages\EditActivityLog::route('/{record}/edit'),
        ];
    }
    
}
