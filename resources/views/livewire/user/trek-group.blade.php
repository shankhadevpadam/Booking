<div>
    <select class="form-control" wire:model="trekGroup" wire:change="update">
        <option value="">Choose a trek group</option>
        @foreach ($types as $type)
            <option value="{{ $type->value }}">{{ $type->name }}</option>
        @endforeach
    </select>
</div>
