<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AngkatanResource\Pages;
use App\Filament\Resources\AngkatanResource\RelationManagers;
use App\Models\Angkatan;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AngkatanResource extends Resource
{
    protected static ?string $navigationGroup = 'Alumni';
    protected static ?string $pluralModelLabel = 'Angkatan';
    protected static ?string $slug = 'angkatan';
    protected static ?string $model = Angkatan::class;
    protected static ?string $navigationLabel =  'Angkatan';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tahun_angkatan')
                ->label('Tahun Angkatan')
                ->length(4)
                ->required()
                ->placeholder('-')
                ->autofocus()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('tahun_angkatan') -> searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAngkatans::route('/'),
            'create' => Pages\CreateAngkatan::route('/create'),
            'edit' => Pages\EditAngkatan::route('/{record}/edit'),
        ];
    }
}
