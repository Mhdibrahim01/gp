<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Fieldset;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;

class الحساب extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.الحساب';
    public $name;

    public $email;

    public $current_password;

    public $new_password;

    public $new_password_confirmation;

    public function mount()
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function submit()
    {
        $this->form->getState();

        $state = array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->new_password ? Hash::make($this->new_password) : null,
        ]);

        $user = auth()->user();

        $user->update($state);

        if ($this->new_password) {
            $this->updateSessionPassword($user);
        }

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->notify('success', 'تم تحديث الحساب بنجاح.');
    }

    protected function updateSessionPassword($user)
    {
        request()->session()->put([
            'password_hash_' . auth()->getDefaultDriver() => $user->getAuthPassword(),
        ]);
    }

    public function getCancelButtonUrlProperty()
    {
        return UserResource::getUrl('profile');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => 'الحساب',
        ];
    }

    protected function getFormSchema(): array
    {
        return [
    Card::make()
    ->schema([

    Fieldset::make('تحديث الحساب')
    ->schema([
        TextInput::make('name')
        ->required()
        ->label('الاسم'),
    TextInput::make('email')
        ->label('Email Address')
        ->required()
        ->email()
        ->label('البريد الالكتروني'),
    ]) ,

        Fieldset::make('تحديث كلمة المرور')
    ->schema([
        TextInput::make('current_password')
        ->label('Current Password')
        ->password()
        ->label('كلمة المرور الحالية')
        ->rules(['required_with:new_password'])
        ->currentPassword()
        ->autocomplete('off')
        ->columnSpan(2),
    Grid::make()
        ->schema([
            TextInput::make('new_password')
                ->label('New Password')
                ->password()
                ->rules(['confirmed'])
                ->autocomplete('new-password')
                ->label('كلمة المرور الجديدة'),
            TextInput::make('new_password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->rules([
                    'required_with:new_password',
                ])
                ->autocomplete('new-password')
                ->label('تأكيد كلمة المرور'),
                   ])
    ]),

    ])

  ];
    }
}
