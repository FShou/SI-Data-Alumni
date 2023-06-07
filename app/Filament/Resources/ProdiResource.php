<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdiResource\Pages;
use App\Filament\Resources\ProdiResource\RelationManagers;
use App\Models\Jurusan;
use App\Models\Prodi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdiResource extends Resource
{
    protected static ?string $model = Prodi::class;

    protected static ?string $navigationIcon = 'heroicon-o-library';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
            TextInput::make('kode_prodi')
                ->label('Kode Prodi')
                ->hint('Kode Jurusan + Kode Prodi : C03')
                ->autofocus()
                ->required()
                ->length(3)
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $set('kode_prodi', ucfirst($state));
                    $jurusan = Jurusan::where('kode_jurusan', 'like', ucfirst(substr($state, 0, 1)))->first();
                    if ($jurusan) {
                        $jurusan->toArray();
                        $set('id_jurusan', $jurusan['id']);
                    }
                }),
            TextInput::make('nama_prodi')
                ->label('Nama Prodi')
                ->maxLength(50)
                ->required(),
            Select::make('id_jurusan')
                ->label('Jurusan')
                ->disabled()
                ->options(Jurusan::all()->pluck('nama_jurusan', 'id')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_prodi')
                ->label('Nama Prodi'),
                TextColumn::make('jurusan.nama_jurusan')
                ->label('Jurusan')

            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            'index' => Pages\ListProdis::route('/'),
            'create' => Pages\CreateProdi::route('/create'),
            'edit' => Pages\EditProdi::route('/{record}/edit'),
        ];
    }
}
