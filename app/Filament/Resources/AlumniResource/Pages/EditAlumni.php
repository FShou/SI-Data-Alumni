<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use App\Filament\Resources\AlumniResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumni extends EditRecord
{
    protected static string $resource = AlumniResource::class;

    protected static ?string $title = 'Alumni';
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
