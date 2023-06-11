<div>
    <div class="container my-5 p-lg-5 shadow">
        <div class="card p-0">
            <div class="card-body">
                <h5 class="card-title text-center">الميعاد الحالي</h5>
                @if($last_appointment)
                    @if($last_appointment->slot->date > now()->format('Y-m-d'))

                        <ul class="list-group">
                            <li class="list-group-item">{{ __('center_name') }}
                              : <span class="list_an">  {{ $last_appointment->slot->center->name }} </span></li>
                            <li class="list-group-item">{{ __('date') }}:   <span class="list_an"> {{ $last_appointment->slot->date }} </span></li>
                            <li class="list-group-item">{{ __('Time') }}:  <span class="list_an"> {{ $last_appointment->slot->start_time }}</span></li>
                            <li class="list-group-item">{{ __('address')}}
                                :   <span class="list_an">{{ $last_appointment->slot->center->address }}</span></li>
                            <li class="list-group-item">{{ __('appointment_no')}}
                                :  <span class="list_an"> {{ $last_appointment->appointment_no }}</span></li>
                        </ul>
                      <button class="btn btn-warning button">  <a wire:click='cancel' >    الغاء الحجز  <div wire:loading wire:target="cancel">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="sr-only">Loading...</span>
                    </div> </a> </button>
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
