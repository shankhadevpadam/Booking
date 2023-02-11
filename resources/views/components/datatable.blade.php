@props([
	'id' => '',
	'class' => '',
	'tableHeader' => '',
	'checkAll' => false,
])

<table id="{{ $id }}" {{ $attributes->merge(['class' => 'table table-striped table-hover '. $class]) }}>
	@if ($tableHeader && is_array($tableHeader))
		<thead>
			<tr>
				@if ($checkAll)
					<th><input type="checkbox" id='checkall'></th>
				@endif
				
				@foreach ($tableHeader as $header)
					<th>{{ __($header) }}</th>
				@endforeach
			</tr>
		</thead>
	@endif

	{{ $slot }}
</table>