<?php

namespace App\Http\Livewire;

use App\Models\Alumni;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AlumniTable extends Component implements HasTable
{
    use InteractsWithTable;

    public function getTableQuery(): Builder
    {
        return Alumni::query();
    }
protected function getTableColumns(): array

    {

        return [

                ImageColumn::make('foto')->circular(),
                TextColumn::make('nim')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('nama_alumni')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('gender')->enum([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
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
        ];

    }



    protected function getTableFilters(): array

    {

        return [

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
                SelectFilter::make('pekerjaan')
                    ->searchable()
                    ->options([
                        'Negri' => 'Negri',
                        'Swasta' => 'Swasta',
                        'Tidak Bekerja' => 'Tidak Bekerja',
                    ]),
        ];

    }



    public function render()
    {
        return view('livewire.alumni-table');
    }
}
