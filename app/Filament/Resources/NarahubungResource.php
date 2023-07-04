<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NarahubungResource\Pages;
use App\Filament\Resources\NarahubungResource\RelationManagers;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\Narahubung;
use Closure;
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

class NarahubungResource extends Resource
{

    protected static ?string $navigationGroup = 'Alumni';
    protected static ?string $model = Narahubung::class;
    protected static ?string $pluralModelLabel = 'Narahubung';
    protected static ?string $slug = 'narahubung';

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('id_angkatan')
                    ->label('Angkatan')
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->options(Angkatan::all()->pluck('tahun_angkatan', 'id')),
                // TextInput::make('nama_narahubung')
                //     ->label('Nama')
                //     ->maxLength(50),
                Select::make('nama_narahubung')
                ->label('Nama Narahubung')
                ->placeholder('-')
                    ->searchable()
                ->options(function( $get){
                    $angkatan = $get('id_angkatan');
                    return Alumni::where('id_angkatan','=',$angkatan)->pluck('nama_alumni','nama_alumni');
                }),
                TextInput::make('email_narahubung')
                    ->label('Email')
                    ->maxLength(50)
                    ->email(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('angkatan.tahun_angkatan'),
                TextColumn::make('nama_narahubung')
                ->label('Nama'),
                // TextColumn::make('email_narahubung')
                // ->label('Email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListNarahubungs::route('/'),
            // 'create' => Pages\CreateNarahubung::route('/buat'),
            // 'edit' => Pages\EditNarahubung::route('/{record}/ubah'),
        ];
    }
}
