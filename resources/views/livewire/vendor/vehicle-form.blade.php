<div>
    <div wire:ignore.self class="modal fade" id="vehicle-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleModalLabel">{{ $mode === 'add' ? 'Add' : 'Edit' }} Vehicle Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $mode === 'add' ? 'store' : 'update' }}" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="Name" name="name" wire:model.defer="name">
                                    <option value="">Choose a vehicle</option>
                                    <option value="car">Car</option>
                                    <option value="hiace">Hiace</option>
                                    <option value="land cruiser">Land Cruiser</option>
                                </x-adminlte-select>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Price" name="price" wire:model.defer="price" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="From" name="from" wire:model.defer="from">
                                    <option value="">Choose from location</option>
                                    @if ($locations->isNotEmpty())
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach   
                                    @endif
                                </x-adminlte-select>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="To" name="to" wire:model.defer="to">
                                    <option value="">Choose to location</option>
                                    @if ($locations->isNotEmpty())
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach   
                                    @endif
                                </x-adminlte-select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{ $mode === 'add' ? 'Save' : 'Update' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Vehicle</th>
                <th>From</th>
                <th>To</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehicles as $vehicle)
                <tr>
                    <td>{{ ucwords($vehicle->name) }}</td>
                    <td>{{ $vehicle->fromLocation->name }}</td>
                    <td>{{ $vehicle->toLocation->name }}</td>
                    <td>{{ $vehicle->price }}</td>
                    <td>
                        <span wire:click="edit({{ $vehicle->id }})" data-toggle="modal" data-target="#vehicle-detail"  class="btn btn-sm btn-success">Edit</span>
                        <span onclick="confirmComponentItemDelete({{ $vehicle->id }}, 'delete')" class="btn btn-sm btn-danger">Delete</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No record available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ml-2">
        <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#vehicle-detail" wire:click="create">Add</span>
    </div>
</div>
