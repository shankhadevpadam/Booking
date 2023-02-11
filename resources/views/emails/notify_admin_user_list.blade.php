@extends('emails.layouts')

@section('content')
	
	{!! setting('notify_admin_user_list_message', 'No email template found.') !!} <br />

	<table style="border: 1px solid black; border-collapse: collapse;">
        <thead>
            <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Name</th>
            <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Email</th>
            <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Start Date</th>
            <th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">End Time</th>
			<th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Arrival Date</th>
			<th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Arrival Time</th>
			<th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Flight Number</th>
			<th style="border: 1px solid black; border-collapse: collapse; padding: 5px;">Pick Up</th>
        </thead>

        <tbody>
			@foreach ($data as $value)
				<tr>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['name']}}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['email'] }}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['start_date'] }}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['end_date'] }}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['arrival_date'] }}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['arrival_time'] }}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['flight_number'] }}</td>
					<td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $value['airport_pickup'] }}</td>
				</tr>
			@endforeach
        </tbody>
    </table>
	
@endsection
															