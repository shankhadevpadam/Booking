@extends('adminlte::page')

@section('title', $title ?? '')

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.currencies.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" action="{{ route('admin.currencies.store') }}" method="POST">
                @csrf

                <x-adminlte-card>

                    <x-adminlte-input label="Name" name="name" :value="old('name')" autocomplete="off" />

                    <x-adminlte-input label="Code" name="code" :value="old('code')" autocomplete="off" />

                    <x-adminlte-input label="Symbol" name="symbol" :value="old('symbol')" autocomplete="off" />

                    <button type="submit" class="btn btn-primary">Create</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop