<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\ActivityLog;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Filament\Resources\Pages\CreateRecord;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'User Management';
    protected static ?int $navigationSort = 9;
    protected static ?string $slug = 'user';
    protected static ?string $pluralLabel = 'List User'; // Label untuk daftar record
    protected static ?string $modelLabel = 'User'; // Label untuk satu record

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                TextInput::make('password')->password()->required()->dehydrateStateUsing(fn($state) => bcrypt($state)),
                Select::make('roles')
                    ->relationship('roles', 'name') // Mengambil roles dari relasi dengan model Role
                    ->multiple() // Jika Anda ingin memilih lebih dari satu role
                    ->preload() // Untuk memuat data dengan cepat
                    ->required()
                    ->label('Roles')
                    ->options(function () {
                        return Role::all()->pluck('name', 'id'); // Menampilkan daftar roles
                    }),
                Textarea::make('reason')
                    ->label('Reason for Creation')
                    ->required()
                    ->hiddenOn('index'), // Menyembunyikan reason dari index
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('created_at') ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                ->before(function (array $data) {
                    session(['reason' => $data['reason']]); // Simpan reason ke session
                }),
                Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->form([
                        Textarea::make('reason')
                            ->label('Reason for Deletion')
                            ->required(),
                    ])
                    ->action(function (User $record, array $data) {
                        session(['reason' => $data['reason']]); // Simpan reason ke session
                        $record->delete(); // Lakukan delete
                    }),
                    
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
   
}

