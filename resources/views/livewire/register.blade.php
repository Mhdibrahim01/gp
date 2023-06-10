<<<<<<< HEAD
<form class="form-horizontal mt-5 shadow-lg" wire:submit.prevent='register'>
=======

<form class="form-horizontal mt-5" wire:submit.prevent='register'>
>>>>>>> origin/main
    @csrf
    <h2>التسجيل للتبرع</h2>

    <div class="form-group mb-3">

        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
<<<<<<< HEAD
               placeholder="الاسم بالكامل " wire:model.lazy="name" value="{{ old('name') }}" autocomplete="name">
=======
               placeholder="الاسم بالكامل " wire:model.lazy="name" value="{{ old('name') }}"  autocomplete="name">
>>>>>>> origin/main
        @error('name')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>

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

    <div class="form-group mb-3">
        <input id='dob' class="form-control  @error('age') is-invalid @enderror"
<<<<<<< HEAD
               type="number" wire:model.lazy="age" placeholder="العمر" value="{{ old('age') }}" autocomplete="age">
=======
             type="number" wire:model.lazy="age" placeholder="العمر" value="{{ old('age') }}"  autocomplete="age">
>>>>>>> origin/main
        @error('age')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>


    <div class="row">
        <div class="col">
<<<<<<< HEAD
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
=======
          <div class="form-group mb-3">
            <select id="bloodtype" class="form-select" wire:model.lazy="blood_type_id">
              <option value="">اختر فصيلة الدم</option>
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
>>>>>>> origin/main

    <div class="form-group mb-3">

        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
<<<<<<< HEAD
               placeholder="كلمة المرور" wire:model.lazy="password" value="{{ old('password') }}"
               autocomplete="password">
=======
               placeholder="كلمة المرور" wire:model.lazy="password" value="{{ old('password') }}"  autocomplete="password">
>>>>>>> origin/main
        @error('password')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
    <div class="form-group mb-3">

<<<<<<< HEAD
        <input id="password-confirm" type="password" class="form-control" placeholder="تأكيد كلمة المرور"
               wire:model="password_confirmation" autocomplete="new-password">
=======
        <input id="password-confirm" type="password" class="form-control" placeholder="تأكيد كلمة المرور" wire:model="password_confirmation"  autocomplete="new-password">
>>>>>>> origin/main

    </div>


    <button type="submit" class="btn btn-lg btn-block">تسجيل</button>
</form>
