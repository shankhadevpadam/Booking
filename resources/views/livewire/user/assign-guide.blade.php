<div wire:ignore.self class="modal fade" id="assign-guide" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="assignGuideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignGuideModalLabel">Assign Guide / Tour Manager</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form wire:submit.prevent="save" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <x-adminlte-select label="Guide / Tour Manager" name="guideId" wire:model="guideId">
                                <option value="">Select Guide / Tour Manager</option>
                                @foreach ($guides as $guide)
                                    <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>
                    </div>

					<button type="submit" class="btn btn-primary">Assign Guide / Tour Manager</button>
				</form>
            </div>
        </div>
    </div>
</div>


