<?php
;

return [
    'includes' => [
        App\Filament\Resources\DonationResource::class,
        App\Filament\Resources\AppointmentResource::class,
        App\Filament\Resources\CenterResource::class,
        App\Filament\Resources\DonorResource::class,
        App\Filament\Resources\BloodInventoryResource::class,
    ],
    'excludes' => [
        // App\Filament\Resources\Blog\AuthorResource::class,
    ],
    'should_convert_count' => true,
    'enable_convert_tooltip' => true,
];
