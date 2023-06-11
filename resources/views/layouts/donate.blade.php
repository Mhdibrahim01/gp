<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href='{{ asset('assets/css/donate.css')}}'>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>


    <link rel="icon" href="{{ asset('favicon.ico') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    @livewireStyles()
<title> نبض- @yield('title')</title>
</head>

<body>

<header>
    <div id="logo"><a href="{{ route('index') }}"><img src="{{ asset('assets/logo/logo-light.svg') }}" alt="log"></a>
    </div>
    <div id="nav">
        <div class="header-list" id="headerl">
            <ul>
                <li><a href="{{ route('donation') }}">تبرع</a></li>
                <li class="active"><a href="{{ route('prevdonation') }}">{{ __('prev_donation') }}</a></li>
                <li><a href="{{ route('appointments') }}">{{ ((__('prev_appointment'))) }}</a></li>
                <li><a href="{{ route('profile') }}">{{ ((__('profile'))) }}</a></li>

                <li>
                    <a href="#" onclick="event.preventDefault(); $('#logout-form').submit();">{{ __('logout') }}</a>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    <button type="submit">Log Out</button>
                </form>
            </ul>
        </div>
    </div>

</header>


<main>
    @yield('content')
</main>


</body>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@livewireScripts()
</html>
