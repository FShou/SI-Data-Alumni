<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Akun';
    protected static ?string $navigationLabel = 'User';
    protected static ?string $pluralModelLabel = 'user';
    protected static ?string $slug = 'user';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Select::make('roles')
                        ->multiple()
                        ->visible(
                            auth()
                                ->user()
                                ->hasRole('Admin'),
                        )
                        ->relationship('roles', 'name')
                        ->preload(),
                    TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(Page $livewire) => $livewire instanceof CreateUser)
                        ->maxLength(255),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nama')
                ->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('created_at')
                ->label('Dibuat pada')
                ->dateTime('d F Y'),
                TextColumn::make('roles.name')
                ->label('Role')
                ->visible(
                    auth()
                        ->user()
                        ->hasRole('Admin'),
                ),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole('Admin') ?
            parent::getEloquentQuery()->latest() :
            parent::getEloquentQuery()->where('id', 'like', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/buat'),
            'edit' => Pages\EditUser::route('/{record}/ubah'),
        ];
    }
}
