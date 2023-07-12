<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use App\Filament\Resources\AlumniResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAlumni extends CreateRecord
{
    protected static string $resource = AlumniResource::class;
    protected static ?string $title = 'Alumni';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['email_alumni']) {
            $user = User::factory()
                ->create([
                    'name' => $data['nama_alumni'],
                    'email' => $data['nim']."@alumni.com",
                    'password' => $data['nisn'],
                ])
                ->assignRole('Alumni');
                $user->toArray();
            $data['id_user'] = $user['id'];
        }
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
