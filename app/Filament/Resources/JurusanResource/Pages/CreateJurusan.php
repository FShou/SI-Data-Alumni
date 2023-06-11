<?php

namespace App\Filament\Resources\JurusanResource\Pages;

use App\Filament\Resources\JurusanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJurusan extends CreateRecord
{
    protected static string $resource = JurusanResource::class;
    protected static ?string $title = 'Jurusan';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
