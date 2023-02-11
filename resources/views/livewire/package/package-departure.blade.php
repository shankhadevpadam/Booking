<div wire:ignore.self class="modal fade" id="package-departure" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="departureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departureModalLabel">Create Package Departure</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form wire:submit.prevent="save" method="post">
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<x-adminlte-input label="Start Date" name="startDate" class="datepicker" wire:model.defer="startDate" autocomplete="off" />
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-input label="End Date" name="endDate" class="datepicker" wire:model.defer="endDate" autocomplete="off" />
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-select label="Tour Duration" name="duration" wire:model.defer="duration">
								@for ($i = 1; $i <= 30; $i++)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</x-adminlte-select>
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-select label="Date Interval" name="interval" wire:model.defer="interval">
								@for ($j = 1; $j <= 30; $j++)
									<option value="{{ $j }}">{{ $j }}</option>
								@endfor
							</x-adminlte-select>
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-input label="Price" name="price" wire:model.defer="price" autocomplete="off" />
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-select label="Discount Type" name="discountType" wire:model.defer="discountType">
								<option value="">Please select discount type</option>
									@foreach ($discountTypes as $type)
										<option value="{{ $type->value }}">{{ $type->name }}</option>
									@endforeach
							</x-adminlte-select>  
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-select label="Discount Apply On" name="discountApplyOn" wire:model.defer="discountApplyOn">
								<option value="">Please select discount apply on</option>
								@foreach ($discountApplyOnTypes as $type)
									<option value="{{ $type->value }}">{{ $type->name }}</option>
								@endforeach
							</x-adminlte-select>  
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-input label="Discount Amount / Percentage" name="discountAmount" wire:model.defer="discountAmount" autocomplete="off" />  
						</div>

						<div class="col-md-4 col-sm-12">
							<x-adminlte-input label="Total Quantity" name="quantity" wire:model.defer="quantity" autocomplete="off" />
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Save</button>
				</form>
            </div>
        </div>
    </div>
</div>
