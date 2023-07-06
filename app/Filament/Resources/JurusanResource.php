<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurusanResource\Pages;
use App\Filament\Resources\JurusanResource\RelationManagers;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JurusanResource extends Resource
{
    protected static ?string $navigationGroup = 'Poliban';
    protected static ?string $model = Jurusan::class;
    protected static ?string $pluralModelLabel = 'Jurusan';
    protected static ?string $slug = 'jurusan';

    protected static ?string $navigationIcon = 'heroicon-o-office-building';
    protected static ?string $navigationLabel =  'Jurusan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('id_jurusan')
                ->label('Kode Jurusan')
                ->required()
                ->length(1)
                ->reactive()
                ->afterStateUpdated(fn (callable $set,$state) => $set('id_jurusan',ucfirst($state)) ),
                TextInput::make('nama_jurusan')->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id_jurusan')
                ->label('Kode Jurusan'),
                TextColumn::make('nama_jurusan')
                    ->label('Nama Jurusan')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListJurusans::route('/'),
            // 'create' => Pages\CreateJurusan::route('/buat'),
            // 'edit' => Pages\EditJurusan::route('/{record}/ubah'),
        ];
    }
}
