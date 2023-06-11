<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href='{{ asset('assets/css/index.css') }}'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href='https://fontawesome.com/v4.7.0/icon/bars'>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <title>نبض</title>

</head>


<body>
<!--Scroll to top button-->
<button onclick="topFunction()" id="myBtn" class="fas fa-arrow-up"></button>
<!-- Home Page -->
<header>
    <video autoplay muted loop plays-inline id="homevideo">
        <source src="{{ asset('assets/video/homevideo1.mp4') }}" type="video/mp4">
    </video>
    <div id="logo"><a href="{{ route('index') }}"><img src="{{ asset('assets/logo/logo-light.svg') }}"></a>
    </div>
    <div id="nav">
        <div class="header-list" id="headerl">
            <i class="fa fa-times" onclick="hideMenu()"></i>
            <ul>
                <li><a href="{{ route('donation') }}">تبرع</a></li>
                <li><a class="scroll" href="#vol-sect">أبطالنا</a></li>
                <li><a class="scroll" href="#about-us">نحن</a></li>
                @if(!Auth::check())
                    <li><a href="{{ route('login') }}"> تسجيل الدخول</a></li>
                @else
                    <li>
                        <a href="#" onclick="event.preventDefault(); $('#logout-form').submit();">{{ __('logout') }}</a>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        <button type="submit">Log Out</button>
                    </form>
                @endif
            </ul>
        </div>
        <i class="fa fa-bars" onclick="showMenu()"></i>
    </div>
    <div class="text-box">
        <h1> ابدأ </h1>
        <p>تبرعك بالدم ممكن ينقذ حياة انسان</p>
        @if(!Auth::check())
            <a href='{{ route("register") }}' class="hero-btn">سجل الان</a>
        @else
            <a href='{{ route("donation") }}' class="hero-btn">تبرع</a>

        @endif
    </div>
</header>

<!--ABOUT US -->

<main>
    <section id="about-us">
        <div class="about">
            <h1 class="heading">من نحن ؟</h1> <br>
            <p class="head-des text" >نقوم بحل مشكلة طوارئ الدم عن طريق الاتصال <span
                    class="one-line"><br></span> بالمتبرعين بالدم مباشرة مع الأشخاص المحتاجين للدم</p>
            <div class="row">
                <div class="about-col">
                    <div class="image">

                        <img src=" {{ asset('assets/Images/record.png')}}" alt="record">
                    </div>

                    <p>موقعنا يساعد المراكز علي تسجيل عمليات التبرع بطريقة فعاله</p>
                </div>
                <div class="about-col">
                    <div class="image">

                        <img src=" {{ asset('assets/Images/health.png')}}" alt="health">
                    </div>

                    <p>موقعنا هو نهج مبتكر للتعامل مع الصحة العالمية </p>
                </div>
                <div class="about-col">
                    <div class="image">
                        <img src="{{ asset('assets/Images/hospital.png')}}" alt="hospital">
                    </div>

                    <p>موقعنا يساعد المتبرعين علي ايجاد اقرب مركز لتقديم التبرع.</p>
                </div>
                <div class="about-col">
                    <div class="image">
                        <img src="{{ asset('assets/Images/motiv.png')}}" alt="motivation">
                    </div>
                    <p> موقعنا يعمل علي تجشيع وحث الناس علي تقديم التبرع
                         </p>
                </div>
                <div class="about-col">
                    <div class="image">
                        <img src="{{ asset('assets/Images/appointment.png')}}" alt="appointment">
                    </div>
                    <p> موقعنا يساعد المتبرعين علي ايجاد الوقت المناسب لهم لتقديم التبرع</p>
                </div>
                <div class="about-col">
                    <div class="image">
                        <img src="{{ asset('assets/Images/result.png')}}" alt="result">
                    </div>
                    <p> موقعنا يساعد المتبرعين علي معرفة نتيجة تبرعهم فوريا وطباعتها  </p>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Volunteer Section -->

<div class="volunteer"  id="vol-sect">
    <div class="title-head">
        <h1 class="title">أبطالنا</h1>
    </div>
    <p class="content">نشكر جميع متبرعي الدم الكرام على كرمهم وإنسانيتهم العظيمة، ونتمنى أن يستمروا في هذا العمل النبيل لمساعدة الآخرين وإنقاذ الأرواح.</p>
    <ul class="volunt">
        @foreach($topDonors as $donor)

        <li class="vol">
            <span class="vol-i number">{{ $loop->iteration }}</span>
            <span class=" vol-i name">{{$donor->name}}</span>
            <span class=" vol-i blood group text-center mr-5">{{$donor->blood_type}}<i class="fa fa-tint" aria-hidden="true"></i>
                </span>
            <span class=" vol-i location">{{$donor->donation_count}}</span>

        </li>
        @endforeach

    </ul>
</div>


<!--FOOTER-->

<footer>
    <div class="siteFooterBar">
        <div class="content1">
            <div class="foot mb-5">2023 © All rights reserved.</div>
        </div>
    </div>
    <div class="footer-content ">
        <p>من بين كل عشرة أشخاص يدخلون المستشفى يحتاج مريض واحد لنقل الدم بشكل ضروري لعلاج المرض أو إنقاذ الحياة</p>
     
    </div>


</footer>
<!--Javascript for pre-loader-->

<script>
    const preloader = document.querySelector('.preloader');
    const fadeEffect = setInterval(() => {
        if (!preloader.style.opacity) {
            preloader.style.opacity = 1;
        }
        if (preloader.style.opacity > 0) {
            preloader.style.opacity -= 1.5;
        } else {
            clearInterval(fadeEffect);
        }
    }, 1500);
    window.addEventListener('load', fadeEffect);
</script>
<!--js for scroll to top-->
<script src="{{asset('assets/js/up.js')}}"></script>

<!--JAVASCRIPT FOR TOGGLE MENU -->
<script>
    var headerl = document.getElementById("headerl");

    function showMenu() {
        headerl.style.right = "0";
    }

    function hideMenu() {
        headerl.style.right = "-210px";
    }
</script>


<!--js for scroll effects-->

<script src="{{ asset('assets/js/scroll.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
