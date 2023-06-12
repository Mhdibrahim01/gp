<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use App\Models\User;
use Filament\Tables;
use App\Models\Center;
use App\Models\Government;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CenterResource\Pages;

class CenterResource extends Resource
{
    protected static ?string $model = Center::class;
    protected static ?string $navigationGroup = 'المستخدمين';
    protected static ?string $navigationLabel = 'مراكز التبرع بالدم';
    protected static ?string $pluralLabel = 'مراكز التبرع بالدم';
    protected static ?string $label = 'مركز التبرع بالدم';
    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
        Card::make()->
        schema([
            Fieldset::make('معلومات مركز التبرع بالدم')
            ->schema([
        Grid::make(2)
        ->schema([
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
      ]),
           Fieldset::make('موقع مركز التبرع بالدم')
           ->schema([
           Grid::make(3)
           ->schema([
            Forms\Components\TextInput::make('address')
            ->maxLength(255)
            ->label('العنوان')
            ->placeholder('العنوان')
            ->required('العنوان مطلوب')
            ->columnSpan(2)
            ,
            Forms\Components\TextInput::make('zip_code')
            ->required()
            ->maxLength(255)
            ->label('الرقم البريدي')
           -> placeholder('الرقم البريدي')
           ->columnSpan(1),
                 ]),
           Grid::make(2)
           ->schema([
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
                ]),
            ]),  
            ]),
            ])->columnSpan(8) ,
            
               Card::make()
               ->schema([
                
                grid::make(2)
               -> schema([
                Fieldset::make('مواعيد عمل مركز التبرع بالدم')
    ->schema([
        Forms\Components\TextInput::make('opening_time')
                ->required()
                ->type('time')
                ->label('وقت الفتح')
                ->placeholder('وقت الفتح')
                ->columnSpan(1),
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
                ])])
               ])->columnSpan(4),
Card::make()
->schema([
               Fieldset::make('معلومات الحساب')
               ->relationship('user')
                ->schema([
                        TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('الاسم')
                        ->placeholder('الاسم'),
                        TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(User::class, 'email',null,null,true)
                        ->label('البريد الالكتروني')
                        ->placeholder('البريد الالكتروني'),
                        TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create')
                        ->label('كلمة المرور'),
                        ])->columns(2),
                  ])
                        
            ])->columns(12);
              
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
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->icon('heroicon-o-pencil-alt'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCenters::route('/'),
            'create' => Pages\CreateCenter::route('/create'),
            'edit' => Pages\EditCenter::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getEloquentQuery();
        }
        return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
    }
}
