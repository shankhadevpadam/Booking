@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.FlatPickr', true)

@section('plugins.FlatPickrRangePlugin', true)

@section('plugins.Select2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.coupons.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf

                <x-adminlte-card>

                    <x-adminlte-select2 label="Package" name="package_id">
                        <option value="">Select package</option>
                        @if ($packages)
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" @selected(old('package_id') == $package->id)>{{ $package->name }}</option>
                            @endforeach
                        @endif
                    </x-adminlte-select2>

                    <x-adminlte-input label="Name" name="name" :value="old('name')" autocomplete="off" />

                    <x-adminlte-input label="Code" name="code" :value="old('code')" autocomplete="off" />

                    <x-adminlte-select2 label="Type" name="discount_type">
                        @if ($discountTypes)
                            @foreach ($discountTypes as $type)
                                <option value="{{ $type->value }}" @selected(old('discount_type') === $type->value)>{{ $type->name }}</option>
                            @endforeach
                        @endif
                    </x-adminlte-select2>

                    <x-adminlte-select2 label="Discount Apply On" name="discount_apply_on">
                        @foreach ($discountApplyOnTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_apply_on') === $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Amount / Percentage" name="discount_amount" :value="old('discount_amount')" autocomplete="off" />

                    <x-adminlte-input label="Coupon Limit" name="limit" :value="old('limit')" autocomplete="off" />

                    <x-adminlte-input label="Expire Date" class="datepicker" name="expire_date" :value="old('expire_date')" autocomplete="off" />

                    <button type="submit" class="btn btn-primary">Create</button>
                    
                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.datepicker').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today",
                allowInput: true,
            });
        });
    </script>
@stop