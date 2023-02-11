@extends('adminlte::page')

@section('title', $title ?? '')

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('plugins.Sweetalert2', true)

@section('content')
	@can('add_roles')
	    <div class="row">
	        <div class="col-sm-12 mb-2">
	        	<a class="btn btn-primary" href="{{ route('admin.roles.create') }}">Add Role</a>
	        </div>
	    </div>
    @endcan

    <div class="row">
		<div class="col-md-6 col-sm-12">
			<x-adminlte-card body-class="table-responsive">

				<table class="table table-striped table-hover text-nowrap">
					<thead>                  
                    	<tr>
                      		<th>Name</th>
                      		<th>Action</th>
                    	</tr>
                  	</thead>
					<tbody>
						@forelse ($roles as $role)
								<tr>
									<td class="column-title">{{ $role->name }}</td>
									<td>
                                        @if ($role->name != 'Super Admin')
                                            @can('edit_roles')
                                            <a title="Edit" class="btn btn-sm btn-success" href="{{ route('admin.roles.edit', $role->id) }}"><i class="far fa-edit"></i></a>
                                            @endcan
    										@can('delete_roles')
											<form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you confirm to delete?');">
											 	@method('DELETE')
											 	@csrf
											 	<button type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>               
											</form>
                                            @endcan
										@endif
									</td>
								</tr>
                            @empty
                                <tr>
                                    <td colspan="2">No record found.</td>
                                </tr>
							@endforelse
					</tbody>
				</table>
				
			</x-adminlte-card>
		</div>
	</div>
@stop

@section('js')
	@include('admin.includes.scripts')
@stop
