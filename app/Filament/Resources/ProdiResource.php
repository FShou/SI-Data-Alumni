<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdiResource\Pages;
use App\Models\Jurusan;
use App\Models\Prodi;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ProdiResource extends Resource
{
    protected static ?string $navigationGroup = 'Poliban';
    protected static ?string $model = Prodi::class;
    protected static ?string $pluralModelLabel = 'Prodi';
    protected static ?string $slug = 'prodi';

    protected static ?string $navigationIcon = 'heroicon-o-library';
    protected static ?string $navigationLabel =  'Prodi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
            TextInput::make('id_prodi')
                ->label('Kode Prodi')
                ->hint('Kode Jurusan + Kode Prodi : C03')
                ->autofocus()
                ->required()
                ->length(3)
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    $set('id_prodi', ucfirst($state));
                    $jurusan = Jurusan::where('id_jurusan', 'like', ucfirst(substr($state, 0, 1)))->first();
                    if ($jurusan) {
                        $jurusan->toArray();
                        $set('id_jurusan', $jurusan['id_jurusan']);
                    }
                }),
            Select::make('id_jurusan')
                ->label('Jurusan')
                ->hint('Diambil dari Kode Prodi')
                ->disabled()
                ->required()
                ->options(Jurusan::all()->pluck('nama_jurusan', 'id_jurusan')),
            TextInput::make('nama_prodi')
                ->label('Nama Prodi')
                ->columnSpanFull()
                ->maxLength(50)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_prodi')
                ->label('Nama Prodi')
                ->searchable(),

                TextColumn::make('jurusan.nama_jurusan')
                ->label('Jurusan')


            ])
            ->filters([
                //
                SelectFilter::make('jurusan')
                    ->multiple()
                    ->searchable()
                    ->relationship('jurusan', 'nama_jurusan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()

            ])
            ->bulkActions([
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
            'index' => Pages\ListProdis::route('/'),
        ];
    }
}
