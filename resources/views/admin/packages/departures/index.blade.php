@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.FlatPickr', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_packages')
        <div class="row">
            <div class="col-sm-12 mb-2">
                <a class="btn btn-primary" href="{{ route('admin.packages.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#package-departure">Create Departure</button>
            	<a class="btn btn-primary" href="{{ route('admin.packages.departures.create', ['package' => $package]) }}">Add Departure</a>
            </div>
        </div>
    @endcan

    @livewire('common.filter', [
        'model' => new App\Models\PackageDeparture(),
        'filter' => ['package_id' => $package->id],
        'route' => route('admin.packages.departures.index', $package),
        'trashRoute' => route('admin.packages.departures.index', ['package' => $package, 'status' => 'trash'])
    ])

    <div class="row">
        <div class="col-sm-12">
            <div class="table-action">
                <div class="form-group">
                    <select id="bulk-action" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        @if (request()->filled('status') && request('status') === 'trash')
                            <option value="restore" data-url="{{ route('admin.packages.departures.restore', $package) }}">Restore</option>
                            <option value="permanently" data-url="{{ route('admin.packages.departures.delete_selected_permanently', $package) }}">Delete Permanently</option>
                        @else
                            <option value="trash" data-url="{{ route('admin.packages.departures.delete_selected', $package) }}">Move to trash</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="do-action" class="btn btn-primary" onclick="bulkDelete('#departures')">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">

                <x-datatable 
                    id="departures"
                    :table-header="['ID', 'Start Date', 'End Date', 'Price', 'Discount Type', 'Discount Apply On', 'Discount Amount', 'Sold Out', 'Total Quantity', 'Action']"
                    check-all="true"
                />

            </x-adminlte-card>
        </div>
    </div>

    <!-- Modal -->
    @livewire('package.package-departure', ['packageId' => $package])
@stop

@section('js')
    @include('admin.includes.scripts')

    @php
        if (request()->filled('status') && request('status') === 'trash') {
            $route = route('admin.packages.departures.datatable', ['package' => $package, 'status' => 'trash']);
        } else {
            $route = route('admin.packages.departures.datatable', $package);
        }
    @endphp

    <script type="text/javascript">
        $(document).ready(function () {
            $('.datepicker').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today",
                allowInput: true,
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let options = {
                processing: true,
                serverSide: true,
                order: [[ 1, "asc"]],
                ajax: '{{ $route }}',
                columns: [
                    {data: null},
                    {data: 'id'},
                    {data: 'start_date'},
                    {data: 'end_date'},
                    {data: 'price'},
                    {data: 'discount_type'},
                    {data: 'discount_apply_on'},
                    {data: 'discount_amount'},
                    {data: 'sold_quantity'},
                    {data: 'total_quantity'},
                    {data: 'action', width: '10%', orderable: false, searchable: false}
                ],
                columnDefs: [
                    {
                        targets: 0,
                        render: function (data, type, row) {
                            if (type === 'display') {
                                return '<input type="checkbox" class="delete_check" value="'+ data.id +'">';
                            }

                            return data;
                        },
                        className: "dt-body-center",
                        orderable: false,
                        searchable: false,
                    }
                ],
                drawCallback: function() {
                    let hasRows = this.api().rows().data().length > 0;
                }
            }

            $('#departures').DataTable(options);
        });

        Livewire.on('updateDatatable', () => {
            $('#package-departure').modal('hide');

            $('#departures').DataTable().ajax.reload(null, false);
        });
    </script>
@stop