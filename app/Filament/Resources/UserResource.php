<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\CentersRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'المستخدمين';
    protected static ?string $navigationLabel = 'المستخدمين';
    protected static ?string $pluralLabel = 'المستخدمين';
    protected static ?string $label = 'المستخدم';
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
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
                    ->required(fn (string $context): bool => $context === 'create'),
                    Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->placeholder('')
                    ->preload()

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('الاسم'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('البريد الالكتروني'),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable()
                    ->sortable()
                    ->label('تاريخ الانشاء'),
                BadgeColumn::make('roles.name')
                    ->enum([
                        'admin' => 'ادمن',
                        'donor' => 'متبرع',
                        'centersup' => 'مسؤول مركز',
                    ])
                    ->colors([
                        'warning' => 'admin',
                        'success' => 'donor',
                        'danger' => 'centersup',
                    ])
                    ->label('الصلاحيات')
                    
                
                    
            ])
            ->filters([
                

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->icon('heroicon-o-pencil-alt'),
                    Tables\Actions\DeleteAction::make()
                    ->color('danger')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            CentersRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'profile' => Pages\الحساب::route('/profile'),

        ];
    }

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()->latest();
    }
}
