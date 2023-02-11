@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Sweetalert2', true)

@section('plugins.SummerNote', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

<div class="row">
	<div class="col-sm-12 mb-2">
		<a class="btn btn-primary" href="{{ route('admin.settings.guide.email') }}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
	</div>
</div>

<form method="post" action="{{ route('admin.settings.guide.email.update') }}">

	@csrf

	<div class="row">
		<div class="col-md-8 col-sm-12">
			@php
				$config = [
					"height" => "250",
					"toolbar" => [
						['style', ['bold', 'italic', 'underline', 'clear']],
						['fontsize', ['fontsize']],
						['color', ['color']],
						['para', ['ul', 'ol', 'paragraph']],
						['table', ['table']],
						['insert', ['link']],
						['view', ['fullscreen', 'codeview', 'help']]
					],
				]
			@endphp

			<x-adminlte-card>

				<x-adminlte-input label="Subject" :name="$type . '_subject'" :value="setting($type . '_subject')" autocomplete="off" />

				<x-adminlte-text-editor label="Message" :name="$type . '_message'" :config="$config">
                    {{ setting($type . '_message') }}
                </x-adminlte-text-editor>

				<button type="submit" class="btn btn-primary mt-2">Save Changes</button>

			</x-adminlte-card>
		</div>

		<div class="col-md-4 col-sm-12">
			<x-adminlte-card title="Labels" id="labels">
				<span class="btn btn-sm btn-success mb-1">{name}</span>
				<span class="btn btn-sm btn-success mb-1">{trip_name}</span>
				<span class="btn btn-sm btn-success mb-1">{trek_date}</span>
				<span class="btn btn-sm btn-success mb-1">{number_of_trekkers}</span>
				<span class="btn btn-sm btn-success mb-1">{arrival_date}</span>
				<span class="btn btn-sm btn-success mb-1">{arrival_time}</span>
				<span class="btn btn-sm btn-success mb-1">{total_payment}</span>
				<span class="btn btn-sm btn-success mb-1">{remaining_payment}</span>
				<span class="btn btn-sm btn-success mb-1">{bank_charge}</span>
				<span class="btn btn-sm btn-success mb-1">{remaning_payment_with_bank_charge}</span>
				<span class="btn btn-sm btn-success mb-1">{addons}</span>
			</x-adminlte-card>
		</div>
	</div>
</form>

@stop

@section('js')
    @include('admin.includes.scripts')

	<script>
		$(document).ready(function () {
			$('#labels span').click(function () {
				$('#{{ $type }}_message').summernote('editor.insertText', $(this).text());
			})
		});
	</script>
@stop