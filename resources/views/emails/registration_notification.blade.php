@extends('emails.layouts')

@section('content')
	@php
		$due_amount = $latest_user_package['total_amount'] - $latest_user_package['latest_payment']['amount'];

		$email = EmailTemplate::from(setting('user_registration_notification_message', 'No email template found.'), [
			'name' => $name,
			'trip_name' => $latest_user_package['package']['name'],
			'trek_date' => $latest_user_package['departure']['start_date'],
			'arrival_date' => $latest_user_package['arrival_date'],
			'arrival_time' => $latest_user_package['arrival_time'],
			'flight_number' => $latest_user_package['flight_number'],
			'airport_pickup' => $latest_user_package['airport_pickup'],
			'total_payment' => number_format($latest_user_package['total_amount'], 2),
			'remaining_payment' => number_format($due_amount, 2),
			'bank_charge' => setting('bank_charge'),
		])->parse();
	@endphp

	{!! $email !!}

@endsection
															