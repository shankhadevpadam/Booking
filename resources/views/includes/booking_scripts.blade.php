<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('booking', () => ({
            slug: null,
            departures: [],
            departureId: null,
            departure: null,
            numberOfTravelers: 1,
            brochurePrice: 0,
            addons: null,
            counter: [],
            addonTotal: 0,
            redeem: {
                code: '',
                applied: false,
                error: false,
                message: '',
                data: {},
            },

            init() {
                this.getSelect2();

                this.$watch("numberOfTravelers, slug, departureId", () => {
                    if (!this.departureId || !this.slug) {
                        this.reset();
                    }

                    if (this.departure && this.departure.package.discounts.length > 0) {
                        this.applyGroupDiscount();
                    }
                });
            },

            incrementBtn(index, amount) {
                ++this.counter[index];

                this.addonTotal = this.addonTotal + amount;
            },

            decrementBtn(index, amount) {
                if (--this.counter[index] < 0) {
                    this.counter[index] = 0;
                    return;
                }

                this.addonTotal = this.addonTotal - amount;
            },

            async getDepartures(slug) {
                this.loader(true);

                if (!slug) {
                    this.loader(false);
                    return;
                }

                try {
                    const response = await fetch(`/api/v1/packages/${slug}/departures`, {
                        headers: {
                            "Accept": "application/json",
                        }
                    })
                    const result = await response.json();

                    this.departures = result.data;

                    if (result.data.length === 0) {
                        this.reset();
                    }
                } catch (error) {
                    console.error(error);
                } finally {
                    this.loader(false);
                }
            },

            async getDeparture(id) {
                if (!id) return;

                this.loader(true);

                try {
                    const response = await fetch(`/api/v1/packages/departures/${id}`, {
                        headers: {
                            "Accept": "application/json",
                        }
                    });
                    const result = await response.json();

                    this.departure = result.data;
                    this.brochurePrice = result.data.price;

                    if (result.data.package.addons.length > 0) {
                        this.addons = result.data.package.addons;

                        for (let i = 0; i < result.data.package.addons.length; i++) {
                            this.counter[i] = 0;
                        }
                    }
                } catch (error) {
                    console.error(error);
                } finally {
                    this.loader(false);
                }
            },

            async applyRedeem() {
                if (this.redeem.applied || !this.redeem.code || !this.departure) return;

                this.loader(true);

                try {
                    const response = await fetch(
                        `/api/v1/coupons/check?package_id=${this.departure.package.id}&code=${this.redeem.code}`, {
                            headers: {
                                "Accept": "application/json",
                            }
                        })
                    const result = await response.json();

                    if (response.status === 404) {
                        throw result.message;
                    } else {
                        this.redeem.data = result.data;
                        this.redeem.error = false;
                        this.redeem.message = result.data.message
                        this.redeem.applied = true;
                    }
                } catch (error) {
                    this.redeem.error = true;
                    this.redeem.message = error;
                } finally {
                    this.loader(false);
                }
            },

            async applyGroupDiscount() {
                try {
                    const response = await fetch(
                        `/api/v1/packages/${this.departure.package.id}/group-discount?number_of_people=${this.numberOfTravelers}`, {
                            headers: {
                                "Accept": "application/json",
                            }
                        });

                    const result = await response.json();

                    this.brochurePrice = result.data.price;
                } catch (error) {
                    console.error(error.response.data);
                }
            },

            get brochureTotal() {
                return this.numberOfTravelers * this.brochurePrice;
            },

            get redeemDiscountAmount() {
                if (!this.redeem.applied) return 0;

                if (this.redeem.data.type === "percentage") {
                    if (this.redeem.data.applyOn === "brochure") {
                        return (this.brochureTotal * this.redeem.data.discount_amount) / 100;
                    } else {
                        return (this.brochureTotal + this.addonTotal - this
                            .specialDiscountAmount) * this.redeem.data.discount_amount / 100;
                    }
                } else {
                    return this.redeem.data.discount_amount;
                }
            },

            get specialDiscountAmount() {
                if (!this.departure) return 0;

                if (this.departure.discount_type == "percentage") {
                    if (this.departure.discount_apply_on == "final") {
                        return (this.brochureTotal + this.addonTotal) * this.departure
                            .discount_amount / 100;
                    }

                    return (this.brochureTotal * this.departure.discount_amount) / 100;
                } else if (this.departure.discount_type == "fixed") {
                    return this.numberOfTravelers * this.departure.discount_amount;
                } else {
                    return 0;
                }
            },

            get totalDiscountedAmount() {
                return this.specialDiscountAmount + this.redeemDiscountAmount;
            },

            get totalAmount() {
                return this.brochureTotal + this.addonTotal - this.totalDiscountedAmount;
            },

            reset() {
                this.numberOfTravelers = 1;
                this.addons = this.departureId = this.departure = null;
                this.brochurePrice = 0;
                this.redeem = {
                    code: '',
                    applied: false,
                    error: false,
                    message: '',
                    data: {},
                };

                $(this.$refs.number_of_travelers).select2().val(1).trigger('change')
                $(this.$refs.departure).select2().val('').trigger('change')
            },

            getSelect2() {
                $(this.$refs.package).select2().on('select2:select', (event) => {
                    this.slug = event.target.value;

                    this.getDepartures(event.target.value);
                })

                $(this.$refs.departure).select2().on('select2:select', (event) => {
                    this.departureId = event.target.value;

                    this.getDeparture(event.target.value);
                })

                $(this.$refs.number_of_travelers).select2().on('select2:select', (event) => {
                    this.numberOfTravelers = event.target.value;
                })
            },

            async submit() {
                const addons = [];

                const params = new URLSearchParams();

                if (this.departure.package.addons && this.addonTotal) {
                    this.departure.package.addons.forEach((addon, index) => {
                        addons.push({
                            name: addon.name,
                            count: this.counter[index],
                            price: addon.price,
                        });
                    });
                }

                this.loader(true);

                try {
                    const response = await fetch("{{ route('booking.store') }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": 'application/json',
                            "Accept": 'application/json',
                            "X-CSRF-Token": document.head.querySelector(
                                'meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            'package_id': this.departure.package.id,
                            'departure_id': this.departure.id,
                            'number_of_trekkers': this.numberOfTravelers,
                            'addons': addons,
                            'total_amount': this.totalAmount,
                            'is_redeem_applied': this.redeem.applied,
                            'redeem_amount': this.redeemDiscountAmount,
                        })
                    })

                    const result = await response.json();

                    window.location.href = result.url;
                } catch (error) {
                    console.log(error);
                } finally {
                    this.loader(false);
                }
            },

            formatPrice(price) {
                return 'USD $' + Math.round((price + Number.EPSILON) * 100) / 100;
            },

            loader(loading = false) {
                if (loading) {
                    document.querySelector('#custom-booking').classList.add('overlay');
                } else {
                    document.querySelector('#custom-booking').classList.remove('overlay');
                }

                document.querySelector('.spinner').style.display = loading ? 'block' : 'none';
            },
        }))
    });
</script>

<script>
    $(document).ready(function() {
        $('#package, #departure, #number-of-travelers').select2();
    });
</script>
