@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Datatables', true)

@section('plugins.Datepicker', true)

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
	@can('add_packages')
        <div class="row">
            <div class="col-sm-12 mb-2">
                <a class="btn btn-primary" href="{{ route('admin.packages.index') }}"><i class="fas fa-chevron-left"></i> Back</a>
            	<a class="btn btn-primary" href="{{ route('admin.packages.discounts.create', ['package' => $package]) }}">Add Discount</a>
            </div>
        </div>
    @endcan

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">

                <x-datatable 
                    id="discounts"
                    :table-header="['ID', 'No of People', 'Price', 'Action']"
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
                order: [[0, "asc"]],
                ajax: '{{ route('admin.packages.discounts.datatable', $package) }}',
                columns: [
                    {data: 'id'},
                    {data: 'number_of_people'},
                    {data: 'price'},
                    {data: 'action', width: '10%', orderable: false, searchable: false}
                ]
            }

            $('#discounts').DataTable(options);
        });
    </script>
@stop