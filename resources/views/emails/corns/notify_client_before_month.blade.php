@extends('emails.layouts')

@section('content')

	Hi, {{ $emailData['client_name'] }}

	This is an automated email. It looks like you haven't filled the trekking start date and your arrival details. Please fill the information as soon as you can. It will help us to run your trip smoothly.
	
@endsection