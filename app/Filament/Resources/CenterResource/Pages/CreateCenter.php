<?php

namespace App\Filament\Resources\CenterResource\Pages;

use App\Filament\Resources\CenterResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCenter extends CreateRecord
{
    protected static string $resource = CenterResource::class;
    public function afterCreate()
    {
        $this->redirect('/resources/centers');
    }
}
