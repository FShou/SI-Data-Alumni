<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!auth()->user()->hasRole('Admin'))
        {
            $data['approved'] = 0;
        }

        return $data;
    }
}
