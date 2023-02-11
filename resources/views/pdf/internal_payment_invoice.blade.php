<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name=viewport content="width=device-width, initial-scale=1.0">
	<title>Payment Invoice</title>
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
                    <p><strong>{{ $user['name']  }}</strong><br>{{ $user['country']['name'] }}<br> Email: {{ $user['email'] }}</p>
                </div>
            </div>

            <div class="invoice-number">
                <h3>Invoice: {{ time() }}</h3>
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
                            <h4>{{ $package['name'] }}</h4>
                        </td>
                        <td>{{ $number_of_trekkers }}</td>
                        <td class="text-right">{{ number_format($amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table invoice-calculate">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-right">
                            <h4>Total</h4>
                            <small>Payment on {{ date('d M') }} using {{ Str::headline($payment_method) }}</small>
                        </td>
                        <td class="last text-right">
                            <h4>{{ number_format($amount, 2) }}</h4>
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
                                    <span class="highlight">{{ $start_date }}</span>
                                </td>

                                <td>
                                    <strong>Trek End Date:</strong><br>
                                    <span class="highlight">{{ $end_date }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Payment Details</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Method</strong></td>
                                <td class="highlight">{{ Str::headline($payment_method) }}</td>
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
