<div>
    <div wire:ignore.self class="modal fade" id="hotel-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="hotelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hotelModalLabel">{{ $mode === 'add' ? 'Add' : 'Edit' }} Hotel Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $mode === 'add' ? 'store' : 'update' }}" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Name" name="name" wire:model.defer="name" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Room" name="room" wire:model.defer="room" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="Number Of Days" name="numberOfDays" wire:model.defer="numberOfDays">
                                    <option value="">Choose a number of days</option>
                                    @foreach (range(1, 20) as $i)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endforeach
                                </x-adminlte-select>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Per Day Price" name="perDayPrice" wire:model.defer="perDayPrice" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="Location" name="location" wire:model.defer="location">
                                    <option value="">Choose from location</option>
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
                <th>Hotel Name</th>
                <th>Room</th>
                <th>Location</th>
                <th>Number Of Days</th>
                <th>Per Day Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hotels as $hotel)
                <tr>
                    <td>{{ ucwords($hotel->name) }}</td>
                    <td>{{ $hotel->room }}</td>
                    <td>{{ $hotel->location->name }}</td>
                    <td>{{ $hotel->number_of_days }}</td>
                    <td>{{ $hotel->per_day_price }}</td>
                    <td>
                        <span wire:click="edit({{ $hotel->id }})" data-toggle="modal" data-target="#hotel-detail"  class="btn btn-sm btn-success">Edit</span>
                        <span onclick="confirmComponentItemDelete({{ $hotel->id }}, 'delete')" class="btn btn-sm btn-danger">Delete</span>
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
        <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#hotel-detail" wire:click="create">Add</span>
    </div>
</div>
