@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_reviews')
        <div class="row">
            <div class="col-sm-12 mb-2">
            	<a class="btn btn-primary" href="{{ route('admin.reviews.create') }}">Add Review</a>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="col-sm-12">
            <div class="table-action mt-3">
                <div class="form-group">
                    <select id="bulk-action" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete" data-url="{{ route('admin.reviews.delete_selected') }}">Delete Selected</option>
                        <option value="completely" data-url="{{ route('admin.reviews.delete_completely') }}">Delete Completely</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="do-action" class="btn btn-primary" onclick="bulkDelete('#reviews')">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">

                <x-datatable 
                    id="reviews"
                    :table-header="['ID', 'Name', 'Title', 'Package', 'Rating', 'Guide', 'Status', 'Action']"
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
                ajax: '{{ route('admin.reviews.datatable') }}',
                columns: [
                    {data: null},
                    {data: 'id'},
                    {data: 'name', name: 'user.name'},
                    {data: 'title'},
                    {data: 'package', name: 'package.name'},
                    {data: 'rating'},
                    {data: 'guide', name: 'guide.name'},
                    {data: 'is_published', render: function (data, type, row) {
                        return data === 1
                            ? '<span class="badge badge-success">Published</span>' 
                            : '<span class="badge badge-warning">Pending</span>';
                    }, searchable: false},
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

            $('#reviews').DataTable(options);
        });
    </script>
@stop