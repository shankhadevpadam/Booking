<div>
	<div wire:ignore.self class="modal fade" id="group-arrival-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="groupArrivalDetailModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="groupArrivalDetailModalLabel">{{ $mode === 'add' ? 'Add' : 'Update' }} Flight Details</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
					<form wire:submit.prevent="{{ $mode === 'edit' ? 'update' : 'store' }}" method="POST">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Name" name="name" wire:model.defer="name" autocomplete="off" />
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Arrival Date" name="arrivalDate" class="datepicker" wire:model.defer="arrivalDate" autocomplete="off" />
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Arrival Time" name="arrivalTime" class="timepicker" wire:model.defer="arrivalTime" autocomplete="off" />
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Flight Number" name="flightNumber" wire:model.defer="flightNumber" autocomplete="off" />
							</div>
						</div>

						@if ($mode === 'edit')
							<button type="submit" class="btn btn-primary">Update</button>
						@else
							<button type="submit" class="btn btn-primary">Save</button>
						@endif
					</form>
	            </div>
	        </div>
	    </div>
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Arrival Date</th>
				<th>Arrival Time</th>
				<th>Flight Number</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($userPackage->groups as $group)
				<tr>
					<td>{{ $group->name }}</td>
					<td>{{ $group->arrival_date->toDateString() }}</td>
					<td>{{ $group->arrival_time->toTimeString() }}</td>
					<td>{{ $group->flight_number }}</td>
					<td>
						<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#group-arrival-detail" wire:click="edit({{ $group->id }})">Edit</button>
						<button class="btn btn-sm btn-danger" onclick="confirmComponentItemDelete({{ $group->id }}, 'deleteFlight')">Delete</button>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5">No record available.</td>
				</tr>
			@endforelse
		</tbody>
	</table>

	<div class="ml-2">
		<span class="text-primary cursor-pointer" data-toggle="modal" data-target="#group-arrival-detail" wire:click="add()">Add</span>
	</div>
</div>
