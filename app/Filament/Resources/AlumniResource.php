<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Filament\Resources\AlumniResource\RelationManagers;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Prodi;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;

class AlumniResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $model = Alumni::class;
    protected static ?string $modelLabel = 'Alumnus';
    public static function form(Form $form): Form
    {
        return $form->schema([
            //
            TextInput::make('nim')
                ->required()
                ->autofocus()
                ->length(10)
                ->regex('/^[A-Z][0-9]{9}$/')
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    // Auofill Prodi & Jurusan
                    $jurusan = Jurusan::where('kode_jurusan', 'like', ucfirst(substr($state, 0, 1)))->first();
                    if ($jurusan) {
                        $jurusan->toArray();
                        $set('id_jurusan', $jurusan['id']);
                    }

                    $prodi = Prodi::where('kode_prodi', 'like', ucfirst(substr($state, 0, 3)))->first();
                    if ($prodi) {
                        $prodi->toArray();
                        $set('id_prodi', $prodi['id']);
                    }

                    $set('nim', ucfirst($state));
                }),

            TextInput::make('nama_alumni')
                ->required()
                ->maxLength(50),
            Select::make('gender')
                ->searchable()
                ->options([
                    'L' => 'Laki-laki',
                    'K' => 'Perempuan',
                ]),
            Select::make('id_prodi')
                ->label('Prodi')
                ->hint('Diambil dari Nim')
                ->placeholder('-')
                ->options(function (callable $get) {
                    $prodi = Prodi::where('kode_prodi', 'like', ucfirst(substr($get('nim'), 0, 3)));
                    return $prodi->pluck('nama_prodi', 'id');
                })
                ->required()
                ->disabled(),

            Select::make('id_jurusan')
                ->label('Jurusan')
                ->hint('Diambil dari Nim')
                ->placeholder('-')
                ->options(function (callable $get) {
                    $jurusan = Jurusan::where('kode_jurusan', 'like', ucfirst(substr($get('nim'), 0, 1)));
                    return $jurusan->pluck('nama_jurusan', 'id');
                })
                ->required()
                ->disabled(),
            Select::make('pekerjaan')
                ->searchable()
                ->options([
                    'Negri' => 'Negri',
                    'Swasta' => 'Swasta',
                    'Tidak Bekerja' => 'Tidak Bekerja',
                ]),
            TextInput::make('email_alumni')
                ->email()
                ->label('Email')
                ->maxLength(50),

            Select::make('id_angkatan')
                ->label('Angkatan')
                ->options(Angkatan::all()->pluck('tahun_angkatan', 'id'))
                ->searchable(),
            FileUpload::make('foto')
                ->image()
                ->maxSize(2048)
                ->panelAspectRatio('2:1')
                ->imageResizeMode('cover')
                ->imageCropAspectRatio('3:4'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // @TODO: menampilkan Foto
                TextColumn::make('nim')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('nama_alumni')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('gender')->enum([
                    'L' => 'Laki-laki',
                    'K' => 'Perempuan',
                ]),
                TextColumn::make('email_alumni')
                    ->label('Email')
                    ->placeholder('-'),

                // @TODO: menampilkan nama_prodi & nama_jurusan & tahun_angkatan
                // TextColumn::make('id_prodi'),

                // Columns\TextColumn::make()
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
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
        ];
    }
}
