<div>
    <div wire:ignore.self class="modal fade" id="flight-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="flightModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="flightModalLabel">{{ $mode === 'add' ? 'Add' : 'Edit' }} Flight Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $mode === 'add' ? 'store' : 'update' }}" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="Airline" name="airline" wire:model.defer="airline">
                                    <option value="">Choose from airline</option>
                                    @if ($airlines->isNotEmpty())
                                        @foreach ($airlines as $airline)
                                            <option value="{{ $airline->id }}">{{ $airline->name }}</option>
                                        @endforeach   
                                    @endif
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

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="Type" name="type" wire:model.defer="type">
                                    <option value="">Choose from type</option>
                                    <option value="guide">Guide</option>
                                    <option value="client">Client</option>
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
                <th>Flight</th>
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($flights as $flight)
                <tr>
                    <td>{{ ucwords($flight->airline->name) }}</td>
                    <td>{{ $flight->fromLocation->name }}</td>
                    <td>{{ $flight->toLocation->name }}</td>
                    <td>{{ ucwords($flight->type) }}</td>
                    <td>{{ $flight->price }}</td>
                    <td>
                        <span wire:click="edit({{ $flight->id }})" data-toggle="modal" data-target="#flight-detail"  class="btn btn-sm btn-success">Edit</span>
                        <span onclick="confirmComponentItemDelete({{ $flight->id }}, 'delete')" class="btn btn-sm btn-danger">Delete</span>
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
        <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#flight-detail" wire:click="create">Add</span>
    </div>
</div>
