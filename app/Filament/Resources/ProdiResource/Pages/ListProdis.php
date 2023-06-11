<?php

namespace App\Filament\Resources\ProdiResource\Pages;

use App\Filament\Resources\ProdiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdis extends ListRecords
{
    protected static string $resource = ProdiResource::class;
    protected static ?string $title = 'Prodi';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
