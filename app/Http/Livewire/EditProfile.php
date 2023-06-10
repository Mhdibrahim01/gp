<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditProfile extends Component
{
    public $email;
    public $name;
    public $password='';
    public $password_confirmation='';


    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }

    public function editProfile()
    {
        $user=auth()->user();
        $this->validate([
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'name' => 'required|min:6',

        ]);


        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        toastr()->success('تم تحديث الحساب بنجاح');
    }


    public function editPassword()
    {
        $user = auth()->user();

        $this->validate([
            'password' => 'required|min:6|same:password_confirmation'
        ]);

        $user->password = bcrypt($this->password);
        $user->save();

        $this->newPassword = '';
        $this->passwordConfirmation = '';
        toastr()->success('تم تحديث كلمة المرور بنجاح');

    }
}

