@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Moment', true)

@section('plugins.FlatPickr', true)

@section('plugins.Select2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.packages.departures.index', ['package' => $package]) }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" action="{{ route('admin.packages.departures.store', ['package' => $package]) }}" method="POST">
                @csrf

                <x-adminlte-card>
                    
                    <x-adminlte-input label="Start Date" id="start-date" name="start_date" :value="old('start_date')" autocomplete="off" />

                    <x-adminlte-input label="End Date" id="end-date" name="end_date" :value="old('end_date')" autocomplete="off">
                        <x-slot name="bottomSlot">
                            <span id="number-of-days" class="text-info"></span>
                        </x-slot>
                    </x-adminlte-input>

                    <x-adminlte-input label="Price" name="price" :value="old('price')" />

                    <x-adminlte-select2 label="Discount Type" name="discount_type">
                        <option value="">Please select discount type</option>
                        @foreach($discountTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_type') == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-select2 label="Discount Apply On" name="discount_apply_on">
                        <option value="">Please select discount apply on</option>
                        @foreach($discountApplyOnTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_apply_on') == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Discount Amount / Percentage" name="discount_amount" :value="old('discount_amount')" />

                    <x-adminlte-input label="Total Quantity" name="total_quantity" :value="old('total_quantity')" />

                    <button type="submit" class="btn btn-primary">Create</button>

                </x-adminlte-card>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#start-date, #end-date').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today",
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if ($('#start-date').val() && $('#end-date').val()) {
                        let start = moment($('#start-date').val());
                        let end = moment($('#end-date').val());

                        $('#number-of-days').text('Number of days: ' + end.diff(start, "days"));
                    }
                }
            });
        });
    </script>
@stop