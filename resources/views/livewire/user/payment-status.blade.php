<div>
    <select class="form-control" wire:model="status" wire:change="update">
        <option value="">Choose a payment status</option>
        @foreach ($statuses as $status)
            <option value="{{ $status->value }}">{{ $status->name }}</option>
        @endforeach
    </select>
</div>
