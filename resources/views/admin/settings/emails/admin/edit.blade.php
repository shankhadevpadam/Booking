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
		<a class="btn btn-primary" href="{{ route('admin.settings.admin.email') }}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
	</div>
</div>

<form method="post" action="{{ route('admin.settings.admin.email.update') }}">

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
				<span class="btn btn-sm btn-success mb-1">{email}</span>
				<span class="btn btn-sm btn-success mb-1">{approval_link}</span>
				<span class="btn btn-sm btn-success mb-1">{deposit}</span>
				<span class="btn btn-sm btn-success mb-1">{remaining_amount}</span>
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