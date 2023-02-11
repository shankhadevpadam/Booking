@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.FlatPickr', true)

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
            <form role="form" method="POST" action="{{ route('admin.coupons.update', ['coupon' => $coupon]) }}">

                @csrf

                @method('PATCH')

                <x-adminlte-card>

                    <x-adminlte-select2 label="Package" name="package_id">
                        <option value="">Select package</option>
                        @if ($packages)
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" @selected(old('package_id', $coupon->package_id) == $package->id)>{{ $package->name }}</option>
                            @endforeach
                        @endif
                    </x-adminlte-select2>

                    <x-adminlte-input label="Name" name="name" :value="$coupon->name" autocomplete="off" />

                    <x-adminlte-input label="Code" name="code" :value="$coupon->code" autocomplete="off" />
                        
                    <x-adminlte-select2 label="Type" name="discount_type">
                        @foreach($discountTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_type', $coupon->discount_type?->value) == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-select2 label="Discount Apply On" name="discount_apply_on">
                        @foreach ($discountApplyOnTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_apply_on', $coupon->discount_apply_on?->value) == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Amount / Percentage" name="discount_amount" :value="$coupon->discount_amount" autocomplete="off" />

                    <x-adminlte-input label="Coupon Limit" name="limit" :value="$coupon->limit" autocomplete="off" />

                    <x-adminlte-input label="Expire Date" class="datepicker" name="expire_date" :value="$coupon->expire_date->toDateString()" autocomplete="off" />

                    <button type="submit" class="btn btn-primary">Update</button>
                    
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