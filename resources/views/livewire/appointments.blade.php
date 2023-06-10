<div>
    <div class="container my-5 p-lg-5 shadow">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">الميعاد الحالي</h5>
                @if($last_appointment)
                    @if($last_appointment->slot->date > now()->format('Y-m-d'))

                        <ul class="list-group">
                            <li class="list-group-item">{{ __('center_name') }}
                                : {{ $last_appointment->slot->center->name }}</li>
                            <li class="list-group-item">{{ __('date') }}: {{ $last_appointment->slot->date }}</li>
                            <li class="list-group-item">{{ __('Time') }}: {{ $last_appointment->slot->start_time }}</li>
                            <li class="list-group-item">{{ __('address')}}
                                : {{ $last_appointment->slot->center->address }}</li>
                            <li class="list-group-item">{{ __('appointment_no')}}
                                : {{ $last_appointment->appointment_no }}</li>
                        </ul>
                      <button class="btn btn-warning button">  <a wire:click='cancel' > الغاء الحجز </a> </button>
                    @else

                        <p class="text-center pa">ليس لديك مواعيد حاليه</p>

                    @endif
                @else
                    <p class="text-center pa">ليس لديك مواعيد حاليه</p>
                @endif
            </div>
        </div>

    </div>

</div>
