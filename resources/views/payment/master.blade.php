<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>@yield('title', 'Payment')</title>

	<link rel="stylesheet" href="{{ asset('vendor/payment/css/style.css') }}">
	
	@yield('css')

</head>
<body>

	<div class="main-wrapper">
		<div class="content">
			@yield('content')
		</div>
		<div class="copyright">
			<ul>
				<li>
					Copyright &copy; {{ date('Y') }}
				</li>
			</ul>
		</div>
	</div>

	@yield('javascript')

</body>
</html>