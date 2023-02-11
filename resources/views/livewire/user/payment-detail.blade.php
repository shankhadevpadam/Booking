<div>
    <div id="payment-detail" class="row mb-2">
        <div class="col-md-4 col-sm-12">
            <label for="total_amount">Total Package Amount </label>
            @can('edit_clients')
                <span class="text-primary cursor-pointer" data-toggle="modal" data-target="#update-total">Update</span>
            @endcan
            <input class="form-control" wire:model="totalPackageAmount" disabled />
        </div>
    </div>

    <div class="row mb-2">
        <span class="w-100 mb-2 pl-2 pb-2 border-bottom">Advanced Payment:</span>

        <div class="col-md-4">
            <x-adminlte-input label="Advanced Paid Amount" name="advancedPaidAmount" wire:model.defer="totalAdvancedAmount" disabled />
        </div>

        <div class="col-md-4">
            <x-adminlte-input label="Bank Fee" name="bankFee" wire:model.defer="totalBankChargeAmount" disabled />
        </div>

        <div class="col-md-4">
            <x-adminlte-input label="Total Amount" name="totalAmount" wire:model.defer="totalPaidAmount" disabled />
        </div>
    </div>

    @if ($totalRemainingAmount > 0)

        <div class="row mb-2">
            <span class="w-100 mb-2 pl-2 pb-2 border-bottom">Remaining Payment:</span>

            <div class="col-md-4">
                <x-adminlte-input label="Remaining Amount" name="remainingAmount" wire:model.defer="totalRemainingAmount" disabled />
            </div>

            <div class="col-md-4">
                <x-adminlte-input label="Remaining Bank Fee Amount" name="remainingBankFeeAmount" wire:model.defer="totalRemainingBankChargeAmount" disabled />
            </div>

            <div class="col-md-4">
                <x-adminlte-input label="Remaining Total Amount" name="remainingTotalAmount" wire:model.defer="totalRemainingAfterBankChargeAmount" disabled />
            </div>
        </div>

        <div x-data="paymentOption">
            <div class="row">
                <span class="w-100 mb-2 pl-2 pb-2 border-bottom">Payment Option:</span>

                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="cash" wire:model="paymentOption"
                                wire:click="setPaymentOption" x-model="option">
                            <label class="form-check-label" for="cash">Cash</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_option" value="credit_card"
                                wire:model="paymentOption" wire:click="setPaymentOption" x-model="option">
                            <label class="form-check-label" for="credit_card">Credit Card</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_option" value="wise"
                                wire:model="paymentOption" wire:click="setPaymentOption" x-model="option">
                            <label class="form-check-label" for="wise">Wise Transfer</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="payment_option" value="pos"
                                wire:model="paymentOption" wire:click="setPaymentOption" x-model="option">
                            <label class="form-check-label" for="wise">Pos Machine</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" x-show="option === 'cash'">
                <div class="col-md-4 col-sm-12">
                    <x-adminlte-select label="Currency" name="currencyId" wire:model.defer="currencyId" x-model="currencyId" @change="getExchangeRate">
                        <option value="">Choose a currency</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" code="{{ $currency->code }}">{{ $currency->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>

                <div class="col-md-4 col-sm-12">
                    <x-adminlte-input label="Amount" name="exchangeAmount" wire:model.defer="exchangeAmount" />
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" wire:model.defer="notes"></textarea>
                    </div>
                </div>

                <template x-if="showCurrencyExchangeRate && currencyId">
                    <div class="col-sm-12">
                        <div class="p-2 border mb-2">
                            <span x-text="`1 USD = ${selectedCurrencyPerRate} ${selectedCurrency}`" class="d-block"></span>
                            <span x-text="`Remaining amount USD ${totalRemainingAmount} x ${selectedCurrencyPerRate} = ${selectedCurrency} ${(totalRemainingAmount*selectedCurrencyPerRate).toFixed(2)}`" class="d-block"></span>
                            <p class="mb-0 text-primary">Please note: This is the conversion of today. The amount might change on your payment day.  We are using Nepal Center bank currency exchange data for currency conversion.</p>
                        </div>
                    </div>
                </template>
                
                <div class="col-sm-12">
                    <p class="p-2 border">
                        You can pay remaining amount in any major currency on your arrival in kathmandu before the trek.
                    </p>
                </div>
            </div>

            <div class="row" x-cloak x-show="option === 'credit_card'">
                <div class="col-sm-12">
                    <div id="card-element"></div>
                </div>
            </div>

            <div class="row" x-cloak x-show="option === 'wise'">
                <div class="col-sm-12">
                    <p class="p-2 border">
                        Account Number: 01601030038450<br>
                        Account Name: Magical Nepal Pvt Ltd <br>
                        Swift Code: NIBLNPKT <br>
                        Bank Name: Nepal Investment Bank <br>
                        Bank Address: Thamel Kathmandu Nepal <br>

                        Please wire the amount in the above address. It is free and doesn't cost you any extra fee. It
                        usually takes 72 hours.
                    </p>
                </div>
            </div>

            <div class="row" x-cloak x-show="option === 'pos'">
                <div class="col-md-4 col-sm-12">
                    <x-adminlte-select label="Currency" name="currencyId" wire:model.defer="currencyId">
                        <option value="">Choose a currency</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <x-adminlte-select label="Bank" name="bankId" wire:model.defer="bankId" wire:change="setBankId">
                        <option value="">Choose a bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-sm-12">
                    <button class="btn btn-primary" @click="payNow($wire.paymentOption)"
                        x-text="option === 'cash' || option === 'wise' || option === 'pos' ? 'Update' : 'Pay Now' "></button>
                </div>
            </div>
        </div>
    @endif

</div>

@push('js')
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();

        var cardElement = elements.create("card", {
            classes: {
                base: "form-control",
            },
            hidePostalCode: true,
        });

        cardElement.mount("#card-element");

        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentOption', () => ({
                option: 'cash',
                showCurrencyExchangeRate: false,
                currencyId: '',
                selectedCurrency: '',
                selectedCurrencyPerRate: 0,
                totalRemainingAmount: @entangle('totalRemainingAmount'),
                totalRemainingAfterBankChargeAmount: @entangle('totalRemainingAfterBankChargeAmount'),

                async getExchangeRate(event) {
                    if (! this.currencyId) {
                        this.showCurrencyExchangeRate = false;
                        return;
                    };

                    this.loader(true);

                    try {
                        const currencyCode = event.target.options[event.target.selectedIndex].getAttribute('code');
                        const response = await fetch("https://www.nrb.org.np/api/forex/v1/rates?page=1&per_page=100&from={{ now()->format('Y-m-d') }}&to={{ now()->format('Y-m-d') }}");
                        const result = await response.json();
                        const rates = result.data.payload[0].rates;
                        const match = rates.find(item => item.currency.iso3 === currencyCode);
                        const dollarRate = rates.find(item => item.currency.iso3 === 'USD');

                        this.selectedCurrency = currencyCode;

                        if (currencyCode == 'USD') {
                            this.selectedCurrencyPerRate = 1;
                        } else if (currencyCode == 'NPR') {
                            this.selectedCurrencyPerRate = dollarRate.sell;
                        } else if(currencyCode == 'INR') {
                            const indianRate = match.sell / 100;
                            this.selectedCurrencyPerRate = (dollarRate.sell / indianRate).toFixed(2);
                        } else if (currencyCode == 'YEN') {
                            const yenRate = 10 / match.sell;
                            this.selectedCurrencyPerRate = (dollarRate.sell / yenRate).toFixed(2);
                            this.selectedCurrencyPerRate = (dollarRate.sell / indianRate).toFixed(2)
                        } else {
                            this.selectedCurrencyPerRate = (dollarRate.sell / match.sell).toFixed(2);
                        }
                    } catch (error) {
                        console.log(error);
                    } finally {
                        this.showCurrencyExchangeRate = true;
                        this.loader(false);
                    }
                },

                async payNow(method) {
                    this.loader(true);

                    if (method === 'credit_card') {
                        try {
                            const response = await fetch(
                                '{{ url('api/v1/booking/payment-intent') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        amount: this.totalRemainingAfterBankChargeAmount
                                    })
                                })

                            const data = await response.json();

                            if (data.secret) {
                                try {
                                    const {
                                        paymentIntent,
                                        error
                                    } = await stripe.confirmCardPayment(data.secret, {
                                        payment_method: {
                                            card: cardElement,
                                            billing_details: {
                                                name: '{{ $this->userPackage->user->name }}',
                                                email: '{{ $this->userPackage->user->email }}',
                                            },
                                        },
                                        setup_future_usage: "off_session",
                                    });

                                    if (error) {
                                        throw error.message
                                    } else {
                                        if (paymentIntent.status === 'succeeded') {
                                            Livewire.emit('payRemainingAmount');
                                        } else {
                                            throw new Error('Something wrong!');
                                        }
                                    }
                                } catch (error) {
                                    alert(error);
                                }
                            }
                        } catch (error) {
                            alert(error);
                        } finally {
                            this.loader(false);
                        }
                    } else {
                        Livewire.emit('payRemainingAmount');
                    }

                    this.loader(false);
                },

                loader(loading = false) {
                    if (loading) {
                        document.querySelector('#payment-detail').classList.add('overlay');
                    } else {
                        document.querySelector('#payment-detail').classList.remove('overlay');
                    }
                    
                    document.querySelector('.spinner').style.display = loading ? 'block' : 'none';
                },
            }));
        });
    </script>
@endpush
