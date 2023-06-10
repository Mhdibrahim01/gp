<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\Government;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CentersRelationManager extends RelationManager
{
    protected static string $relationship = 'centers';

    protected static ?string $navigationGroup = 'مراكز التبرع بالدم';
    protected static ?string $navigationLabel = 'مراكز التبرع بالدم';
    protected static ?string $pluralLabel = 'مراكز التبرع بالدم';
    protected static ?string $label = 'مركز التبرع بالدم';


    protected static ?string $recordTitleAttribute = 'zip_code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                     
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('اسم مركز التبرع بالدم')
                    ->placeholder('اسم مركز التبرع بالدم'),
                    Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->label('رقم الهاتف')
                    ->placeholder('رقم الهاتف'),
                ])
                ->columns(2),
                Card::make([
                    Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->label('العنوان')
                    ->placeholder('العنوان')
                    ->required('العنوان مطلوب'),

                    Select::make('government_id')
                    ->required()
                    ->placeholder('اختر محافظة مركز التبرع بالدم')
                    ->options(Government::all()->pluck('name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('city_id', null))
                    ->name('المحافظة')
                    ->loadingMessage('جاري التحميل...')->searchable()
                    ->placeholder('اختر محافظة مركز التبرع بالدم')
                    ,
                    Select::make('city_id')
                    ->required()
                    ->placeholder('اختر مدينة مركز التبرع بالدم')
                    ->options(function (callable $get) {
                        return City::where('government_id', $get('government_id'))->pluck('name', 'id');
                    })
                 ->name('المدينة')->loadingMessage('جاري التحميل...')->searchable()
                 ->placeholder('اختر مدينة مركز التبرع بالدم')
                  ,

                Forms\Components\TextInput::make('zip_code')
                    ->required()
                    ->maxLength(255)
                    ->label('الرقم البريدي')
                   -> placeholder('الرقم البريدي'),
                ])
                ->columns(2),
                Card::make([
                    Forms\Components\TextInput::make('opening_time')
                    ->required()
                    ->type('time')
                    ->label('وقت الفتح')
                    ->placeholder('وقت الفتح'),
                Forms\Components\TextInput::make('closing_time')
                    ->required()
                    ->type('time')
                    ->label('وقت الإغلاق')
                    ->name('وقت الإغلاق')
            
                    ->placeholder('وقت الإغلاق'),
                Forms\Components\TextInput::make('minimum_duration')
                    ->required()
                    ->type('number')
                    ->default(60)
                    ->label('الحد الأدنى للمدة')
                    ->placeholder('الحد الأدنى للمدة')
                   ,
                Forms\Components\TextInput::make('maximum_capacity')
                    ->required()
                    ->type('number')
                    ->default(10)
                    ->label('الحد الأقصى للسعة')
                    ->placeholder('الحد الأقصى للسعة')
                   ,
                   
                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('government.name')->label('المحافظة')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('city.name')->label('المدينة')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('اسم المركز')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('رقم الهاتف')->searchable(),
                Tables\Columns\TextColumn::make('zip_code')->label('الرقم البريدي')->searchable(),
                Tables\Columns\TextColumn::make('opening_time')->label('وقت الفتح')->time('h:i A'),
                Tables\Columns\TextColumn::make('closing_time')->label('وقت الإغلاق')->time('h:i A'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
