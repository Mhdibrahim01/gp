<div>
    <div class="container-fluid ">
        <div class="row firstd rounded-top-4">
            <div class=" my-5 p-lg-3 shadow ">
                <div class="d-flex justify-content-center pb-2">
                    <h1 class="h3">احجز ميعاد لتقديم تبرعك</h1>

                </div>

                <div class="d-flex">

                    <div class="input-group mb-3  ps-4 pe-4">
                     
                        <select class="form-select" id="inputGroupSelect02" wire:model.lazy="selectedCenter">
                       
                            <option value=""> {{ __('select_center') }}</option>
                            @foreach ($centers ?? [] as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        
                        </select>
                        <label class="input-group-text" for="inputGroupSelect02">المركز</label>

                    </div>

                    <div class="input-group mb-3 ps-4 pe-4">
                        <select class="form-select" id="inputGroupSelect0" wire:model="selectedGov"
                                wire:change="changeGov">
                            <option value="-1">{{ __('select_gov') }}</option>
                            @foreach ($governments as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <label class="input-group-text" for="inputGroupSelect0">المحافظة</label>

                    </div>

                </div>
                <div wire:loading wire:target="selectedCenter">
                    ...
                </div>
            </div>
        </div>

        @if ($selectedCenter)

            @if (count($appointments))
                <div class="row socendT shadow rounded-2 py-2">

                    <table>
                        <thead>
                        <tr>
                            <th colspan="4"></th>
                        </tr>
                        <tr class=" text-center">
                            <th>التاريخ</th>
                            <th>الميعاد</th>
                            <th> السعة المتبقية</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($appointments as $appointment)
                            <tr class=" text-center">
                                <td>{{ $appointment->date }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</td>
                                <td>{{ $appointment->available_capacity }}</td>
                                <td>

                                    @if ($canBookAppointment)
                                        @if ($appointment->userHasAppointment)
                                            <button class="btn-warning btn btn btn-block button-cancel"
                                                    wire:click="cancelAppointment({{ $appointment->id }})">
                                                الغاء
                                                @else
                                                    <button class="btn-success btn btn-block button-book"
                                                            wire:click="bookAppointment({{ $appointment->id }})">
                                                        حجز
                                                    </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    @else
                        <div>
                            <table>
                                <thead>
                                <tr>
                                    <th class="text-center" colspan="3"></th>
                                </tr>
                                <tr class=" text-center">
                                    <th>التاريخ</th>
                                    <th>الميعاد</th>
                                    <th> السعة المتبقية</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr class="text-center">
                                    <td></td>
                                    <td><p class="text-center">لا يوجد مواعيد متاحة لهذا المركز</p></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                            @endif

                            @endif
                        </div>
                </div>
    </div>
</div>
