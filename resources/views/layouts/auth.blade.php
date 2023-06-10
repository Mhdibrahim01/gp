<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    @livewireStyles()
    <title>@yield('title')-نبض</title>

</head>

<body dir=rtl>

<header>
    <div id="logo"><a href="{{ route('index') }}"><img src="{{ asset('assets/logo/logo-light.svg') }}" alt="logo"></a>
    </div>
    <div id="nav">
        <div class="header-list" id="headerl">
            <ul>
                <li><a href="{{ route('donation') }}">تبرع</a></li>
                <li class="active"><a href="{{ route('prevdonation') }}">{{ __('prev_donation') }}</a></li>
                <li><a href="{{ route('appointments') }}">{{ ((__('prev_appointment'))) }}</a></li>

                <li><a class="scroll" href="#about-us">نحن</a></li>
            </ul>
        </div>
    </div>
</header>

<main>
    <div class="box">




        <main>

                    @yield('content')

        </main>



    </div>


</main>


<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

@livewireScripts()
</body>

</html>
