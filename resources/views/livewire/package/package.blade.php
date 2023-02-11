<div>
	<x-adminlte-card>
		<x-adminlte-input label="Name" name="name" wire:model.defer="name" autocomplete="off" />

		<x-adminlte-input label="Slug" name="slug" wire:model.defer="slug" autocomplete="off">
			<x-slot name="bottomSlot">
				<span class="text-info text-sm">[Will be automatically generated from name, if left empty.]</span>
			</x-slot>
		</x-adminlte-input>

		<x-adminlte-select label="Initial Payment Type" name="paymentType" wire:model.defer="paymentType">
			<option>Choose payment type</option>
			@foreach ($paymentTypes as $type)
				<option value="{{ $type->value }}">{{ $type->name }}</option>
			@endforeach
		</x-adminlte-select>

		<x-adminlte-input label="Initial Payment Amount / Percentage" name="amount" wire:model.defer="amount" autocomplete="off" />

		<x-adminlte-input label="Default Booked" name="defaultBooked" wire:model.defer="defaultBooked" autocomplete="off" />


		@foreach ($inputs as $key => $value)
			<div class="row">
				<div class="col-md-5 col-sm-12">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control @error('inputs.'.$key.'.name') is-invalid @enderror" name="inputs[{{ $key }}]['name']" wire:model.defer="inputs.{{ $key }}.name" autocomplete="off">

						@error('inputs.'.$key.'.name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>
				<div class="col-md-5 col-sm-12">
					<div class="form-group">
						<label for="price">Price</label>
						<input type="text" class="form-control @error('inputs.'.$key.'.price') is-invalid @enderror" name="inputs[{{ $key }}]['price']" wire:model.defer="inputs.{{ $key }}.price" autocomplete="off">
						
						@error('inputs.'.$key.'.price')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>
				<div class="col-md-2 col-sm-12 text-right">
					<button type="button" class="btn btn-plus btn-danger" wire:click="remove({{ $key }})"><i class="fas fa-minus-circle"></i></button>
				</div>
			</div>
		@endforeach

		@if ($update)
			<button wire:click.prevent="update" class="btn btn-primary">Update</button>
		@else
			<button wire:click.prevent="store" class="btn btn-primary">Create</button>
		@endif
		<button type="button" class="btn btn-primary" wire:click="add()">Addons <i class="fas fa-plus-circle"></i></button>
	</x-adminlte-card>
</div>
