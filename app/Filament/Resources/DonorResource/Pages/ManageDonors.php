<?php

namespace App\Filament\Resources\DonorResource\Pages;

use App\Filament\Resources\DonorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDonors extends ManageRecords
{
    protected static string $resource = DonorResource::class;

    protected function getActions(): array
    {
        return [
            
        ];
    }
}
