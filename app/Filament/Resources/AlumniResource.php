<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Models\Alumni;
use App\Models\Angkatan;
use App\Models\Jurusan;
use App\Models\Narahubung;
use App\Models\Prodi;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Foundation\Auth\User;

class AlumniResource extends Resource
{
    protected static ?string $navigationGroup = 'Alumni';
    protected static ?string $pluralModelLabel = 'alumni';
    protected static ?string $slug = 'alumni';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Alumni';

    protected static ?string $model = Alumni::class;
    protected static ?string $modelLabel = 'Alumni';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
            Card::make()->schema([

            FileUpload::make('foto')
                ->required()
                ->image()
                // ->maxSize(2048)
                // ->panelAspectRatio('3:1')
                // ->imageResizeMode('cover')
                ->imageCropAspectRatio('3:4'),
            ]),
            Card::make()->schema([

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
                    $jurusan = Jurusan::where('id_jurusan', 'like', ucfirst(substr($state, 0, 1)))->first();
                    if ($jurusan) {
                        $jurusan->toArray();
                        $set('id_jurusan', $jurusan['id_jurusan']);
                    }

                    $prodi = Prodi::where('id_prodi', 'like', ucfirst(substr($state, 0, 3)))->first();
                    if ($prodi) {
                        $prodi->toArray();
                        $set('id_prodi', $prodi['id_prodi']);
                    }
                }),
            TextInput::make('nisn')
                ->label('NISN')
                ->regex('/^[0-9]{10}$/')
                ->unique()
                ->required()
                ->maxLength(10),
            TextInput::make('nama_alumni')
                ->label('Nama Alumni')
                ->disableAutocomplete()
                ->columnSpanFull()
                ->required()
                ->maxLength(50),
            Select::make('id_jurusan')
                ->label('Jurusan')
                ->hint('Diambil dari Nim')
                ->placeholder('-')
                ->options(function (callable $get) {
                    $jurusan = Jurusan::where('id_jurusan', 'like', ucfirst(substr($get('nim'), 0, 1)));
                    return $jurusan->pluck('nama_jurusan', 'id_jurusan');
                })
                ->required()
                ->disabled(),
            Select::make('id_prodi')
                ->label('Prodi')
                ->hint('Diambil dari Nim')
                ->placeholder('-')
                ->options(function (callable $get) {
                    $prodi = Prodi::where('id_prodi', 'like', ucfirst(substr($get('nim'), 0, 3)));
                    return $prodi->pluck('nama_prodi', 'id_prodi');
                })
                ->required()
                ->disabled(),

            Select::make('gender')
                ->searchable()
                ->required()
                ->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan',
                ])->columnSpanFull(),
            ])->columns(2),

            Card::make()->schema([

            TextInput::make('email_alumni')
                ->email()
                ->required()
                ->disableAutocomplete()
                ->label('Email')
                ->maxLength(50),
            Select::make('perusahaan')
                ->searchable()
                ->required()
                ->options([
                    'Negeri' => 'Negeri',
                    'Swasta' => 'Swasta',
                    'Tidak Bekerja' => 'Tidak Bekerja',
                ]),
            TextInput::make('ipk')
                ->label('IPK')
                ->required()
                ->numeric()
                ->disableAutocomplete()
                ->hint('Contoh: 3.40')
                ->nullable()
                ->mask(
                    fn(TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(4)
                        ->decimalPlaces(2)
                        ->padFractionalZeros()
                        ->decimalSeparator('.')
                        ->mapToDecimalSeparator([',']),
                ),

            Select::make('id_angkatan')
                ->label('Angkatan')
                ->options(Angkatan::all()->pluck('tahun_angkatan', 'id'))
                ->required()
                ->searchable(),
                TextInput::make('judul_ta')
                ->required()
                ->columnSpanFull()
                ->label('Judul TA'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ImageColumn::make('foto')->circular(),
                // ->grow(false),

                TextColumn::make('nama_alumni')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('nim')->searchable(),
                TextColumn::make('gender')
                    ->enum([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->grow(false),
                TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan'),
                TextColumn::make('prodi.nama_prodi')
                   ->label('Prodi'),
                TextColumn::make('perusahaan')
                    ->enum([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                        'Tidak Bekerja' => 'Tidak Bekerja',
                    ])
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('ipk')
                    ->label('IPK')
                    ->placeholder('-')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('judul_ta')
                    ->label('Judul TA')
                    ->placeholder('-')
                    ->toggleable()
                    ->toggledHiddenByDefault(),


                TextColumn::make('angkatan.tahun_angkatan')->label('Angkatan'),

                TextColumn::make('email_alumni')
                    ->label('Email')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->placeholder('-'),
            ])
            ->filters([
                //
                SelectFilter::make('jurusan')
                    ->multiple()
                    ->searchable()
                    ->relationship('jurusan', 'nama_jurusan'),
                SelectFilter::make('prodi')
                    ->multiple()
                    ->searchable()
                    ->relationship('prodi', 'nama_prodi'),
                SelectFilter::make('angkatan')
                    ->multiple()
                    ->searchable()
                    ->relationship('angkatan', 'tahun_angkatan'),
                SelectFilter::make('perusahaan')
                    ->searchable()
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta',
                        'Tidak Bekerja' => 'Tidak Bekerja',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        User::find($record->id_user)->delete();           
                        Narahubung::where('email_narahubung','=',$record->email_alumni)->delete();
                    })
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        if(!auth()->user()->hasRole('Admin'))
        {
            return parent::getEloquentQuery()->whereBelongsTo(auth()->user());
        }
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/buat'),
            'edit' => Pages\EditAlumni::route('/{record}/ubah'),
        ];
    }
}
