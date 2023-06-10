<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Donor;
use Livewire\Component;
use App\Models\BloodType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
<<<<<<< HEAD
    public $password_confirmation = '';
    public $age = '';
    public $gender = '';
    public $blood_type_id = '';
    public $bloodtypes;
    protected $rules = [
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|same:password_confirmation',
        'name' => 'required|min:6',
        'age' => 'required|integer|min:18',
        'gender' => 'required',

    ];

    public function mount()
    {
        $this->bloodtypes = BloodType::all();
    }

    public function register()
    {
        $attr = $this->validate();

        DB::transaction(function () use ($attr) {
            $user = User::create([
                'email' => $attr['email'],
                'name' => $attr['name'],
                'password' => Hash::make($attr['password']),
            ]);
            if(!$this->blood_type_id) {
                Donor::create([
                    'user_id' => $user->id,
                    'age' => $attr['age'],
                    'gender' => $attr['gender'],

                ]);
            }
            else {
                Donor::create([
                    'user_id' => $user->id,
                    'age' => $attr['age'],
                    'gender' => $attr['gender'],
                    'blood_type_id' => $this->blood_type_id,

                ]);
            }
            $user->assignRole('donor');
            event(new Registered($user));
            Auth::login($user, true);
            return redirect()->intended(route('index'));

        });

    }

    public function render()
    {
        return view('livewire.register');
    }

    public function updated($field)
    {
        $this->validateOnly($field);
=======
    public $password_confirmation ='';
    public $age='';
    public $gender='';
    public $blood_type_id='';
    public $bloodtypes;
    protected $rules = [
       'email' => 'required|email|unique:users,email',
       'password' => 'required|min:6|same:password_confirmation',
       'name' => 'required|min:6',
       'age'=>'required|integer|min:18',
       'gender'=>'required',

];
    public function mount()
    {
        $this->bloodtypes=BloodType::all();
>>>>>>> origin/main
    }

     public function register()
     {
         $attr=  $this->validate();

         DB::transaction(function () use ($attr) {
             $user = User::create([
                 'email' =>$attr['email'],
                 'name' => $attr['name'],
                 'password' => Hash::make($attr['password']),
             ]);
             Donor::create([
             'user_id'=>$user->id,
             'age'=>$attr['age'],
             'gender'=>$attr['gender'],
             'blood_type_id'=>$this->blood_type_id,

             ]);
             $user->assignRole('donor');
             event(new Registered($user));
             Auth::login($user, true);
             return redirect()->intended(route('index'));

         });

     }
        public function render()
        {
            return view('livewire.register');
        }
        public function updated($field)
        {
            $this->validateOnly($field);
        }
}
