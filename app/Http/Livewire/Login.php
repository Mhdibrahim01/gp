<?php
namespace App\Http\Livewire;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }
<<<<<<< HEAD

    public function authenticate()
    {
        $this->validate();
=======
       public function authenticate()
       {
           $this->validate();
>>>>>>> origin/main

           if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
               $this->addError('email', trans('auth.failed'));

               return;
           }
           if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('centersup')) {
               return redirect()->intended('admin');
           }
           return redirect()->intended(route('index'));

<<<<<<< HEAD
            return;
        }
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('centersup')) {
            return redirect()->intended('admin');
        }
        return redirect()->intended(route('index'));


    }
=======

       }
>>>>>>> origin/main

    public function render()
    {
        return view('livewire.login');
    }
}
