@extends('adminlte::page')

@section('title', $title ?? '')

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.airlines.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.airlines.update', ['airline' => $airline]) }}">

                @csrf

                @method('PATCH')

                <x-adminlte-card>

                    <x-adminlte-input label="Name" name="name" :value="$airline->name" autocomplete="off" />
    
                    <button type="submit" class="btn btn-primary">Update</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop