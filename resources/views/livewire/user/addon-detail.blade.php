<div>
	<div wire:ignore.self class="modal fade" id="update-addon-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateAddonDetailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateAddonDetailModalLabel">Update Addon</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@if ($userPackage->package->addons)
						<form wire:submit.prevent="update" method="post">
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<x-adminlte-select name="name" wire:model.defer="name">
										<option value="">Choose addon</option>
											@foreach ($userPackage->package->addons as $addon)
												<option value="{{ $addon['name'] }}">{{ $addon['name'] }} x {{ number_format($addon['price'], 2) }}</option>
											@endforeach
									</x-adminlte-select>
								</div>

								<div class="col-md-6 col-sm-12">
									<x-adminlte-select name="count" wire:model.defer="count">
										@foreach (range(1, 20) as $i)
											<option value="{{ $i }}">{{ $i }}</option>
										@endforeach
									</x-adminlte-select>
								</div>
							</div>
		
							<button type="submit" class="btn btn-primary">Update</button>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>

    @if ($userPackage->addons->isNotEmpty())
        <ul class="list-group list-group-unbordered trek-details mb-3">
            @foreach($userPackage->addons as $addon)
                <li class="list-group-item">
                    <span>{{ $addon->name }}</span>
                    <span class="float-right text-primary">
						{{ $addon->count }} x {{ $addon->price }} = {{ number_format($addon->count * $addon->price, 2) }}
						<a href="javascript:;" class="text-danger" onclick="confirmComponentItemDelete({{ $addon->id }}, 'deleteAddon')">X</a>
					</span>
                </li>
            @endforeach
        </ul>

        <div>
            <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#update-addon-detail">Edit</span>
        </div>
    @else
		<div>
			<p>No addon available.</p>
			
			@if (count($userPackage->package->addons))
				<span class="text-primary cursor-pointer" data-toggle="modal" data-target="#update-addon-detail">Add</span>
			@endif
		</div>
    @endif
</div>