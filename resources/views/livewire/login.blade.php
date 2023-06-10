<form class="form-horizontal mt-5" wire:submit.prevent='authenticate'>
    @csrf
    <h2>تسجيل الدخول</h2>
    <div class="form-group mb-3">

        <input type="email" id="email" placeholder="البريد الالكتروني"
               class="form-control @error('email') is-invalid @enderror"
               wire:model.lazy="email" value="{{ old('email') }}" autocomplete="email">

        @error('email')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>


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


    <button type="submit" class="btn btn-lg btn-block">{{__('Login')  }}  
        <div wire:loading wire:target="authenticate">
            <span class="spinner-border spinner-border-sm text-danger" role="status" aria-hidden="true"></span>
        <span class="visually-hidden">Loading...</span>
    </div>
    </button>


</form>