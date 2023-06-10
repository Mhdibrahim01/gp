<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Center;
use Carbon\CarbonInterval;
use App\Models\AppointmentSlot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AppointmentSlotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:appointment-slot-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    // Delete all appointment slots for the previous day

    AppointmentSlot::where('date', '<', Carbon::today()->format('Y-m-d'))->delete();
    


    // Get all of the blood donation centers from the database.
    $centers = Center::all();

    // Create appointment slots for each of the next 4 days at all blood donation centers in your database.
    // The appointment slots will be created at the specified intervals, and each slot will have the specified available capacity.
    // The code will also log a message to the console indicating that the appointment slots were created successfully.

    for ($i = 0; $i < 4; $i++) {
        $date = Carbon::today()->addDays($i);

        foreach ($centers as $center) {
            // Check if an appointment slot already exists for this date and center
            $existingSlot = AppointmentSlot::where('date', $date->format('Y-m-d'))
                ->where('center_id', $center->id)
                ->first();

            if ($existingSlot) {
                // If an appointment slot already exists, update its available capacity
                $existingSlot->available_capacity = $center->maximum_capacity;
                $existingSlot->save();
            } else {
                // If an appointment slot does not already exist, create a new one
                // Calculate the start and end times for the appointment slots
                $startTime = Carbon::parse($center->opening_time);
                $endTime = Carbon::parse($center->closing_time)->subMinutes($center->minimum_duration);

                // Create appointment slots at the specified interval
                $interval = CarbonInterval::minutes($center->minimum_duration);
                $currentSlotTime = $startTime->copy();

                while ($currentSlotTime->lte($endTime)) {
                    // Create a new appointment slot
                    $slot = new AppointmentSlot([
                        'center_id' => $center->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $currentSlotTime->format('H:i'),
                        'end_time' => $currentSlotTime->addMinutes($center->minimum_duration)->format('H:i'),
                        'available_capacity' => $center->maximum_capacity,
                    ]);

                    // Save the appointment slot to the database
                    $slot->save();

                    // Log a message to the console indicating that the appointment slot was created successfully
                    Log::info('Appointment slot created successfully!');

                    $currentSlotTime->add($interval);

                    $this->info('Appointment slots created successfully!');
                }
            }
        }
    }
}}

