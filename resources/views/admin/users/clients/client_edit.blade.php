@extends('adminlte::page')

@section('title', $title ?? $userPackage->user->name)

@section('plugins.Sweetalert2', true)

@section('plugins.FlatPickr', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <x-adminlte-card>
                <div class="d-flex flex-column align-items-center text-center">
                    @if ($userPackage->user->photographUrl())
                        <img src="{{ $userPackage->user->photographUrl(true) }}" alt="User" class="rounded-circle" style="cursor: pointer;" width="75" height="75" data-toggle="modal" data-target="#view-photograph" />
                    @else
                        <img src="{{ asset('images/avatar.png') }}" alt="User" class="rounded-circle" width="75" height="75">
                    @endif
                    
                    <div class="mt-3">
                        <h4>{{ $userPackage->user->name }}</h4>
                        <p class="text-muted font-size-sm">{{ $userPackage->user->country->name }} <img src="{{ asset('flags/'. strtolower($userPackage->user->country->iso) . '.png') }}" alt="{{ $userPackage->user->country->name }}"></p>
                    </div>
                </div>
            </x-adminlte-card>

            <x-adminlte-card title="Review Email Notification">
                @livewire('user.review-notification', ['userPackage' => $userPackage])
            </x-adminlte-card>

            <x-adminlte-card title="Payment Status">
                @livewire('user.payment-status', ['userPackage' => $userPackage])
            </x-adminlte-card>

            <x-adminlte-card title="Trek Group">
                @livewire('user.trek-group', ['userPackage' => $userPackage])
            </x-adminlte-card>
            
            <x-adminlte-card title="Trek Details">
                @livewire('user.trek-detail', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Appointment DateTime and Location">
                @livewire('user.appointment-detail', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Addons">
                @livewire('user.addon-detail', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>
        </div>

        <div class="col-md-8 col-sm-12">
            <x-adminlte-card title="Arrival Details" body-class="table-responsive" class="card-body-no-th-border">
                @livewire('user.arrival-detail', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Group Arrival Details" body-class="table-responsive" class="card-body-no-th-border">
                @livewire('user.group-flight', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Traveler Details" body-class="table-responsive" class="card-body-no-th-border">
                @livewire('user.traveler-detail', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            
            <x-adminlte-card title="Payment Details" id="payment-detail">
                @livewire('user.payment-detail', [
                    'userPackage' => $userPackage,
                ])

                @livewire('user.update-total', [
                    'userPackage' => $userPackage
                ])

                <div class="spinner"></div>
            </x-adminlte-card>

            <x-adminlte-card title="Payment History">
                @livewire('user.payment-history', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Additional Payment">
                @livewire('user.additional-payment', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Additional Payment History">
                @livewire('user.additional-payment-history', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Refund Payment">
                @livewire('user.refund-payment', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Refund Payment History">
                @livewire('user.refund-payment-history', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Special Instructions">
                <p>{{ $userPackage->special_instructions ?? 'N/A' }}</p>
            </x-adminlte-card>
        </div>
    </div>

    <x-modal id="view-photograph" title="View Photograph">
        <div class="col-sm-12">
            @if ($userPackage->user->photographUrl())
                <img src="{{ $userPackage->user->photographUrl() }}" class="img-fluid" />
            @endif
        </div>
    </x-modal>

    @livewire('user.assign-guide', [
        'userPackageId' => $userPackage->id, 
        'guides' => $guides
    ])

@stop

@section('head_js')
    <script src="https://js.stripe.com/v3/"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@stop

@section('js')
	@include('admin.includes.scripts')

    <script>
        $(document).ready(function () {
            $('.datepicker').flatpickr({
                dateFormat: "Y-m-d",
            });

            $('.timepicker').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
            });
        });

        window.addEventListener('assign-guide', event => {
            $('#assign-guide').modal('hide');

            $('#guide').text(event.detail.guide);

            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })

        window.addEventListener('component-event', event => {
            if (event.detail.modal) {
                $('#' + event.detail.modal).modal('hide');
            }

            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })

        window.addEventListener('update-total', event => {
            if (event.detail.modal) {
                $('#' + event.detail.modal).modal('hide');
            }

            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })

            Livewire.emit('updateTotal');
        });

        function confirmComponentItemDelete(id, method, message = "Deleted item can't be recovered.") {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    Livewire.emit(method, id);
                }
            })
        }

        async function deletePaymentHistory(id) {
            const { value: text } = await Swal.fire({
            input: 'textarea',
            inputLabel: 'Delete Note',
            inputPlaceholder: 'Type your message here...',
            inputAttributes: {
                'aria-label': 'Type your message here'
            },
            showCancelButton: true
            })

            if (text) {
                Livewire.emit('deletePaymentHistory', id, text);
            }
        }
    </script>
@stop
