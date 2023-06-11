@extends('layouts.donate')
@section('title')
    {{ __('profile')  }}
@endsection
@section('content')

    <div class="container">
@livewire('edit-profile')
    </div>

@endsection

