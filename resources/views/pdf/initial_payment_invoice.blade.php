<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name=viewport content="width=device-width, initial-scale=1.0">
	<title>Invoice</title>
	<link rel="stylesheet" href="{{ public_path('css/invoice.css') }}">
</head>
<body>
	<div class="wrapper">
		<div class="invoice-container">
            <div class="row invoice-header">
                <div class="col invoice-header_left">
                    <img src="{{ public_path('images/logo.png') }}" class="logo" width="270" alt="Magical Nepal">
                </div>
                <div class="col invoice-header_right">PAID</div>
            </div>

            <div class="row invoice-address">
                <div class="col invoice-address_left">
                    <p><strong>Magical Nepal</strong><br>Thamel, Kathmandu<br> Phone: 977-9841773981<br> Email: info@magicalnepal.com<br>Nepal</p>
                </div>
                <div class="col invoice-address_right text-right">
                    <p>BILL TO</p>
                    <p><strong>{{ $name }}</strong><br>{{ $country['name'] }}<br> Email: {{ $email }}</p>
                </div>
            </div>

            <div class="invoice-number">
                <h3>Invoice: {{ strtotime(now()) }}</h3>
                <div class="text-left">
                    <small>Invoice Date: {{ date('F d, Y') }}</small>
                </div>
                <div class="text-right"></div>
            </div>

            <hr class="borderinvoice">

            <table class="table invoice-table">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>No of Traveller</th>
                        <th class="text-right">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
							<h4>{{ Arr::get($latest_user_package, 'package.name') }}</h4>
						</td>
						<td>{{ $latest_user_package['number_of_trekkers'] }}</td>
						<td class="text-right">{{ number_format($latest_user_package['total_amount'], 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table invoice-calculate">
                <tbody>
                    @php($bankCharge = Arr::get($latest_user_package, 'latest_payment.bank_charge'))
                    
                    @if ($bankCharge > 0)
                        <tr>
                            <td colspan="2">Bank Charge</td>
                            <td align="right">{{ number_format($bankCharge, 2) }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="2" class="text-right">
                            <h4>Total</h4>
                            <small>Payment on {{ date('d F') }} using {{ Str::headline(Arr::get($latest_user_package, 'latest_payment.payment_method')) }}</small>
                        </td>
                        <td class="last text-right">
                            <h4>{{ number_format(Arr::get($latest_user_package, 'latest_payment.amount') + $bankCharge, 2) }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">
                            <h4>Due Amount (USD)</h4>
                        </td>
                        <td class="text-right">
                            @php($dueAmount = $latest_user_package['total_amount'] - Arr::get($latest_user_package, 'latest_payment.amount'))
							
							<h4>{{ number_format($dueAmount, 2) }}</h4>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row invoice-footer">
                <div class="col invoice-footer_left">
                    <table class="table invoice-details">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Trek Start Date:</strong><br>
                                    <span class="highlight">{{ Arr::get($latest_user_package, 'departure.start_date') }}</span>
                                </td>

                                <td>
                                    <strong>Trek End Date:</strong><br>
                                    <span class="highlight">{{ Arr::get($latest_user_package, 'departure.end_date') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Payment Details</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Method</strong></td>
                                <td class="highlight">{{ Str::headline(Arr::get($latest_user_package, 'latest_payment.payment_method')) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <small>Thank you for choosing Magical Nepal. We will assure you that you have an amazing time in Nepal.</small>
                </div>

                <div class="col invoice-footer_right">
                    <div class="box-stamp">
                        <div class="box-stamp_graphics">
                            <img src="{{ public_path('images/stamp.png') }}" alt="" width="220">
                            <img src="{{ public_path('images/signature.png') }}" alt="" class="box-stamp_signature" >
                        </div>
                        <div class="box-stamp_label">Authorised Stamp and Signature</div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</body>
</html>
