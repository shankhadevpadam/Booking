<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Pickup</th>
            <th>Package</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Booked Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userPackages as $userPackage)
            <tr>
                <td>{{ $userPackage->user->name }}</td>
                <td>{{ $userPackage->user->email }}</td>
                <td>{{ $userPackage->airport_pickup }}</td>
                <td>{{ $userPackage->package->name }}</td>
                <td>{{ $userPackage->start_date->toDateString() }}</td>
                <td>{{ $userPackage->end_date->toDateString() }}</td>
                <td>{{ $userPackage->created_at->toDateString() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>