@extends('layouts.donate')
@section('title')
    {{ __('prev_appointment')  }}
@endsection
@section('content')
@livewire('appointments')
@endsection