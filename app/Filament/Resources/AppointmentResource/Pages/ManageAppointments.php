<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use Carbon\Carbon;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\Appointment;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\AppointmentResource;

class ManageAppointments extends ManageRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }

}
