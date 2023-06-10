<?php

namespace App\Filament\Widgets;

use App\Models\Center;
use App\Models\Donation;
use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;

class DonationLineChart extends LineChartWidget
{
    protected static ?string $heading = 'عدد التبرعات لكل شهر';
    protected static ?string $maxHeight = '300px';
    protected static ?int $sort = 6;

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

    protected function getFilters(): ?array
    {
        $centerId = auth()->user()->center?->id;
        $query = Donation::query()->selectRaw('EXTRACT(YEAR FROM donation_date) as year');
        if ($centerId && !auth()->user()->hasRole('centersup')) {
            $query->where('center_id', $centerId);
        }
        return $query->groupBy('year')->pluck('year', 'year')->toArray();
    }

    protected function getData(): array
    {
        $centerId = auth()->user()->center?->id;
        $activeFilter = $this->filter;
        $months = [
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر',
        ];
        $donationMonthsQuery = Donation::query()->selectRaw('EXTRACT(MONTH FROM donation_date) as month');
        if ($centerId && !auth()->user()->hasRole('centersup')) {
            $donationMonthsQuery->where('center_id', $centerId);
        }
        $donationMonths = $donationMonthsQuery->groupBy('month')->pluck('month')->toArray();
        $monthNames = array_map(fn($month) => $months[$month] ?? $month, $donationMonths);
        $donationsQuery = Donation::query()->selectRaw('EXTRACT(MONTH FROM donation_date) as month, COUNT(*) as count');
        if ($centerId && !auth()->user()->hasRole('centersup')) {
            $donationsQuery->where('center_id', $centerId);
        }
        if ($activeFilter) {
            $donationsQuery->whereRaw('EXTRACT(YEAR FROM donation_date) = ?', [$activeFilter]);
        }
        $donationsPerMonth = $donationsQuery->groupBy('month')->pluck('count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => ' التبرعات',
                    'data' => $donationsPerMonth,
                    'backgroundColor' => ['#881337'],
                    'borderColor' => '#f87171',
                    'hoverBackgroundColor' => '#fff',
                    'stepped' => true,
                ],
            ],
            'labels' => $monthNames,
        ];
    }
}