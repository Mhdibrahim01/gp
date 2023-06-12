<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;

use Filament\Widgets\DoughnutChartWidget;

class BloodTypeChart extends DoughnutChartWidget
{
    protected static ?string $heading = 'فصائل الدم';
protected static ?int $sort = 6;
protected static ?string $maxHeight = '290px';

    protected function getData(): array
    {
        if (auth()->user()->isAdmin()){
                        $bloodGroupCounts = DB::table('donors')
            ->join('blood_types', 'donors.blood_type_id', '=', 'blood_types.id')
            ->select('blood_types.blood_type', DB::raw('count(*) as count'))
            ->groupBy('blood_types.blood_type')
            ->get();
            
        }
        else{
            $bloodGroupCounts = DB::table('donors')
            ->join('blood_types', 'donors.blood_type_id', '=', 'blood_types.id')
            ->join('donations', 'donors.id', '=', 'donations.donor_id')
            ->select('blood_types.blood_type', DB::raw('count(*) as count'))
            ->where('donations.center_id',auth()->user()->center->id)
            ->groupBy('blood_types.blood_type')
            ->get();
        }
   
    $bloodTypes = $bloodGroupCounts->pluck('blood_type')->map(function($value) {
        return strval($value);
    })->toArray();
    
    $count = $bloodGroupCounts->pluck('count')->toArray();

    return [
        'datasets' => [
            [
                'label' => ' التبرعات',
                'data' => $count,
                'backgroundColor' => [
             '#67e8f9',
             '#c026d3',
             '#881337',
             '#eab308',
             '#fee2e2',
             '#86efac',
             '#818cf8',
             '#1d4ed8',
                '#f59e0b',
                '#854d0e'

                    
                 
                ],
                'borderColor' => '#fff',
          
            ],
        ],
        'labels' => $bloodTypes,

    ];
    }
}
