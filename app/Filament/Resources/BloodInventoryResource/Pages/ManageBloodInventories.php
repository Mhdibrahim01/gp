<?php

namespace App\Filament\Resources\BloodInventoryResource\Pages;

use Carbon\Carbon;
use App\Models\Donation;
use Filament\Pages\Actions;
use App\Models\BloodInventory;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\BloodInventoryResource;
use App\Filament\Resources\BloodInventoryResource\Widgets\InventoryOverview;

class ManageBloodInventories extends ManageRecords
{
    protected static string $resource = BloodInventoryResource::class;

    protected function getActions(): array
    {
        if(auth()->user()->isAdmin()) {
            return[];
        }
        return [
            Action::make('update_inventory')->action('update_inventory')->label('تحديث المخزون')->icon('heroicon-o-refresh')

        ];
    }

    public function update_inventory(): void
    {

        if(auth()->user()->hasRole('centersup')) {
            $approvedDonations = Donation::where('is_approved', 1)->where('center_id', auth()->user()->center->id)->get();

        } else {
            $approvedDonations = Donation::where('is_approved', 1)->get();

        }

        // Add each approved donation to the inventory
        foreach ($approvedDonations as $donation) {
            $existingInventory = BloodInventory::where('donation_id', $donation->id)->first();
            if ($existingInventory) {
                continue; // Skip this donation if it's already in the inventory
            }
            $inventory = new BloodInventory();
            $inventory->donation_id = $donation->id;
            $inventory->quantity = 1;  // assume 1 unit of blood per donation
            $expiryDate = Carbon::parse($donation->donation_date)->copy()->addDays(45);
            $inventory->expiry_date = $expiryDate->toDateString();
            $inventory->save();


        }
        $this->notify('success', 'تم تحديث المخزون بنجاح');

    }
    protected function getHeaderWidgets(): array
    {
        return [
            InventoryOverview::class
        ];
    }
}
