@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Select2', true)

@section('head_js')
    <script defer src="https://unpkg.com/alpinejs@3.9.0/dist/cdn.min.js"></script>
@stop

@section('plugins.FlatPickr', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-sm-12 mb-2">
            <a class="btn btn-primary" href="{{ route('home') }}"><i class="fas fa-chevron-left"></i> Back</a>
        </div>
    </div>

    <div class="row" x-data="booking">
        <div id="custom-booking" class="col-md-8 col-sm-12">
            <x-adminlte-card>
                <form method="POST" @submit.prevent="submit">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="user">Client</label>
                                <select x-ref="user" id="user" class="form-control" required></select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="package">Package</label>
                                <select x-ref="package" id="package" class="form-control" required>
                                    <option value="">Select Package</option>

                                    @foreach ($packages as $package)
                                        <option value="{{ $package->slug }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="departure">Departure</label>
                                <select x-ref="departure" id="departure" class="form-control" required>
                                    <option value="">Select Departure</option>

                                    <template x-for="departure in departures">
                                        <option :value="departure.id"
                                            x-text="`${departure.start_date} - ${departure.end_date}`"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="number_of_travelers">Number of Travelers</label>
                                <select x-ref="number_of_travelers" id="number-of-travelers" class="form-control">
                                    @foreach (range(1, 20) as $i)
                                        <option value="{{ $i }}">{{ $i === 1 ? '1 Solo' : $i }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <label for="redeem_code" class="d-block">Redeem Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="redeem_code" x-model="redeem.code">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" @click="applyRedeem">Apply Redeem</button>
                                </div>
                            </div>
                            <span class="text-sm" :class="redeem.error ? 'text-danger' : 'text-success'" x-text="redeem.message"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Book Now</button>
                </form>
            </x-adminlte-card>

            <div class="spinner"></div>
        </div>

        <div class="col-md-4 col-sm-12">
            <x-adminlte-card title="Your Payment Summary">
                <p class="text-bold" x-text="`Number of travellers: ${numberOfTravelers}`"></p>

                <template x-if="addons">
                    <div>
                        <p><strong>Optional Add On</strong></p>

                        <table class="table payment-addon-table">
                            <template x-for="(addon, index) in addons" :key="index">
                                <tr>
                                    <td>
                                        <p class="mb-0" x-text="addon.name"></p>
                                        <strong x-text="`USD $${addon.price}`"></strong>
                                    </td>
                                    <td>
                                        <div class="quantity-group">
                                            <input type="button" value="-" class="quantity-btn button-minus"
                                                @click="decrementBtn(index, addon.price)" />
                                            <input type="number" step="1" max="" :value="counter[index] || 0"
                                                name="quantity" class="quantity-field" />
                                            <input type="button" value="+" class="quantity-btn button-plus"
                                                @click="incrementBtn(index, addon.price)" />
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </table>
                    </div>
                </template>

                <table class="table">
                    <tr>
                        <td>
                            <p class="mb-0">Brochure Price</p>
                            <small class="text-muted"
                                x-text="`Adult: USD $${brochurePrice} x ${numberOfTravelers}`"></small>
                        </td>
                        <td x-text="formatPrice(numberOfTravelers * brochurePrice)"></td>
                    </tr>

                    <template x-if="departure && departure.discount_type">
                        <tr class="text-danger">
                            <td>
                                <p class="mb-0">Special Discount (<span
                                        x-text="departure.discount_type === 'percentage' ? departure.discount_amount + '%' : numberOfTravelers + 'x' + departure.discount_amount"></span>)
                                </p>
                            </td>

                            <td>
                                <strong>- <span x-text="formatPrice(specialDiscountAmount)"></span></strong>
                            </td>
                        </tr>
                    </template>

                    <template x-if="redeem.applied">
                        <tr class="text-danger">
                            <td>
                                <p class="mb-0">Coupon Discount (<span
                                        x-text="redeem.data.discount_type === 'percentage' ? redeem.data.discount_amount + '%' : redeem.data.discount_amount"></span>)
                                </p>
                            </td>

                            <td>
                                <strong>- <span x-text="formatPrice(redeemDiscountAmount)"></span></strong>
                            </td>
                        </tr>
                    </template>

                    <tr>
                        <td>Amount</td>
                        <td x-text="formatPrice(totalAmount)"></td>
                    </tr>
                </table>
            </x-adminlte-card>
        </div>
    </div>

@stop

@section('js')
    @include('admin.includes.admin_booking_scripts')
@stop

