@extends('emails.layouts')

@section('content')

    @php
        $email = EmailTemplate::from(setting($template, 'No email template found.'), $data)->parse();
    @endphp

    {!! $email !!}

@endsection