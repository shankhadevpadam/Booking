@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Select2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.locations.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.locations.update', ['location' => $location]) }}">

                @csrf

                @method('PATCH')

                <x-adminlte-card>

                    <x-adminlte-input label="Name" name="name" :value="$location->name" autocomplete="off" />

                    <x-adminlte-select2 label="Type" name="type">
                        @foreach ($types as $type)
                            <option value="{{ $type->value }}" @selected(old('type', $location->type) == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>
    
                    <button type="submit" class="btn btn-primary">Update</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop