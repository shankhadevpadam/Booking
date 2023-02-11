@extends('adminlte::page')

@section('title', $title ?? $userPackage->package->name)

@section('plugins.Sweetalert2', true)

@section('plugins.FlatPickr', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')

    <div class="row">
        @if ($dueAmount > 0)
            <div class="col-sm-12">
                <x-adminlte-alert theme="info" icon="" dismissable>
                    <i class="icon far fa-bell"></i>
                    Remaining due {{ $dueAmount }} <a id="pay-link" href="javascript:;">Click here to pay</a>
                </x-adminlte-alert>
            </div>
        @endif

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

                <div class="spinner"></div>
            </x-adminlte-card>

            <x-adminlte-card title="Payment History">
                @livewire('user.payment-history', [
                    'userPackage' => $userPackage,
                ])
            </x-adminlte-card>

            <x-adminlte-card title="Additional Payment History">
                @livewire('user.additional-payment-history', [
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
                minDate: "today",
                allowInput: true,
            });

            $('.timepicker').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                allowInput: true,
            });

            $('#pay-link').click(function () {
                $('html, body').animate({ scrollTop: $('#payment-detail').offset().top - 70 }, 'slow');
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
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
    </script>
@stop
