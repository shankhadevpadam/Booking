@extends('adminlte::page')

@section('title', $title ?? $userPackage->user->name)

@section('plugins.Sweetalert2', true)

@section('plugins.Moment', true)

@section('plugins.Pikaday', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-sm-12">
        </div>
    </div>

@stop

@section('js')
	@include('admin.includes.scripts')

    <script>
        $(document).ready(function () {
            $('.datepicker').pikaday({ format: 'YYYY-MM-DD' });
        });
    </script>
@stop
