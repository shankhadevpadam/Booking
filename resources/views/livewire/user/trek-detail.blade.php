<div>
	<div wire:ignore.self class="modal fade" id="update-trek-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateTrekDetailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateTrekDetailModalLabel">Update Trek Detail</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form wire:submit.prevent="update" method="post">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<x-adminlte-select label="Package" name="packageId" wire:model.defer="packageId">
									@inject('package', 'App\Models\Package')
									<option value="">Choose a package</option>
									@foreach ($package::toBase()->orderBy('name')->get() as $package)
										<option value="{{ $package->id }}">{{ $package->name }}</option>
									@endforeach
								</x-adminlte-select>
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-select label="No of trekkers" name="numberOfTrekkers" wire:model.defer="numberOfTrekkers">
									@foreach (range(1, 20) as $i)
										<option value="{{ $i }}">{{ $i }}</option>
									@endforeach
								</x-adminlte-select>
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Start Date" name="startDate" class="datepicker" wire:model.defer="startDate" autocomplete="off" />
							</div>
	
							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="End Date" name="endDate" class="datepicker" wire:model.defer="endDate" autocomplete="off" />
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Emergency Phone" name="emergencyPhone" wire:model.defer="emergencyPhone" autocomplete="off" />
							</div>

							<div class="col-md-6 col-sm-12">
								<x-adminlte-input label="Emergency Email" name="emergencyEmail" wire:model.defer="emergencyEmail" autocomplete="off" />
							</div>
						</div>
	
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<ul class="list-group list-group-unbordered trek-details mb-3">
		<li class="list-group-item">
		  <span>Package Name</span>
		  <span class="float-right text-primary">{{ $userPackage->package->name }}</span>
		</li>

		<li class="list-group-item">
		  <span>Departure Start Date</span>
		  <span id="start-date" class="float-right text-primary">{{ $userPackage->start_date->format('Y-m-d') }}</span>
		</li>

		<li class="list-group-item">
			<span>Departure End Date</span>
			<span id="end-date" class="float-right text-primary">{{ $userPackage->end_date->format('Y-m-d') }}</span>
		</li>

		<li class="list-group-item">
			<span>No of Trekkers</span>
			<span class="float-right text-primary">{{ $userPackage->number_of_trekkers }}</span>
		</li>

		<li class="list-group-item">
			<span>Emergency Phone</span>
			<span class="float-right text-primary">{{ $userPackage->emergency_phone ?? 'N/A' }}</span>
		</li>

		<li class="list-group-item">
			<span>Emergency Email</span>
			<span class="float-right text-primary">{{ $userPackage->emergency_email ?? 'N/A' }}</span>
		</li>

		<li class="list-group-item">
			<span>Guide / Tour Manager</span>
			<span id="guide" class="float-right text-primary cursor-pointer" data-toggle="modal" data-target="#assign-guide">
				@php($agency = $userPackage->agency?->guide_id)

				{{ $agency ? getUserById($agency)->name : (auth()->user()->hasRole('Client') ? 'Guide not assign yet' : 'Assign guide') }}
			</span>
		</li>
	</ul>

	<div>
		<span class="text-primary cursor-pointer" data-toggle="modal" data-target="#update-trek-detail">Edit</span>
	</div>
</div>