@extends('adminlte::page')

@section('title', $title ?? '')

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.packages.discounts.index', ['package' => $package]) }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" action="{{ route('admin.packages.discounts.store', ['package' => $package]) }}" method="POST">
                @csrf

                <x-adminlte-card>

                    <x-adminlte-select label="Minimum number of people" name="min_number_of_people">
                        @for ($i = 1; $i<=20; $i++)
                            <option value="{{ $i }}" {{ $i === (int) old('min_number_of_people') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                        @endfor
                    </x-adminlte-select>

                    <x-adminlte-select label="Maximum Number of people" name="max_number_of_people">
                        @for ($i = 1; $i<=20; $i++)
                            <option value="{{ $i }}" {{ $i === (int) old('max_number_of_people') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                        @endfor

                        <option value="100" {{ (int) old('max_number_of_people') === 100 ? 'selected="selected' : '' }}>Above</option>
                    </x-adminlte-select>

                    <x-adminlte-input label="Price" name="price" :value="old('price')" />

                    <button type="submit" class="btn btn-primary">Create</button>

                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop