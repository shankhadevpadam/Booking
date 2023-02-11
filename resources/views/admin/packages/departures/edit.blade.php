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
        	<a class="btn btn-primary" href="{{ route('admin.packages.departures.index', ['package' => $packageId]) }}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form role="form" method="POST" action="{{ route('admin.packages.departures.update', ['package' => $packageId, 'departure' => $departureId]) }}">

                @csrf

                @method('PATCH')

                <x-adminlte-card>
                    
                    <x-adminlte-input label="Start Date" id="start-date" name="start_date" :value="$departure->start_date->format('Y-m-d')" autocomplete="off" />

                    <x-adminlte-input label="End Date" id="end-date" name="end_date" :value="$departure->end_date->format('Y-m-d')"  autocomplete="off">
                        <x-slot name="bottomSlot">
                            <span id="number-of-days" class="text-info">Number of days: {{ $departure->end_date->diffInDays($departure->start_date) }}</span>
                        </x-slot>
                    </x-adminlte-input>

                    <x-adminlte-input label="Price" name="price" :value="$departure->price" />

                    <x-adminlte-select2 label="Discount Type" name="discount_type">
                        <option value="">Please select discount type</option>
                        @foreach($discountTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_type', $departure->discount_type?->value) == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-select2 label="Discount Apply On" name="discount_apply_on">
                        <option value="">Please select discount apply on</option>
                        @foreach($discountApplyOnTypes as $type)
                            <option value="{{ $type->value }}" @selected(old('discount_apply_on', $departure->discount_apply_on?->value) == $type->value)>{{ $type->name }}</option>
                        @endforeach
                    </x-adminlte-select2>

                    <x-adminlte-input label="Discount Amount / Percentage" name="discount_amount" :value="$departure->discount_amount" />

                    <x-adminlte-input label="Sold Quantity" name="sold_quantity" :value="$departure->sold_quantity" />

                    <x-adminlte-input label="Total Quantity" name="total_quantity" :value="$departure->total_quantity" />

                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>

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