@extends('layouts.auth')
@section('title')
    تسجيل الدخول
@endsection
@section('content')
    <div class="container login-form">
        <div class="col-md-12">
               @livewire('login')
        </div>
    </div>
@endsection