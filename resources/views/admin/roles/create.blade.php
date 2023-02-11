@extends('adminlte::page')

@section('title', $title ?? '')

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	<div class="row">
        <div class="col-sm-12 mb-2">
        	<a class="btn btn-primary" href="{{ route('admin.roles.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
    	<div class="col-sm-12">
    		<form role="form" action="{{ route('admin.roles.store') }}" method="POST">
    			@csrf

    			<x-adminlte-card>

					<x-adminlte-input label="Name" name="name" :value="old('name')" />

    				<div class="row">
            			@foreach($permissions as $permission)
							<div class="col-sm-3">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]">
										<label class="form-check-label">{{ $permission->name }}</label>
									</div>
								</div>
							</div>
						@endforeach
					</div>

					<button type="submit" class="btn btn-primary">Create</button>
					
    			</x-adminlte-card>
    		</form>
    	</div>
    </div>
@stop