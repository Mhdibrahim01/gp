<?php

namespace App\Filament\Resources;

use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Tables;
use App\Models\Donor;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DonorResource\Pages;

class DonorResource extends Resource
{
    protected static ?string $model = Donor::class;

    protected static ?string $navigationGroup = 'المتبرعين';
    protected static ?string $navigationLabel = 'المتبرعين';
    protected static ?string $pluralLabel = 'المتبرعين';
    protected static ?string $modelLabel = 'متبرع';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('الاسم'),
                TextColumn::make('age')
                    ->sortable()
<<<<<<< HEAD
                    ->label('تاريخ الميلاد'),
                TextColumn::make('gender')
                    ->sortable()
                    ->label(' الجنس'),
=======
                    ->label('تاريخ الميلاد')  ,
                    TextColumn::make('gender')
                    ->sortable()
                    ->label(' الجنس')  ,
>>>>>>> origin/main

                TextColumn::make('BloodType.blood_type')
                    ->searchable()
                    ->sortable()
                    ->label('فصيلة الدم'),
<<<<<<< HEAD
                TextColumn::make('last_donation_date')
                    ->label('تاريخ اخر تبرع'),
                TextColumn::make('total_donations')
                    ->sortable()
                    ->label('عدد التبرعات'),
=======
                    TextColumn::make('last_donation_date')
                    ->label('تاريخ اخر تبرع'),
                    TextColumn::make('total_donations')
                     ->sortable()
                     ->label('عدد التبرعات'),
>>>>>>> origin/main
                ToggleIconColumn::make('is_eligible')
                    ->label('مؤهل')
                    ->translateLabel()
                    ->alignCenter()
                    ->onColor('success')
                    ->offColor('danger')
                    ->size('xl')
<<<<<<< HEAD
                    ->hidden(fn() => !auth()->user()->isCenter())
=======
                ->hidden(fn () =>  !auth()->user()->isCenter())
>>>>>>> origin/main


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDonors::route('/'),
        ];
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isCenter()) {
            return parent::getEloquentQuery()->join('donations', 'donations.donor_id', '=', 'donors.id')->where('donations.center_id', auth()->user()->center->id)->latest('donations.donation_date')->select('donors.*');

        }
        return parent::getEloquentQuery()->latest('id');

    }
}
