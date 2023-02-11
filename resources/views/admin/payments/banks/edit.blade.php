@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Select2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.banks.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.banks.update', ['bank' => $bank->id]) }}">

                @csrf

                @method('PATCH')

                <x-adminlte-card>

                    <x-adminlte-input label="Name" name="name" :value="$bank->name" autocomplete="off" />

                    <x-adminlte-input label="Code" name="code" :value="$bank->code" autocomplete="off" />

                    <x-adminlte-select2 label="Type" name="type">
                        <option value="pos" @selected(old('type', $bank->type) == 'pos')>Pos</option>
                        <option value="card" @selected(old('type', $bank->type) == 'card')>Card</option>
                    </x-adminlte-select2>

                    <x-adminlte-input label="Charge (%)" name="charge" :value="$bank->charge" autocomplete="off" />

                    <button type="submit" class="btn btn-primary">Update</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop