@extends('payment.master')

@section('content')
    <div class="branding">
        <h1 aria-label="Himalayan Bank Limited">
            Payment of {{ $currency_code == '840' ? '$' : 'Rs.' }}{{ number_format($amount / 100, 2) }}
            <br><br>
            <img src="{{ asset('vendor/payment/img/hbl-logo.jpg') }}" alt="Himalayan Bank Limited">
        </h1>
        @if ($clickContinue == true)
            <p>
                Payment Pending...
            </p>
            <p>
                Please click on "Proceed" to continue to the payment page.
                <br>
                Please do not reload/refresh this page.
            </p>
        @else
            <p>
                Please wait...
            </p>
            <p>
                You will be automatically redirected to the payment page.
                <br>
                Please do not reload/refresh this page.
            </p>
            @include('payment.svg.loading')
        @endif
    </div>
    <form action="{{ $transaction_url }}" method="post" id="hbl-form">
        {{-- Generate Hidden Fields for required data --}}
        @inject('hbl', 'App\Services\Payment\Gateway\Hbl\ExpressGateway')

        @foreach (['amount', 'invoice_no', 'product_desc', 'currency_code', 'non_secure', 'payment_gateway_ID', 'hash_value'] as $field)
            {!! $hbl->generateField(Str::camel($field), $$field, 'hidden') !!}
        @endforeach

        {{-- Checking if User defined values are present and adding maximum of 5 --}}
        @if (isset($user_defined_values))
            @foreach ($user_defined_values as $key => $value)
                @if ($key > 4) @break @endif
            	{!! $hbl->generateField('userDefined' . ++$key, $value, 'hidden') !!}
        	@endforeach
    	@endif

		{{-- Check if Click to continue is enabled --}}
		<input type="submit" class="btn" value="Proceed to Payment">
		@if ($clickContinue != true)
			<br>
			<small>Click the button above if not redirected.</small>
		@endif
	</form>
@endsection

@if ($click_continue == false)
	@section('javascript')
		<script>
			var hblApp = {
				init() {
					hblApp.submit();
				},
				submit() {
					document.querySelector('#hbl-form').submit();
				}
			}
			window.onload = function() {
				hbl_submit = setTimeout(hblApp.init, {{ $redirect_wait }})
			}
		</script>
	@endsection
@endif
