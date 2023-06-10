<?php

namespace App\Filament\Resources\DonationResource\Pages;

use Carbon\Carbon;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\Appointment;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\DonationResource;

class ManageDonations extends ManageRecords
{
    protected static string $resource = DonationResource::class;

    protected function getActions(): array
    {
        if(auth()->user()->isAdmin()) {
            return[];
        }
        return [
            Action::make('add_donation')->action('add_donation')->label('تحديث التبرعات ')->icon('heroicon-o-refresh')

        ];
    }
    public function add_donation(): void
    {
        $this->notify('success', 'تم تحديث التبرعات بنجاح');

        $appointments = Appointment::join('appointment_slots', 'appointment_slots.id', '=', 'appointments.appointment_slot_id')
            ->whereDate('appointment_slots.date', '>=', Carbon::today()->subDays(7))
            ->where('appointments.status', 'completed')
            ->get();

        foreach ($appointments as $appointment) {
            $donor = Donor::where('user_id', $appointment->user_id)->first();

            if ($donor) {
                DB::transaction(function () use ($appointment, $donor) {
                    // Add a donation for the appointment
                    if ($donor->last_donation_date === null || Carbon::parse($donor->last_donation_date)->addDays(90) < Carbon::today()) {
                        $donation = new Donation();

                        $donation->donor_id = $donor->id;
                        $donation->donation_date = $appointment->date;
                        $donation->center_id = $appointment->center_id;
                        $donation->is_approved = false;

                        if (!Donation::where('donor_id', $donor->id)
                            ->where('donation_date', $appointment->date)
                            ->exists()) {
                            $donation->save();

                            // Update the donor's last donation date
                            $donor->last_donation_date = $appointment->date;
                            $donor->total_donations = $donor->total_donations + 1;
                            $donor->save();
                        }
                    }
                });
            }
        }
    }
}
