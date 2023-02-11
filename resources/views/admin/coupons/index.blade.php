@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_coupons')
        <div class="row">
            <div class="col-sm-12 mb-2">
            	<a class="btn btn-primary" href="{{ route('admin.coupons.create') }}">Add Coupon</a>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="col-sm-12">
            <div class="table-action mt-3">
                <div class="form-group">
                    <select id="bulk-action" class="form-control">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete" data-url="{{ route('admin.coupons.delete_selected') }}">Delete Selected</option>
                        <option value="completely" data-url="{{ route('admin.coupons.delete_completely') }}">Delete Completely</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="do-action" class="btn btn-primary" onclick="bulkDelete('#coupons')">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">
                <x-datatable 
                    id="coupons"
                    :table-header="['ID', 'Package', 'Name', 'Code', 'Discount Type', 'Discount Apply On', 'Expire Date', 'Action']"
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
                ajax: '{{ route('admin.coupons.datatable') }}',
                columns: [
                    {data: null},
                    {data: 'id'},
                    {data: 'package'},
                    {data: 'name'},
                    {data: 'code'},
                    {data: 'discount_type'},
                    {data: 'discount_apply_on'},
                    {data: 'expire_date'},
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

            $('#coupons').DataTable(options);
        });
    </script>
@stop