<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\BloodInventory;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BloodInventoryResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\BloodInventoryResource\RelationManagers;

class BloodInventoryResource extends Resource
{
    protected static ?string $model = BloodInventory::class;

    protected static ?string $navigationGroup = 'مراكز التبرع بالدم';
    protected static ?string $navigationLabel = ' مخزون الدم ';
    protected static ?string $pluralLabel = 'مخزون الدم ';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-archive';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('donation.donor.user.name')
                    ->searchable()
                    ->sortable()
                    ->label(' اسم المتبرع'),
                TextColumn::make('donation.donor.bloodType.blood_type')
                    ->searchable()
                    ->sortable()
                    ->label('فصيلة الدم'),
                TextColumn::make('donation.center.name')
                    ->searchable()
                    ->sortable()
                    ->label('اسم المركز'),
                TextColumn::make('quantity')
                    ->searchable()
                    ->sortable()
                    ->label('الكمية'),
                TextColumn::make('expiry_date')
                    ->searchable()
                    ->sortable()
                    ->label('تاريخ الانتهاء')

                ,

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('تصدير')

            ])
            ->headerActions([
                FilamentExportHeaderAction::make('تصدير')

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBloodInventories::route('/'),
        ];
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getEloquentQuery();
        }
        return parent::getEloquentQuery()->join('donations', 'blood_inventories.donation_id', '=', 'donations.id')
            ->join('centers', 'donations.center_id', '=', 'centers.id')
            ->where('centers.user_id', auth()->user()->id)
            ->select('blood_inventories.*')->latest();
    }
}
