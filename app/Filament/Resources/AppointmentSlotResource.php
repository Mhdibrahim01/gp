<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\AppointmentSlot;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use App\Filament\Resources\AppointmentSlotResource\Pages;


class AppointmentSlotResource extends Resource
{
    protected static ?string $model = AppointmentSlot::class;


    protected static ?string $navigationGroup = 'الحجوزات';
    protected static ?string $navigationLabel = 'سجل مواعيد الحجوزات ';
    protected static ?string $modelLabel = ' الميعاد';
    protected static ?string $pluralLabel = ' سجل مواعيد الحجوزات ';
    protected static ?string $navigationIcon = 'heroicon-o-clock';


    public static function table(Table $table): Table
    {

        return $table
            ->columns(columns: [
                TextColumn::make('center.name')
                    ->searchable()
                    ->sortable()
                    ->label('الاسم')
                ,
                TextColumn::make('date')
                    ->searchable()
                    ->sortable()
                    ->label('التاريخ')
                    ->date('d-M-Y'),
                TextColumn::make('start_time')
                    ->searchable()
                    ->sortable()
                    ->label('وقت البدء')
                    ->date('h:i A'),
                TextColumn::make('end_time')
                    ->searchable()
                    ->sortable()
                    ->label('وقت الانتهاء')
                    ->date('h:i A'),
                TextColumn::make('available_capacity')
                    ->searchable()
                    ->label('السعة المتاحة'),
                    
                    ToggleIconColumn::make('is_available')

                    ->label('الحالة')
                    ->translateLabel()
                    ->alignCenter()
                    ->onColor('success')
                    ->offColor('danger')
                    ->size('xl')
                    ->hidden(fn() => !auth()->user()->isCenter())


            ])
            ->filters([
                Filter::make('date')
                    ->label('التاريخ')
                    ->form([
                        DatePicker::make('date')
                            ->label('اختر التاريخ')
                            ->format('d/m/Y')
                        ,
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['date'],
                            fn(Builder $query, $date): Builder => $query->where('date', $date),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->tooltip(' احذف هذا الموعد')
                ,

                Tables\Actions\ForceDeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('available')
                    ->action(fn(Collection $records) => $records->each->available())
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->label('اتاحة المواعيد'),
                Tables\Actions\BulkAction::make('unavailable')
                    ->action(fn(Collection $records) => $records->each->unavailable())
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-check')
                    ->label('الغاء المواعيد')
                ->action(fn (Collection $records) => $records->each->available())
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check')
                ->label('اتاحة المواعيد'),
                Tables\Actions\BulkAction::make('unavailable')
                ->action(fn (Collection $records) => $records->each->unavailable())
                ->requiresConfirmation()
                ->color('danger')
                ->icon('heroicon-o-check')
                ->label('الغاء المواعيد')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAppointmentSlots::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getEloquentQuery()->withoutTrashed();
        }
        $center_id = auth()->user()->center->id;
        return parent::getEloquentQuery()->where('center_id', $center_id)->withoutTrashed();
    }
}
