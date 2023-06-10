<?php
namespace App\Filament\Resources\BloodInventoryResource\Widgets;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class InventoryOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $currentDate = Carbon::now()->format('Y-m-d');

        if(auth()->user()->hasRole('centersup'))
        {
            $bloodInventories = DB::table('blood_types')
            ->leftJoin('donors', 'blood_types.id', '=', 'donors.blood_type_id')
            ->leftJoin('donations', 'donors.id', '=', 'donations.donor_id')
            ->leftJoin('blood_inventories', 'donations.id', '=', 'blood_inventories.donation_id')
            ->select('blood_types.blood_type', DB::raw('COALESCE(SUM(blood_inventories.quantity), 0) as total_quantity'))
            ->where('donations.center_id', auth()->user()->center->id)
            ->where('blood_inventories.expiry_date', '>', $currentDate)
            ->groupBy('blood_types.blood_type')
            ->get();
        }
        else{
            $bloodInventories = DB::table('blood_types')
            ->leftJoin('donors', 'blood_types.id', '=', 'donors.blood_type_id')
            ->leftJoin('donations', 'donors.id', '=', 'donations.donor_id')
            ->leftJoin('blood_inventories', 'donations.id', '=', 'blood_inventories.donation_id')
            ->select('blood_types.blood_type', DB::raw('COALESCE(SUM(blood_inventories.quantity), 0) as total_quantity'))
            ->where('blood_inventories.expiry_date', '>', $currentDate)
            ->groupBy('blood_types.blood_type')
            ->unionAll(DB::table('blood_types')
                    ->select('blood_type', DB::raw('0 as total_quantity'))
                    ->whereNotIn('id', function ($query) {
                        $query->select('blood_types.id')
                            ->from('blood_types')
                            ->leftJoin('donors', 'blood_types.id', '=', 'donors.blood_type_id')
                            ->leftJoin('donations', 'donors.id', '=', 'donations.donor_id')
                            ->leftJoin('blood_inventories', 'donations.id', '=', 'blood_inventories.donation_id')
                            ->where('blood_inventories.expiry_date', '>', Carbon::now()->format('Y-m-d'))
                            ->groupBy('blood_types.id');
                    }))
            ->get();
        }
        $cards = [];

        foreach ($bloodInventories as $bloodInventory) {
            $card = Card::make('فصيلة الدم', $bloodInventory->blood_type)
                ->description('الكمية المتوفرة: ' . $bloodInventory->total_quantity);
            $cards[] = $card;
        }
        
        return $cards;
    }
}
