<?php

namespace App\Http\Livewire;

use App\Filament\Resources\AppointmentResource;
use App\Models\User;
use App\Notifications\AppointmentBookedNotification;
use Carbon\Carbon;
use App\Models\Center;
use Filament\Notifications\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use App\Models\Government;
use App\Models\Appointment;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\AppointmentSlot;
use GrahamCampbell\ResultType\Success;

class BloodDonation extends Component
{
    use WithPagination;

    public $governments;
    public $centers;
    public $selectedGov;
    public $selectedCenter;
    public $appointments;
    public $userAppointments;
    public $appointmentBooked;
    public $hasAppointment;
    public $canBookAppointment = false;

    public function mount()
    {
        if (auth()->user()->hasRole('donor')) {
            $this->canBookAppointment = true;
        }
        $this->hasAppointment = Appointment::where('user_id', auth()->user()->id)->exists();

        $this->governments = Government::all()->pluck('name', 'id');

    }

    public function render()
    {

        return view('livewire.blood-donation');
    }

    public function changeGov()
    {
        if ($this->selectedGov !== '-1') {
            $this->centers = Government::find($this->selectedGov)->centers->pluck('name', 'id');
        }
    }

    public function updatedSelectedCenter($value)
    {
        $this->appointments = AppointmentSlot::with('appointments')->where('center_id', $value)->whereNull('deleted_at')
            ->where('date', '>', Carbon::now('Africa/Cairo')->toDateString())->where('is_available', 1)->get();


        $user_id = auth()->user()->id;
        $this->userAppointments = Appointment::where('user_id', $user_id)
            ->whereIn('appointment_slot_id', $this->appointments->pluck('id'))
            ->pluck('appointment_slot_id')
            ->toArray();

        $this->appointments = $this->appointments->map(function ($slot) {
            $slot->setAttribute('userHasAppointment', in_array($slot->id, $this->userAppointments));

            return $slot;
        });
    }

    public function updatedSelectedGov($value)
    {
        $this->centers = Center::where('government_id', $value)->get();
        $this->selectedCenter = null;
        $this->appointments = null;
    }

    public function bookAppointment($appointmentId)
    {
        if ($this->canBookAppointment) {  // Check if the donor can book an appointment


            $user_id = auth()->user()->id;

            // Get the donor's last appointment and last donation dates
            $checkAppointment = Appointment::where('user_id', $user_id)->with('slot')->latest()->first();

            $appointmentSlot = AppointmentSlot::find($appointmentId);

            // Set the time cutoff for the last appointment and last donation dates
            $threeMonthsAgo = Carbon::now()->subMonths(3);
            $fourDaysAgo = Carbon::now()->subDays(4);
            $last_donation_date = auth()->user()->donor->last_donation_date;

            // Check if the donor's last appointment or last donation was too recent
            if ($last_donation_date >= $threeMonthsAgo) {
                $this->updatedSelectedCenter($this->selectedCenter);
                toastr()->error('لا يمكنك حجز موعد للتبرع قبل مرور 3 شهور على آخر تبرع لك');

                return session()->flash('error', 'لا يمكنك حجز موعد للتبرع قبل مرور 3 شهور على آخر تبرع لك');
            } elseif ($checkAppointment && ($checkAppointment->slot->date >= $fourDaysAgo)) {
                $this->updatedSelectedCenter($this->selectedCenter);
                toastr()->error('لديك موعد مسبق يرحي الغاءه قبل حجز موعد جديد للتبرع');

                return session()->flash('error', 'لديك موعد مسبق يرحي الغاءه قبل حجز موعد جديد للتبرع');
            } // Get the appointment slot and check if it is available

            elseif (!$appointmentSlot || $appointmentSlot->available_capacity <= 0) {
                return 'error';
            } else {
                $uniqueString = Str::random(9);
                $appointmentNo = $uniqueString . "-" . Carbon::parse($appointmentSlot->date)->format('Y');

                Appointment::create([

                    'user_id' => $user_id,
                    'appointment_no' => $appointmentNo,
                    'appointment_slot_id' => $appointmentId,
                ]);

                // Update the available capacity of the appointment slot
                $appointmentSlot->decrement('available_capacity');

                // Set the appointmentBooked variable to true
                $this->appointmentBooked = true;

                // Refresh the appointment list
                $this->updatedSelectedCenter($this->selectedCenter);
$center=Center::select('user_id')->where('id',$this->selectedCenter)->first();
                $centerUser = User::where('id','=',$center->user_id )->first();
$user_name=auth()->user()->name;
                $date = Carbon::parse($appointmentSlot->date);
                $date = $date->translatedFormat('Y, F d', 'ar');

                \Filament\Notifications\Notification::make()
                    ->title('حجز موعد للتبرع')
                    ->icon('heroicon-s-calendar')
                    ->body(" تم حجز موعد للتبرع بواسطة $user_name و ذلك بتاريخ $date ")
                    ->actions([
                        Action::make('view')
                            ->button()
                            ->url(AppointmentResource::getUrl('index'), shouldOpenInNewTab: true)
                            ->icon('heroicon-o-arrow-circle-right')
                        ->color('secondary')
                        ->label('شاهد')
                        ,

                    ])
                    ->sendToDatabase($centerUser);
                toastr()->success('تم حجز موعد التبرع بنجاح');
                session()->flash('success', 'تم حجز موعد التبرع بنجاح',);
                return 'success';

                return    'success';


            }

        }
    }

    public function cancelAppointment($appointmentSlotId)
    {

        $user_id = auth()->user()->id;
        $appointment = Appointment::where('appointment_slot_id', $appointmentSlotId)->where('user_id', $user_id)->first();

        if (!$appointment) {
            return 'error';
        }

        if (!$appointment->delete()) {
            return 'error';
        }

        $appointmentSlot = AppointmentSlot::find($appointmentSlotId);

        if ($appointmentSlot) {
            $appointmentSlot->increment('available_capacity');
        }

        $this->updatedSelectedCenter($this->selectedCenter);
        $this->appointmentBooked = false;

        $center=Center::select('user_id')->where('id',$this->selectedCenter)->first();
        $centerUser = User::where('id','=',$center->user_id )->first();
        $user_name=auth()->user()->name;

        \Filament\Notifications\Notification::make()
            ->title('الغاء حجز موعد للتبرع')
            ->icon('heroicon-s-calendar')
            ->body(" تم الغاء موعد للتبرع بواسطة $user_name ")
          ->warning()
            ->sendToDatabase($centerUser);
        toastr()->success('تم الغاء موعد التبرع بنجاح');
        return 'success';
    }
}
