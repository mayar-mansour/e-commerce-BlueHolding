@extends('layoutmodule::layouts.main')

@section('title')
    {{ __('messages.admin') }}
@endsection

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <div style="text-align: center">
                <img src="{{ asset('/assets/images/logo-esf-300.jpeg') }}" alt="Platform Logo" class="logo" style="width: 270px;">
                <h3 class="mt-4">eCommerce Admin Panel</h3>
                <p class="mt-4">We are currently working on improvements. Exciting features will be available soon.</p>
            </div>

        </div>
    </div>
@endsection
