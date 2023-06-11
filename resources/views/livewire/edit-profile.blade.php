<div>
    <div class="row editrow mt-2">
        <div class="col-12">
            <div class="card rounded-lg d-flex justify-content-center">
                <div class="card-body shadow-lg ">
                    <center>
                        <h4 class="card-title mb-4"> تعديل الحساب </h4>
                    </center>
                    <form wire:submit.prevent="editProfile">

                        <div class="form-group mb-4">
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                   wire:model.lazy="name"
                                   placeholder="الاسم بالكامل ">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">

                            <input type="email" id="email" placeholder="البريد الالكتروني"
                                   class="form-control @error('email') is-invalid @enderror"
                                   wire:model.lazy="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                        <button class="button-38" type="submit">
                            تحديث
                            <div wire:loading wire:target="editProfile">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="sr-only">Loading...</span>
                            </div>

                        </button>

                    </form>
                </div>

            </div>

            <div class="card d-flex justify-content-center mt-1">
                <div class="card-body shadow">
                    <center>
                        <h4 class="card-title mb-4">تعديل الرقم السري </h4>
                    </center>
                    <form wire:submit.prevent="editPassword">


                        <div class="form-group mb-4">

                            <input type="password" id="password" placeholder=" الرقم السري الجديد"
                                   class="form-control @error('password') is-invalid @enderror"
                                   wire:model="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">

                            <input type="password" id="email" placeholder="اعادة الرقم السري الجديد  "
                                   class="form-control"
                                   wire:model="password_confirmation">

                        </div>
                        <button class="button-38  ml-5" type="submit">
                            تحديث
                            <div wire:loading wire:target="editPassword">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="sr-only">Loading...</span>
                            </div>

                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
