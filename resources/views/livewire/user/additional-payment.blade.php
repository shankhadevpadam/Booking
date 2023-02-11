<div>
    <form wire:submit.prevent="save" method="POST">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <x-adminlte-select label="Payment Method" name="paymentMethod" wire:model.defer="paymentMethod" wire:change="$refresh">
                    <option value="card">Pay Online</option>
                    <option value="cash">Cash</option>
                    <option value="pos">Pos Machine</option>
                    <option value="paypal">PayPal</option>
                </x-adminlte-select>
            </div>

            <div class="col-md-3 col-sm-12">
                <x-adminlte-select label="Currency" name="currencyId" wire:model.defer="currencyId">
                    <option value="">Choose Currency</option>
                    @if ($this->currencies->isNotEmpty())
                        @foreach ($this->currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->symbol }})</option>
                        @endforeach
                    @endif
                </x-adminlte-select>
            </div>

            @if ($paymentMethod === 'card' || $paymentMethod === 'pos')
                <div class="col-md-3 col-sm-12">
                    <x-adminlte-select label="Card" name="bankId" wire:model.defer="bankId" wire:change="changeBank">
                        <option value="">Choose Bank</option>
                        @if ($this->banks->isNotEmpty())
                            @foreach ($this->banks->where('type', $paymentMethod)->all() as $bank)
                                <option value="{{ $bank->id }}" {{ $bank->id === $bankId ? 'selected' : '' }}>{{ $bank->name }}</option>
                            @endforeach
                        @endif
                    </x-adminlte-select>
                </div>
            @endif

            @if ($paymentMethod === 'pos' || $paymentMethod === 'card')
                <div class="col-md-3 col-sm-12">
                    <x-adminlte-input label="Bank Charge" name="bankChargeAmount" wire:model.defer="bankChargeAmount" disabled />
                </div>
            @endif

            <div class="col-md-3 col-sm-12">
                <x-adminlte-input label="Amount" name="changeAmount" wire:model.defer="amount" wire:keyup="changeAmount" />
            </div>

            @if ($paymentMethod === 'card' || $paymentMethod === 'pos')
                <div class="col-md-3 col-sm-12">
                    <x-adminlte-input label="Total Amount" name="totalAmount" wire:model.defer="totalAmount" disabled />
                </div>
            @endif
        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <x-adminlte-textarea name="notes" wire:model.defer="notes" />
            </div>  
        </div>

        <button type="submit" class="btn btn-primary mt-3">Pay Additional Payment</button>
    </form>
</div>
