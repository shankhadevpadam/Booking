<div>
    <div wire:ignore.self class="modal fade" id="traveler-detail" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="travelerDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="travelerDetailModalLabel">{{ $mode === 'add' ? 'Add' : 'Edit' }}
                        Traveler Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $mode === 'add' ? 'store' : 'update' }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Name" name="name" wire:model.defer="name" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Email" name="email" wire:model.defer="email" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Insurance Company" name="insuranceCompany" wire:model.defer="insuranceCompany" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Policy Number" name="policyNumber" wire:model.defer="policyNumber" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Assistance Hotline" name="assistanceHotline" wire:model.defer="assistanceHotline" autocomplete="off" />
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <x-adminlte-input label="Passport" name="passport" wire:model.defer="passport" autocomplete="off" />
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-primary">{{ $mode === 'add' ? 'Save' : 'Update' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Insurance Company</th>
                <th>Policy Number</th>
                <th>Assistance Hotline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($travelers as $traveler)
                <tr>
                    <td>{{ $traveler->name }}</td>
                    <td>{{ $traveler->email }}</td>
                    <td>{!! $traveler->insurance_company ??
                        '<a href="javascript:;" data-toggle="modal" data-target="#traveler-detail" wire:click="edit(' .
                            $traveler->id .
                            ')">Add</a>' !!}</td>
                    <td>{!! $traveler->policy_number ??
                        '<a href="javascript:;" data-toggle="modal" data-target="#traveler-detail" wire:click="edit(' .
                            $traveler->id .
                            ')">Add</a>' !!}</td>
                    <td>{{ $traveler->assistance_hotline }}</td>
                    <td>
                        @if ($traveler->getMedia()->isNotEmpty())
                            <a href="{{ $traveler->getFirstMediaUrl() }}" target="_blank"
                                class="btn btn-sm btn-primary">View</a>
                        @else
                            <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#traveler-detail"
                                wire:click="edit({{ $traveler->id }})">Add Passport</span>
                        @endif

                        @can('view_clients')
                            <span class="btn btn-sm btn-success" data-toggle="modal" data-target="#traveler-detail"
                                wire:click="edit({{ $traveler->id }})">Edit</span>
                            <span class="btn btn-sm btn-danger"
                                onclick="confirmComponentItemDelete({{ $traveler->id }}, 'deleteTraveler')">Delete</span>
                        @endcan
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
        <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#traveler-detail"
            wire:click="create">Add</span>
    </div>
</div>
