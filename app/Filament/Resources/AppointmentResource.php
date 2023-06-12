<?php

namespace App\Filament\Resources;
use Carbon\Carbon;
use Filament\Tables;
use App\Models\Appointment;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AppointmentResource\Pages;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationGroup = 'الحجوزات';
    protected static ?string $navigationLabel = 'سجل الحجوزات ';
    protected static ?string $modelLabel = ' سجل الحجوزات ';
    protected static ?string $pluralLabel = ' سجل الحجوزات ';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->searchable()
                ->sortable()
                ->label('الاسم'),
                TextColumn::make('appointment_no')
                ->searchable()
                ->label('رقم الحجز'),
            TextColumn::make('slot.center.name')
                ->searchable()
                ->sortable()
                ->label('المركز'),
            TextColumn::make('slot.date')
                ->searchable()
                ->sortable()
                ->label('التاريخ')
                ->date('d-M-Y'),
            TextColumn::make('slot.start_time')
                ->searchable()
                ->sortable()
                ->label('الوقت'),
                SelectColumn::make('status')
                ->options([
                    'pending' => 'قيد الانتظار',
                    'completed' => 'مكتمل',
                    'canceled' => 'ملغى',
                ],
                )
                ->label('اعدادات الحالة')
                ->disablePlaceholderSelection()
                ->disableOptionWhen(fn($record) => $record->status === 'completed')
                ->hidden(fn () =>  !auth()->user()->isCenter())
                ->disabled(function ($record) {
                    $slotDate = Carbon::parse($record->slot->date);

                    $today = Carbon::today();
                    return $slotDate>($today);
                }),

             BadgeColumn::make('fullstatus')
             ->enum([
                 'pending' => 'قيد الانتظار',
                 'completed' => 'مكتمل',
                 'canceled' => 'ملغى',
             ],
             )
             ->label('الحالة')
             ->colors([

                 'warning' => 'pending',
                 'success' => 'completed',
                 'danger' => 'canceled',
             ])

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                ->icon('heroicon-o-trash'),
            
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAppointments::route('/'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getEloquentQuery()->latest();
        }
        $centerId = auth()->user()->center->id;

        return parent::getEloquentQuery()
            ->whereIn('appointment_slot_id', function ($query) use ($centerId) {
                $query->select('id')
                    ->from('appointment_slots')
                    ->where('center_id', $centerId);
            })->latest()
            ;
    }
}
