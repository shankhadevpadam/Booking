@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('home') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <form role="form" method="POST" action="{{ route('profile.update') }}">
                    
                @csrf

                @method('PATCH')
                
                <x-adminlte-card>

                    <x-adminlte-input label="Name" name="name" :value="$user->name" />

                    <x-adminlte-input label="Email" name="email" :value="$user->email" disabled />

                    <x-adminlte-input type="password" label="Password" name="password" />

                    <div class="text-info">[Please enter the password if you want to change.]</div>

                    <button type="submit" class="btn btn-primary">Update</button>

                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
	@include('admin.includes.scripts')
@stop