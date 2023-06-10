<?php

namespace App\Filament\Widgets;

use Closure;
use App\Models\Donation;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Layout\Grid;

class LatestDonation extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 7;
    protected static ?string $heading = 'أحدث التبرعات';
    protected function getTableQuery(): Builder
    {
        if(auth()->user()->hasRole('centersup'))
        return Donation::query()
            ->latest('donation_date')
            ->where('center_id',auth()->user()->center->id)
            ->limit(5);
        else
        return Donation::query()
            ->latest('donation_date')
            ->limit(5);

    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('donor.user.name')
                ->label('الاسم')
                ->searchable()
                ->sortable()
                ,
            TextColumn::make('donor.bloodType.blood_type')
                ->label('فصيلة الدم')
                ->searchable()
                ->sortable(),
            TextColumn::make('donation_date')
                ->label('تاريخ التبرع')
                ->searchable()
                ->sortable(),
            TextColumn::make('center.name')
                ->label('مركز التبرع')
                ->searchable()
                ->sortable(),



        ];

    }

}