@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_users')
        <div class="row">
            <div class="col-sm-12 mb-2">
            	<a class="btn btn-primary" href="{{ route('admin.users.create') }}">Add User</a>
            </div>
        </div>
    @endcan

    @livewire('common.user-filter', [
        'role' => true,
        'route' => route('admin.users.index'),
        'trashRoute' => route('admin.users.index', ['status' => 'trash'])
    ])

    <div class="row">
        <div class="col-sm-12">
            <div class="table-action">
                <div class="form-group">
                    <select id="bulk-action" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        @if (request()->filled('status') && request('status') === 'trash')
                            <option value="restore" data-url="{{ route('admin.users.restore') }}">Restore</option>
                            <option value="permanently" data-url="{{ route('admin.users.delete_selected_permanently') }}">Delete Permanently</option>
                        @else
                            <option value="trash" data-url="{{ route('admin.users.delete_selected') }}">Move to trash</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="do-action" class="btn btn-primary" onclick="bulkDelete('#users')">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">

                <x-datatable 
                    id="users"
                    :table-header="['ID', 'Name', 'Email', 'Role', 'Action']"
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
            $route = route('admin.users.datatable', ['status' => 'trash']);
        } else {
            $route = route('admin.users.datatable');
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
                order: [[ 1, "asc" ]],
                ajax: '{{ $route }}',
                columns: [
                    {data: null},
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'role', name: 'roles.name'},
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

            $('#users').DataTable(options);
        });
    </script>
@stop
