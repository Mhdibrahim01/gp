<<<<<<< HEAD
<form class="form-horizontal mt-5 login-form shadow-lg" wire:submit.prevent='authenticate'>
=======
<form class="form-horizontal mt-5" wire:submit.prevent='authenticate'>
>>>>>>> origin/main
    @csrf
    <h2>تسجيل الدخول</h2>
    <div class="form-group mb-3">

<<<<<<< HEAD
        <input type="email" id="email" placeholder="البريد الالكتروني"
               class="form-control @error('email') is-invalid @enderror"
               wire:model.lazy="email" value="{{ old('email') }}" autocomplete="email">
=======
        <input type="email" id="email" placeholder="البريد الالكتروني" class="form-control @error('email') is-invalid @enderror"
                 wire:model.lazy="email" value="{{ old('email') }}"  autocomplete="email">
>>>>>>> origin/main
        @error('email')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>


<<<<<<< HEAD
    <div class="form-group mb-3">

        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="الرقم السري" wire:model.lazy="password" value="{{ old('password') }}"
               autocomplete="password">
        @error('password')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>


    <button type="submit" class="btn btn-lg btn-block">{{__('Login')  }}</button>



</form>
=======
       

    <div class="form-group mb-3">

        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" 
               placeholder="الرقم السري" wire:model.lazy="password" value="{{ old('password') }}"  autocomplete="password">
        @error('password')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
        

   
                <button type="submit" class="btn btn-lg btn-block">{{__('Login')  }}</button>


                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
          
        
    </form>
>>>>>>> origin/main

