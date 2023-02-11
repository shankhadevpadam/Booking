<div>
	<div wire:ignore.self class="modal fade" id="update-appointment-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateAppointmentDetailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="updateAppointmentDetailModalLabel">Update Appointment Detail</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form wire:submit.prevent="update" method="post">
						<div class="row">
							<div class="col-sm-12">
								<x-adminlte-input label="Appointment Date" name="appointmentDate" class="datepicker" wire:model.defer="appointmentDate" autocomplete="off" />
							</div>

                            <div class="col-sm-12">
								<x-adminlte-input label="Appointment Time" name="appointmentTime" class="timepicker" wire:model.defer="appointmentTime" autocomplete="off" />
							</div>

                            <div class="col-sm-12">
								<x-adminlte-select label="Meeting Location" name="meetingLocation" wire:model.defer="meetingLocation" wire:change="changeLocation">
									<option value="office">Office</option>
                                    <option value="hotel">Hotel</option>
								</x-adminlte-select>
							</div>
                            
                            @if ($meetingLocation === 'hotel')
                                <div class="col-sm-12">
									<x-adminlte-input label="Hotel Name" name="hotelName" wire:model.defer="hotelName" autocomplete="off" />
                                </div>
                            @endif
						</div>
	
						<button type="submit" class="btn btn-primary">Update</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<ul class="list-group list-group-unbordered trek-details mb-3">
		<li class="list-group-item">
            <span>Appointment Date</span>
			@if ($userPackage->appointment_date)
		    	<span class="float-right text-primary">{{ $userPackage->appointment_date->toDateString() }}</span>
			@else
				<span class="float-right text-primary cursor-pointer" data-toggle="modal" data-target="#update-appointment-detail">Add</span>
			@endif
		</li>

        <li class="list-group-item">
            <span>Appointment Time</span>
			@if ($userPackage->appointment_time)
		    	<span class="float-right text-primary">{{ $userPackage->appointment_time->toTimeString() }}</span>
			@else
				<span class="float-right text-primary cursor-pointer" data-toggle="modal" data-target="#update-appointment-detail">Add</span>
			@endif
        </li>

        <li class="list-group-item">
            <span>Meeting Location</span>
			@if ($userPackage->meeting_location)
            	<span class="float-right text-primary">{{ ucfirst($userPackage->meeting_location) }}</span>
			@else
				<span class="float-right text-primary cursor-pointer" data-toggle="modal" data-target="#update-appointment-detail">Add</span>
			@endif
        </li>

        @if($userPackage->meeting_location === 'hotel')
            <li class="list-group-item">
                <span>Hotel Name</span>
                <span class="float-right text-primary">{{ $userPackage->hotel_name }}</span>
            </li>
        @endif
	</ul>

	<div>
		<span class="text-primary cursor-pointer" data-toggle="modal" data-target="#update-appointment-detail">Edit</span>
	</div>
</div>