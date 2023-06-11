<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Donation;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\DonationResource\Pages;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;
    protected static ?string $navigationGroup = 'مراكز التبرع بالدم';
    protected static ?string $navigationLabel = 'سجل التبرعات';
    protected static ?string $pluralLabel = 'سجل التبرعات';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $modelLabel = 'التحليل';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                fieldset::make('التحليل')
                    ->relationship('blood_test')
                    ->schema([
                        Card::make()->
                        schema([
                            Select::make('hepatitis_b_result')->options([
                                'negative' => 'سلبي',
                                'positive' => 'موجب',
                                'indeterminate' => 'غير محدد',
                            ])
                                ->label('نتيجة فحص الالتهاب الكبدي ب'),
                            Select::make('hepatitis_c_result')->options([
                                'negative' => 'سلبي',
                                'positive' => 'موجب',
                                'indeterminate' => 'غير محدد',
                            ])->label('نتيجة فحص الالتهاب الكبدي ج')
                        ])->columns(2),
                        Card::make()->
                        schema([
                            Select::make('syphilis_result')->options([
                                'negative' => 'سلبي',
                                'positive' => 'موجب',
                                'indeterminate' => 'غير محدد',
                            ])
                                ->label('نتيجة فحص الزهري'),
                            Select::make('malaria_result')->options([
                                'negative' => 'سلبي',
                                'positive' => 'موجب',
                                'indeterminate' => 'غير محدد',
                            ])
                                ->label('نتيجة فحص الملاريا'),
                        ])->columns(2),
                        TextArea::make('note')->label('ملاحظات')
                            ->rows(2)
                            ->columnSpan(2),
                    ]),
                Fieldset::make('فصيلة الدم')
                    ->relationship('donor')
                    ->schema([
                        select::make('blood_type_id')->label('فصيلة الدم')->relationship('bloodType', 'blood_type'),
                    ])
           
                   

            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('donorName.name')
                    ->searchable()
                    ->sortable()
                    ->label('الاسم'),
                Tables\Columns\TextColumn::make('center.name')
                    ->searchable()
                    ->sortable()
                    ->label('المركز'),
                Tables\Columns\TextColumn::make('donation_date')
                    ->searchable()
                    ->sortable()
                    ->label('التاريخ')
                    ->date('d-M-Y'),
                Tables\Columns\TextColumn::make('donor.bloodType.blood_type')
                    ->searchable()
                    ->sortable()
                    ->label('فصيلة الدم'),
                ToggleIconColumn::make('is_approved')
                    ->label('الحالة')
                    ->translateLabel()
                    ->alignCenter()
                    ->onColor('success')
                    ->offColor('danger')
                    ->size('xl')
                    ->hidden(fn() => !auth()->user()->isCenter())
            ])
                
             

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-clipboard-list')
                    ->label('تعديل نتائج التحاليل'),
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->label('عرض ')
                ,

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('approve')
                    ->action(fn(Collection $records) => $records->each->approve())
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->label('تأكيد التبرع')

                ->action(fn (Collection $records) => $records->each->approve())
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check')
                ->label('تأكيد التبرع')
             
                ,
                FilamentExportBulkAction::make('تصدير')

            ])
            ->headerActions([
                FilamentExportHeaderAction::make('تصدير')
                    ->withHiddenColumns()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDonations::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getEloquentQuery()->withoutTrashed()->orderBy('donation_date', 'desc');
        }
        $center_id = auth()->user()->center->id;
        return parent::getEloquentQuery()->where('center_id', $center_id)->withoutTrashed()->orderBy('donation_date', 'desc')->with('donor');
    }

}
