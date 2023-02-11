<div class="d-inline">
    <div wire:ignore.self class="modal fade" id="update-total" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="updateTotalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTotalModalLabel">Update Total</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateTotal" method="POST">
                        <div class="row">
                            <div class="col-sm-12">
                                <x-adminlte-input label="Total Amount" name="totalAmount" wire:model.defer="totalAmount" autocomplete="off" />
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
