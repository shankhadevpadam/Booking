@extends('emails.layouts')

@section('content')
	
	{!! setting('notify_admin_user_arrival_message', 'No email template found.') !!} <br />

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
            <tr>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->user->name }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->user->email }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->start_date->toDateString() }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->end_date->toDateString() }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->arrival_date->toDateString() }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->arrival_time->toTimeString() }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->flight_number }}</td>
                <td style="border: 1px solid black; border-collapse: collapse; padding: 5px;">{{ $data->airport_pickup }}</td>
            </tr>
        </tbody>
    </table>
	
@endsection
															