@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_locations')
        <div class="row">
            <div class="col-sm-12 mb-2">
            	<a class="btn btn-primary" href="{{ route('admin.locations.create') }}">Add Location</a>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="col-sm-12">
            <div class="table-action mt-3">
                <div class="form-group">
                    <select id="bulk-action" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete" data-url="{{ route('admin.locations.delete_selected') }}">Delete Selected</option>
                        <option value="completely" data-url="{{ route('admin.locations.delete_completely') }}">Delete Completely</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="do-action" class="btn btn-primary" onclick="bulkDelete('#locations')">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">
                <x-datatable 
                    id="locations"
                    :table-header="['ID', 'Name', 'Type', 'Action']"
                    check-all="true"
                    />
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
    @include('admin.includes.scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            let options = {
                processing: true,
                serverSide: true,
                order: [[ 1, "desc" ]],
                ajax: '{{ route('admin.locations.datatable') }}',
                columns: [
                    {data: null},
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'type'},
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

            $('#locations').DataTable(options);
        });
    </script>
@stop