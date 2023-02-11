@extends('payment.master')

@section('title', 'NicAsia Bank - Processing Payment')

@section('content')
    <div class="branding">
        <h1 aria-label="NicAsia Bank Limited">
            Payment of {{ $currency_code == 'USD' ? '$' : 'Rs.' }}{{ number_format($amount, 2) }}
            <br><br>
            <img src="{{ asset('vendor/payment/img/nic-asia-logo.png') }}" alt="NIC ASIA Bank Limited">
        </h1>
        <p>
            Please wait...
        </p>
        <p>
            You will be automatically redirected to the payment page.
            <br>
            Please do not reload/refresh this page.
        </p>

		@include('payment.svg.loading')
    </div>
    <form action="{{ $transaction_url }}" method="post" id="nicAsia-form">
        <input type="hidden" name="access_key" value="{{ $access_key }}">
        <input type="hidden" name="profile_id" value="{{ $profile_id }}">
        <input type="hidden" name="transaction_uuid" value="{{ $uuid }}">
        <input type="hidden" name="signed_field_names"
            value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code">
        <input type="hidden" name="unsigned_field_names" value="card_type,card_number,card_expiry_date">
        <input type="hidden" name="signed_date_time" value="{{ $signed_date_time }}">
        <input type="hidden" name="locale" value="en">
        <input type="hidden" name="auth_trans_ref_no">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="bill_to_forename" value="Magical">
        <input type="hidden" name="bill_to_surname" value="Nepal">
        <input type="hidden" name="bill_to_email" value="info@magicalnepal.com">
        <input type="hidden" name="bill_to_phone" value="+977-9841773981">
        <input type="hidden" name="bill_to_address_line1" value="Kathmandu">
        <input type="hidden" name="bill_to_address_city" value="Kathmandu">
        <input type="hidden" name="bill_to_address_state" value="Kathmandu">
        <input type="hidden" name="bill_to_address_country" value="NP">
        <input type="hidden" name="bill_to_address_postal_code" value="Kathmandu">
        <input type="hidden" name="transaction_type" value="sale">
        <input type="hidden" name="reference_number" value="{{ $ref_number }}">
        <input type="hidden" name="currency" value="USD">
        <input type="hidden" name="payment_method" value="card">
        <input type="hidden" name="signature" value="{{ $signature }}">
        <input type="hidden" name="card_type" value="001">
        <input type="hidden" name="card_number" value="">
        <input type="hidden" name="card_expiry_date" value="">
    </form>
@endsection

@section('javascript')
    <script>
        var nicAsiaApp = {
            init() {
                nicAsiaApp.submit();
            },
            submit() {
                document.querySelector('#nicAsia-form').submit();
            }
        }
        window.onload = function() {
            nicAsia_submit = setTimeout(nicAsiaApp.init, {{ $redirect_wait }})
        }
    </script>
@endsection
