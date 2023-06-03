<?php

namespace App\Filament\Resources\AngkatanResource\Pages;

use App\Filament\Resources\AngkatanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAngkatans extends ListRecords
{
    protected static string $resource = AngkatanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
