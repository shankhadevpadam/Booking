@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_clients')
        <div class="row">
            <div class="col-sm-12 mb-2">
            	<a class="btn btn-primary" href="{{ route('admin.clients.create') }}">Add Client</a>
            </div>
        </div>
    @endcan

    @livewire('common.user-filter', [
        'role' => 'Client',
        'route' => route('admin.clients.index'),
        'trashRoute' => route('admin.clients.index', ['status' => 'trash'])
    ])

    <div class="row">
        <div class="col-sm-12">
            <div class="table-action">
                <div class="form-group">
                    <select id="bulk-action" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        @if (request()->filled('status') && request('status') === 'trash')
                            <option value="restore" data-url="{{ route('admin.clients.restore') }}">Restore</option>
                            <option value="permanently" data-url="{{ route('admin.clients.delete_selected_permanently') }}">Delete Permanently</option>
                        @else
                            <option value="trash" data-url="{{ route('admin.clients.delete_selected') }}">Move to trash</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="do-action" class="btn btn-primary" onclick="bulkDelete('#clients')">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">

                <x-datatable 
                    id="clients"
                    :table-header="['ID', 'Name', 'Email', 'Action']"
                    check-all="true"
                />
                
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
    @include('admin.includes.scripts')

    @php
        if (request()->filled('status') && request('status') === 'trash') {
            $route = route('admin.clients.datatable', ['status' => 'trash']);
        } else {
            $route = route('admin.clients.datatable');
        }
    @endphp

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
                ajax: '{{ $route }}',
                columns: [
                    {data: null},
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'action', width: '20%', orderable: false, searchable: false}
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

            $('#clients').DataTable(options);
        }); 
    </script>
@stop
