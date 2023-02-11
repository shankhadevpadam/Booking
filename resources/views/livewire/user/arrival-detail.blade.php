<div>
    <div wire:ignore.self class="modal fade" id="add-arrival-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addArrivalDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addArrivalDetailModalLabel">{{ $userPackage->arrival_date ? 'Update' : 'Add' }} Arrival Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" method="POST">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Arrival Date" name="arrivalDate" class="datepicker" wire:model.defer="arrivalDate" autocomplete="off" />
                            </div>
    
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Arrival Time" name="arrivalTime" class="timepicker" wire:model.defer="arrivalTime" autocomplete="off" />
                            </div>
    
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Flight Number" name="flightNumber" wire:model.defer="flightNumber" autocomplete="off" />
                            </div>
    
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-select label="Airport Pickup" name="airportPickup" wire:model="airportPickup">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{ $userPackage->arrival_date ? 'Update' : 'Save' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Arrival Date</th>
                <th>Arrival Time</th>
                <th>Flight Number</th>
                <th>Pickup</th>
            </tr>
        </thead>
        <tbody>
            @if($userPackage->arrival_date)
                <tr>
                    <td>{{ $userPackage->arrival_date?->toDateString() }}</td>
                    <td>{{ $userPackage->arrival_time?->toTimeString() }}</td>
                    <td>{{ $userPackage->flight_number }}</td>
                    <td>{{ $userPackage->flight_number ? $userPackage->airport_pickup : '' }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="4">No record available.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="ml-2">
        <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#add-arrival-detail" wire:click="openModal('{{ $userPackage->arrival_date ? 'edit' : 'add' }}')">{{ $userPackage->arrival_date ? 'Edit' : 'Add' }}</span>
    </div>
</div>