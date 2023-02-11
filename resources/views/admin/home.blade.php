@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('plugins.FlatPickr', true)

@section('plugins.Select2', true)

@section('plugins.Moment', true)

@section('plugins.DateRangePicker', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    @role('Super Admin')
        <div class="row">
            <div class="col-sm-12">
                <x-adminlte-card title="Coming 7 days trips" collapsible="collapsed">
                    <table class="table table-striped table-hover text-nowrap">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Pickup</th>
                            <th>Package</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Booked Date</th>
                        </thead>
                        <tbody>
                            @forelse ($comingSevenDaysPackages as $package)
                                <tr>
                                    <td>{{ $package->user->name }}</td>
                                    <td>{{ $package->user->email }}</td>
                                    <td>{{ $package->airport_pickup }}</td>
                                    <td>{{ $package->package->name }}</td>
                                    <td>{{ $package->start_date->format('D M j, Y') }}</td>
                                    <td>{{ $package->end_date->format('D M j, Y') }}</td>
                                    <td>{{ $package->created_at->format('D M j, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">No upcoming clients in coming in next 7 days.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </x-adminlte-card>
            </div>
        </div>

        @if ($season->total)
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <x-adminlte-card title="Current Season" collapsible="collapsed">
                        <p>Current Season Groups ({{ $season->currentSeasonStartDate->format('M') }} -
                            {{ $season->currentSeasonEndDate->format('M') }}) : {{ $season->total->totalGroupCurrentSeason }}
                        </p>
                        <p>Number of Clients ({{ $season->currentSeasonStartDate->format('M') }} -
                            {{ $season->currentSeasonEndDate->format('M') }}) :
                            {{ $season->total->totalTrekkersCurrentSeason }}</p>
                    </x-adminlte-card>
                </div>

                <div class="col-md-6 col-sm-12">
                    <x-adminlte-card title="Next Season" collapsible="collapsed">
                        <p>Next Season Groups ({{ $season->nextSeasonStartDate->format('M') }} -
                            {{ $season->nextSeasonEndDate->format('M') }}) : {{ $season->total->totalGroupNextSeason }}</p>
                        <p>Number of Clients ({{ $season->nextSeasonStartDate->format('M') }} -
                            {{ $season->nextSeasonEndDate->format('M') }}) :
                            {{ $season->total->totalTrekkersNextSeason ?? 0 }}</p>
                    </x-adminlte-card>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <x-adminlte-card title="Advanced Search" collapsible="collapsed">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Filter By Trip</label>
                            <x-adminlte-select name="filter_by_trip" id="filter-by-trip" class="select">
                                <option value="">Choose Option</option>
                                <option value="upcoming_trip">Upcoming Trip</option>
                                <option value="running_trip">Running Trip</option>
                                <option value="solo_trekker">Solo Trekker</option>
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-3">
                            <label>Filter By Pickup</label>
                            <x-adminlte-select name="filter_by_pickup" id="filter-by-pickup" class="select">
                                <option value="">Choose Option</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </x-adminlte-select>
                        </div>
                        <div class="col-md-3">
                            <label>Filter By Arrival Date</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="button" id="daterange-btn" class="btn btn-default w-100 text-left">
                                        <i class="far fa-calendar-alt"></i> <span>Filter by Date</span>
                                        <i class="fas fa-caret-down float-right"></i>
                                    </button>
                                    <input type="hidden" id="filter-by-date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Filter By Guide</label>
                            <x-adminlte-select name="filter_by_guide" id="filter-by-guide" class="select">
                                <option value="">Choose Option</option>
                                <option value="Yes">Guide Assigned</option>
                                <option value="No">Guide Not Assigned</option>
                            </x-adminlte-select>
                        </div>

                        @livewire('service.exporter')
                    </div>
                </x-adminlte-card>

                @livewire('common.user-package-filter', [
                    'upcomingRoute' => route('admin.home'),
                    'ongoingRoute' => route('admin.home', ['status' => 'ongoing']),
                    'completedRoute' => route('admin.home', ['status' => 'completed']),
                    'completedCurrentSeasonRoute' => route('admin.home', ['status' => 'completed-current-season']),
                    'currentSeasonRoute' => route('admin.home', ['status' => 'current-season']),
                    'nextSeasonRoute' => route('admin.home', ['status' => 'next-season']),
                    'soloRoute' => route('admin.home', ['status' => 'solo']),
                    'privateRoute' => route('admin.home', ['status' => 'private']),
                    'groupRoute' => route('admin.home', ['status' => 'group']),
                    'trashRoute' => route('admin.home', ['status' => 'trash']),
                ])
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="table-action">
                    <div class="form-group">
                        <select id="bulk-action" class="form-control">
                            <option value="-1">Bulk Actions</option>
                            @if (request()->filled('status') && request('status') === 'trash')
                                <option value="restore" data-url="{{ route('admin.clients.package.departure.restore') }}">Restore
                                </option>
                                <option value="permanently"
                                    data-url="{{ route('admin.clients.package.departure.delete_selected_permanently') }}">Delete
                                    Permanently</option>
                            @else
                                <option value="trash" data-url="{{ route('admin.clients.package.departure.delete_selected') }}">Move to
                                    trash</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" id="do-action" class="btn btn-primary"
                            onclick="bulkDelete('#clients')">Apply</button>
                    </div>

                    <div class="form-group">
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-filter"></i>
                            </button>

                            <div class="dropdown-menu">
                                <form class="px-3 py-1">
                                    <div class="form-group">
                                        @php
                                            $filters = ['Name', 'Email', 'Pickup', 'Package', 'Start Date', 'End Date', 'Booked Date', 'Status'];
                                            
                                            $key = 2;
                                        @endphp

                                        @foreach ($filters as $value)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" value="{{ $key++ }}">
                                                <label class="form-check-label font-weight-bold" for="dropdownCheck">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('admin.booking.create') }}" class="btn btn-success"><i class="far fa-calendar-alt"></i>  Create Booking</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <x-adminlte-card body-class="table-responsive">
                    <x-datatable id="clients" :table-header="[
                        'ID',
                        'Name',
                        'Email',
                        'Pickup',
                        'Package',
                        'Trek Group',
                        'Start Date',
                        'End Date',
                        'Booked Date',
                        'Status',
                        'Action',
                    ]" check-all="true" />
                </x-adminlte-card>
            </div>
        </div>
    @endrole

    @role('Guide')
        <div class="row">
            <div class="col-sm-12">
                Guide
            </div>
        </div>
    @endrole
@stop

@section('js')
    @role('Super Admin')
        @include('admin.includes.scripts')

        @php
            $route = match (request('status')) {
                'ongoing' => route('admin.clients.package.datatable', ['status' => 'ongoing']),
                'completed' => route('admin.clients.package.datatable', ['status' => 'completed']),
                'completed-current-season' => route('admin.clients.package.datatable', ['status' => 'completed-current-season']),
                'current-season' => route('admin.clients.package.datatable', ['status' => 'current-season']),
                'next-season' => route('admin.clients.package.datatable', ['status' => 'next-season']),
                'solo' => route('admin.clients.package.datatable', ['status' => 'solo']),
                'private' => route('admin.clients.package.datatable', ['status' => 'private']),
                'group' => route('admin.clients.package.datatable', ['status' => 'group']),
                'trash' => route('admin.clients.package.datatable', ['status' => 'trash']),
                default => route('admin.clients.package.datatable'),
            };
        @endphp

        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let options = {
                    processing: true,
                    serverSide: true,
                    order: [
                        [1, "desc"]
                    ],
                    ajax: {
                        url: '{{ $route }}',
                        data: function(d) {
                            d.filter_by_trip = $('#filter-by-trip').val();
                            d.filter_by_pickup = $('#filter-by-pickup').val();
                            d.filter_by_date = $('#filter-by-date').val();
                            d.filter_by_guide = $('#filter-by-guide').val();
                        }
                    },
                    columns: [
                        {
                            data: null
                        },
                        {
                            data: 'id'
                        },
                        {
                            data: 'name',
                            name: 'user.name',
                            width: '20%'
                        },
                        {
                            data: 'email',
                            name: 'user.email'
                        },
                        {
                            data: 'airport_pickup'
                        },
                        {
                            data: 'package',
                            name: 'package.name',
                            width: '15%'
                        },
                        {
                            data: 'trek_group'
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'action',
                            width: '5%',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    columnDefs: [{
                        targets: 0,
                        render: function(data, type, row) {
                            if (type === 'display') {
                                return '<input type="checkbox" class="delete_check" value="' + data.id +
                                    '">';
                            }

                            return data;
                        },
                        className: "dt-body-center",
                        orderable: false,
                        searchable: false,
                    }],
                    drawCallback: function() {
                        let hasRows = this.api().rows().data().length > 0;
                    },
                }

                let dataTable = $('#clients').DataTable(options);

                $('.dropdown-menu .form-check-input').click(function() {
                    let column = dataTable.column($(this).val());

                    column.visible(!column.visible());
                })

                dataTable.on('draw', function() {
                    $('[data-toggle="tooltip"]').tooltip();
                });

                $('.select').select2();

                $('.select').on('change.select2', function() {
                    dataTable.draw();
                })

                $('#daterange-btn').daterangepicker({
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                'month').endOf('month')],
                            'Last 6 Month': [moment().subtract(6, 'month'), moment()],
                            'Last Year': [moment().subtract(12, 'month'), moment()],
                            'This Year': [moment().startOf('year'), moment().endOf('year')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment()
                    },

                    function(start, end) {
                        $('#filter-by-date:input:hidden').val(start.format('YYYY-MM-DD') + ' ' + end.format(
                            'YYYY-MM-DD'));

                        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                            'MMMM D, YYYY'))

                        dataTable.draw();
                    }
                )

                $('.datepicker').flatpickr();
            });

            window.addEventListener('component-event', event => {
                if (event.detail.modal) {
                    $('#' + event.detail.modal).modal('hide');
                }
            })
        </script>
    @endrole
@stop
