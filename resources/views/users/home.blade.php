@extends('adminlte::page')

@section('title', $title ?? $userPackage->user->name)

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('plugins.Moment', true)

@section('plugins.Pikaday', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

    @if (auth()->user()->unreadNotifications->count())
        <x-adminlte-alert theme="light" icon="" dismissable>
            <i class="far fa-bell"></i>
            &nbsp;<i>We hope you had an amazing trip. Please <a href="{{ route('reviews.create') }}" class="text-blue">click here</a> for your review.</i>
        </x-adminlte-alert>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('booking.create') }}" class="btn btn-primary mb-2">New Booking</a>
            
            <x-adminlte-card>
                <x-adminlte-card body-class="table-responsive">
                    <x-datatable 
                        id="bookings"
                        :table-header="['ID', 'Package', 'Start Date', 'End Date']"
                    >
                        <tbody>
                            @foreach ($userPackages as $userPackage)
                                <tr>
                                    <td>{{ $userPackage->id }}</td>
                                    <td><a href="{{ route('package.departure', $userPackage->id) }}">{{ $userPackage->package->name }}</a></td>
                                    <td>{{ $userPackage->start_date->format('D M j, Y') }}</td>
                                    <td>{{ $userPackage->end_date->format('D M j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-datatable>
                </x-adminlte-card>
            </x-adminlte-card>
        </div>
    </div>

@stop

@section('js')
	@include('admin.includes.scripts')

    <script>
        $(document).ready(function () {
            $('#bookings').DataTable({
                order: [[ 0, "desc" ]],
            });
        });
    </script>
@stop
