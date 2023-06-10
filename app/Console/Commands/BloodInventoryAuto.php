<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Donation;
use App\Models\BloodInventory;
use Illuminate\Console\Command;

class BloodInventoryAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:blood-inventory';

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
        $approvedDonations = Donation::where('is_approved', 1)->get();

        // Add each approved donation to the inventory
        foreach ($approvedDonations as $donation) {
            $existingInventory = BloodInventory::where('donation_id', $donation->id)->first();
        if ($existingInventory) {
            continue; // Skip this donation if it's already in the inventory
        }
            $inventory = new BloodInventory;
            $inventory->donation_id = $donation->id;
            $inventory->quantity = 1;  // assume 1 unit of blood per donation
            $expiryDate = Carbon::parse($donation->donation_date)->copy()->addDays(45);
            $inventory->expiry_date = $expiryDate->toDateString();
            $inventory->save();
        }

        $this->info('Added ' . count($approvedDonations) . ' approved donations to the inventory.');
    }
}
