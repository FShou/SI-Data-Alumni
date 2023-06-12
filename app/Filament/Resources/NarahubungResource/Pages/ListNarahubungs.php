<?php

namespace App\Filament\Resources\NarahubungResource\Pages;

use App\Filament\Resources\NarahubungResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNarahubungs extends ListRecords
{
    protected static string $resource = NarahubungResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
