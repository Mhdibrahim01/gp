<?php
namespace App\Filament\Widgets;
use Carbon\Carbon;
use App\Models\Donation;
use App\Models\BloodType;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    public $pullInterval='10s';
    protected function getCards(): array
    {
    if(auth()->user()->hasRole('centersup')) {
        $thisMonthTotalDonation = Donation::where('center_id', auth()->user()->center->id)->whereMonth('donation_date', Carbon::now()->month)->count();
        $prevMonthTotalDonation = Donation::whereMonth('donation_date', Carbon::now()->subMonth()->month)->count();
        $mostCommonBloodType = BloodType::select('blood_types.id', 'blood_types.blood_type', DB::raw('count(*) as total'))
        ->join('donors', 'blood_types.id', '=', 'donors.blood_type_id')
        ->join('donations', 'donors.id', '=', 'donations.donor_id')
        ->where('is_approved', '=', '1')
        ->groupBy('blood_types.id', 'blood_types.blood_type')
        ->where('donations.center_id', auth()->user()->center->id)
        ->orderBy('total', 'desc')
        ->first();
        $total_donations = Donation::where('center_id', auth()->user()->center->id)->count();

    } else {
        $thisMonthTotalDonation = Donation::whereMonth('donation_date', Carbon::now()->month)->count();
        $prevMonthTotalDonation = Donation::whereMonth('donation_date', Carbon::now()->subMonth()->month)->count();
        $mostCommonBloodType = BloodType::select('blood_types.id', 'blood_types.blood_type', DB::raw('count(*) as total'))
        ->join('donors', 'blood_types.id', '=', 'donors.blood_type_id')
        ->join('donations', 'donors.id', '=', 'donations.donor_id')
        ->where('is_approved', '=', '1')
        ->groupBy('blood_types.id', 'blood_types.blood_type')
        ->orderBy('total', 'desc')
        ->first();

    }

    $percentageIncrease = $prevMonthTotalDonation ? (($thisMonthTotalDonation - $prevMonthTotalDonation) / $prevMonthTotalDonation) * 100 : 0;

    $mostBdc=  Donation::select('donations.center_id', DB::raw('count(*) as total'))
      ->join('centers', 'donations.center_id', '=', 'centers.id')
      ->groupBy('donations.center_id')
      ->orderBy('total', 'desc')
      ->first();

    if(auth()->user()->hasRole('centersup')) {
        return [

        Card::make('عدد التبرعات هذا الشهر', $thisMonthTotalDonation)
        ->description(' زيادة %'.number_format($percentageIncrease, ))
            ->descriptionIcon('heroicon-s-trending-up')
        ->chart([7, 2, 10, 3, 15, 4, 17])
        ->color('success'),
        Card::make('فصيلة الدم الأكثر تبرعا', $mostCommonBloodType->blood_type)
        ->description('عدد التبرعات: '.$mostCommonBloodType->total)
        ->chart([7, 2, 10, 3, 15, 4, 17])
        ->color('danger'),
        Card::make('عدد التبرعات',$total_donations)
        ->chart([7, 2, 10, 3, 15, 4, 17])
        ->color('red'),
            ];
    } else {
        return [
            Card::make('عدد التبرعات هذا الشهر', $thisMonthTotalDonation)
            ->description(' زيادة %'.number_format($percentageIncrease, ))
                ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Card::make('فصيلة الدم الأكثر تبرعا', $mostCommonBloodType->blood_type)
            ->description('عدد التبرعات: '.$mostCommonBloodType->total)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger'),
            Card::make('المركز الأكثر استقبالا للتبرعات', $mostBdc->center->name)
            ->description('عدد التبرعات: '.$mostBdc->total)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('red'),
                ];

    }
}
}
