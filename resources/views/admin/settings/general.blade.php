@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Select2', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

<form method="post" action="{{ route('admin.settings.general.update') }}">

	@csrf

	<div class="row">
		<div class="col-md-8 col-sm-12">
			<x-adminlte-card>

				<x-adminlte-input label="Site Title" name="site_title" :value="setting('site_title')" />
				
				<x-adminlte-input label="Admin Email" name="admin_email" :value="setting('admin_email')" />

				<x-adminlte-input label="Admin Mobile" name="admin_mobile" :value="setting('admin_mobile')" />

				<x-adminlte-input label="Manager Email" name="manager_email" :value="setting('manager_email')" />

				<x-adminlte-input label="Help Contact Text" name="help_contact_text" :value="setting('help_contact_text')" />

				<x-adminlte-input label="SMS Token" name="sms_token" :value="setting('sms_token')" />

				<x-adminlte-input label="Bank Charge" name="bank_charge" :value="setting('bank_charge')" />

				<x-adminlte-input label="Bank Charge Note" name="bank_charge_note" :value="setting('bank_charge_note')" />

				<x-adminlte-input label="Final Payment Note" name="final_payment_note" :value="setting('final_payment_note')" />

				<div class="form-group">
					<label for="Payment Method">Payment Method</label>
					<div>
						@foreach (App\Enums\PaymentMethod::cases() as $method)
							<input type="checkbox" name="payment_method[{{ $method->value }}]" @checked(setting('payment_method.' . $method->value) === 'on')> {{ $method->name }}
						@endforeach
					</div>
				</div>

				<x-adminlte-select label="Bank" name="bank_id">
					@php($banks = App\Models\Bank::where('type', 'card')->get())

					@if ($banks->isNotEmpty())
						@foreach ($banks as $bank)
							<option value="{{ $bank->id }}" @selected(setting('bank_id') == $bank->id)>{{ $bank->name }}</option>
						@endforeach
					@endif
				</x-adminlte-select>

				<x-adminlte-select label="Currency" name="currency_id">
					@php($currencies = App\Models\Currency::all())

					@if ($currencies->isNotEmpty())
						@foreach ($currencies as $currency)
							<option value="{{ $currency->id }}" @selected(setting('currency_id') == $currency->id)>{{ $currency->name }}</option>
						@endforeach
					@endif
				</x-adminlte-select>
				
				<button type="submit" class="btn btn-primary mt-2">Save Changes</button>

			</x-adminlte-card>
		</div>
	</div>
</form>

@stop

@section('js')
    @include('admin.includes.scripts')
@stop