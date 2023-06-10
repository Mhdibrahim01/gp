<form class="form-horizontal mt-5 shadow-lg" wire:submit.prevent='register'>

    @csrf
    <h2>التسجيل للتبرع</h2>

    <div class="form-group mb-3">

        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
               placeholder="الاسم بالكامل " wire:model.lazy="name" value="{{ old('name') }}" autocomplete="name">
        @error('name')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>

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
        <input id='dob' class="form-control  @error('age') is-invalid @enderror"
          type="number" wire:model.lazy="age" placeholder="العمر" value="{{ old('age') }}" autocomplete="age">

       @error('age')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>


    <div class="row">
        <div class="col">
            <div class="form-group mb-3">
                <select id="bloodtype" class="form-select" wire:model.lazy="blood_type_id">
                    <option value="null">اختر فصيلة الدم</option>
                    @foreach ($bloodtypes as  $bt)
                        <option value="{{$bt->id}}">{{$bt->blood_type}}</option>

                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group mb-3">
                <select id="gender" class=" form-select @error('gender') is-invalid @enderror" wire:model.lazy="gender">
                    <option value="">اختر النوع</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                @error('gender')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
   

    <div class="form-group mb-3">

        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="كلمة المرور" wire:model.lazy="password" value="{{ old('password') }}"
               autocomplete="password">
        @error('password')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
    <div class="form-group mb-3">

        <input id="password-confirm" type="password" class="form-control" placeholder="تأكيد كلمة المرور"
               wire:model="password_confirmation" autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-lg btn-block">تسجيل
        <div wire:loading wire:target="register">
            <span class="spinner-border spinner-border-sm text-danger" role="status" aria-hidden="true"></span>
        <span class="visually-hidden">Loading...</span>
    </div>
    </button>

</form>
