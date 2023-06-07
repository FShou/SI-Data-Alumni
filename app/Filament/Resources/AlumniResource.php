<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Filament\Resources\AlumniResource\RelationManagers;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Prodi;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumniResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

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
                ->disableAutocomplete()
                ->regex('/^[A-Z][0-9]{9}$/')
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state) {
                    // Auofill Prodi & Jurusan
                    $set('nim', strtoupper($state));
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
                }),

            TextInput::make('nama_alumni')
                ->label('Nama Alumni')
                ->disableAutocomplete()
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
                ->disableAutocomplete()
                ->label('Email')
                ->maxLength(50),

            Select::make('id_angkatan')
                ->label('Angkatan')
                ->options(Angkatan::all()->pluck('tahun_angkatan', 'id'))
                ->searchable(),
            // TODO: Setup File Storage
            // FileUpload::make('foto')
            //     ->image()
            //     ->maxSize(2048)
            //     ->panelAspectRatio('2:1')
            //     ->imageResizeMode('cover')
            //     ->imageCropAspectRatio('3:4'),
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
                TextColumn::make('pekerjaan')->enum([
                        'Negri' => 'Negri',
                        'Swasta' => 'Swasta',
                        'Tidak Bekerja' => 'Tidak Bekerja',
                ]),

                TextColumn::make('prodi.nama_prodi')->label('Prodi'),
                TextColumn::make('jurusan.nama_jurusan')->label('Jurusan'),
                TextColumn::make('angkatan.tahun_angkatan')->label('Angkatan'),

                TextColumn::make('email_alumni')
                    ->label('Email')
                    ->placeholder('-'),
            ])
            ->filters([
                //
                SelectFilter::make('jurusan')
                    ->multiple()
                    ->relationship('jurusan', 'nama_jurusan'),
                SelectFilter::make('prodi')
                    ->multiple()
                    ->relationship('prodi', 'nama_prodi'),
                SelectFilter::make('angkatan')
                    ->multiple()
                    ->relationship('angkatan', 'tahun_angkatan'),
                SelectFilter::make('pekerjaan')
                    ->searchable()
                    ->options([
                        'Negri' => 'Negri',
                        'Swasta' => 'Swasta',
                        'Tidak Bekerja' => 'Tidak Bekerja',
                    ]),
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
