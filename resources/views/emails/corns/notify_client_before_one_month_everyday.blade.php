@extends('emails.layouts')

@section('content')

	Hi, Magical Team

	The appointment date has been updated by {{ $email_data['client_email'] }}

@endsection