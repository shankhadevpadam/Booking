@extends('adminlte::page')

@section('title', 'Waiting for Approval')

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <x-adminlte-card title="Waiting for Approval" theme="blue">
                <p>Your account is waiting for our administrator approval. <br> Please check back later.</p>
            </x-adminlte-card>
        </div>
    </div>
@endsection