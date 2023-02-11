@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Sweetalert2', true)

@section('plugins.Datatables', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

	<div class="row">
		<div class="col-md-8 col-sm-12">
			<x-adminlte-card>
				<table id="emails" class="table table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($types as $key => $type)
							<tr>
								<td>{{ ++$key }}</td>
								<td>{{ $type }}</td>
								<td>
									<a title="Edit" class="btn btn-sm btn-success" href="{{ route('admin.settings.guide.email', ['type' => Str::slug($type, '_') ]) }}"><i class="far fa-edit"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</x-adminlte-card>
		</div>
	</div>

@stop

@section('js')
    @include('admin.includes.scripts')

	<script>
		$(document).ready(function () {
			$('#emails').DataTable();
		});
	</script>
@stop