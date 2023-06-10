@extends('donation')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="card donorInfo" >
                <div class="card-body shadow">
                    <h5 class="card-title text-center"></h5>
                    <ul class="list-group">
                        <li class="list-group-item">{{ __('lastDonationDate') }}
                            :  {{auth()->user()->donor->last_donation_date}}
                        </li>
                        <li class="list-group-item">{{ __('nextDonationDate') }}: {{auth()->user()->donor->last_donation_date== null ? 'يمكنك الان' : Carbon\Carbon::parse(auth()->user()->donor->last_donation_date)->addMonth(3)->translatedFormat('Y-m-d')}}</li>
                        <li class="list-group-item">{{ __('totalDonation') }}: {{auth()->user()->donor->total_donations}}</li>
                        <li class="list-group-item">{{ __('bloodType') }}:  {{auth()->user()->donor->bloodType->blood_type?? ''}}</li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="mt-2">
            <div class="row ">
                <div class=" my-5 p-lg-2 shadow">
                    <div class="d-flex justify-content-center pb-2">

                        <h1 class="h3 card-title ">تبرعاتك السابقة</h1>
                    </div>
                </div>
            </div>
            <div class="row second shadow">
                <table>
                    <thead class="donationHead">
                    <tr>
                        <th colspan="4"></th>
                    </tr>
                    <tr class="text-center">
                        <th>{{__('donation_date')}}</th>
                        <th>{{__('center')}}</th>
                        <th>{{__('status')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @isset($donations)

                        @foreach($donations as $donate)

                            <tr class="text-center">
                                <td>{{$donate->donation_date}}</td>
                                <td>{{$donate->center->name}}</td>
                                <td>{{$donate->is_approved ? 'قبلت' : 'رفضت'}}</td>
                                <td class="booking-buttons">

                                    <form id="printDonationForm" method="POST" action="{{ route('printDonation') }}"
                                          target="_blank">
                                        @csrf
                                        <input type="hidden" name="donation_id" value="{{ $donate->id }}">
                                        <button type="submit" class="btn btn-primary button-print">
                                            <span>{{ __('print') }} <i class="fa fa-print"></i></span>
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>

        <div>

@endsection
