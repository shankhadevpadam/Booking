@extends('payment.master')

@section('content')
    <div class="branding">
        <h1 aria-label="Himalayan Bank Limited">
            Oops.
            <br><br>
            <img src="{{ asset('vendor/payment/img/hbl-logo.jpg') }}" alt="Himalayan Bank Limited">
        </h1>
        <p>
            Something went wrong!
        </p>
        <p class="text-primary bg mb">
            {{ $message }}
        </p>
        @include('payment.svg.fire')
    </div>
@endsection
