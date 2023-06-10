<?php

namespace App\Http\Livewire;

use App\Models\AppointmentSlot;
use App\Models\Center;
use App\Models\User;
use Livewire\Component;

class Appointments extends Component
{
    public $last_appointment;

    public function render()
    {
        return view('livewire.appointments');
    }

    public function mount()
    {
        $this->last_appointment = auth()->user()->last_appointment;
    }

    public function cancel()
    {
        $this->last_appointment->slot->update([
            'available_capacity' => $this->last_appointment->slot->available_capacity + 1,
        ]);

        $this->last_appointment->delete();
        $user_name=auth()->user()->name;
        $center_id=AppointmentSlot::select('center_id')->where('id',$this->last_appointment->appointment_slot_id)->first();
        $center=Center::select('user_id')->where('id',$center_id->center_id)->first();
        $centerUser=User::where('id',$center->user_id)->first();

        \Filament\Notifications\Notification::make()
            ->title('الغاء حجز موعد للتبرع')
            ->icon('heroicon-s-calendar')
            ->body(" تم الغاء موعد للتبرع بواسطة $user_name ")
            ->warning()
            ->sendToDatabase($centerUser);
        $this->last_appointment = null;
        toastr()->success('تم الغاء الموعد بنجاح');
    }
}
