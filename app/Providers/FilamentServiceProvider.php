<?php

namespace App\Providers;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::Serving(function(){
            Filament::registerUserMenuItems([
                UserMenuItem::make('profile')
                    ->label('الحساب')->
                    url(UserResource::getUrl('profile'))
                    ->icon('heroicon-o-user')
                   ,
                
            ]);
        });
    }
}
