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

   

       public function authenticate()
       {
    $this->validate();

           if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
               $this->addError('email', trans('auth.failed'));

               return;
           }
           if(auth()->user()->isAdmin() || auth()->user()->isCenter()) {
               return redirect()->intended('admin');
           }
           return redirect()->intended(route('index'));

    }


       

    public function render()
    {
        return view('livewire.login');
    }
}
