@extends('adminlte::page')

@section('title', $title ?? '')

@section('plugins.Moment', true)

@section('plugins.DateRangePicker', true)

@section('plugins.Datatables', true)

@section('content_header')
    <h1>{{ $title ?? '' }}</h1>
@stop

@section('content')
    @livewire('account.incomes')

    <div class="row">
        <div class="col-sm-12">
            <x-adminlte-card body-class="table-responsive">
                <div class="d-flex justify-content-between">
                    <div class="form-group d-inline-block">
                        <div class="input-group">
                            <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                <i class="far fa-calendar-alt"></i> <span>Filter by date</span>
                                <i class="fas fa-caret-down"></i>
                            </button>
                            <input type="hidden" id="filter_by_range">
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter"></i>
                        </button>

                        <div class="dropdown-menu">
                            <form class="px-3 py-1">
                                <div class="form-group">
                                    @php($filters = ['Name', 'Package', 'Guide', 'Advanced Amount', 'Fee', 'Total', 'Remaining Amount', 'Fee', 'Total', 'Gross Total', 'Net Total'])

                                    @foreach ($filters as $key => $value)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" value="{{ ++$key }}">
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

                <x-datatable 
                    id="incomes"
                    :table-header="['ID', 'Name', 'Package', 'Guide', 'Advanced Amount', 'Fee', 'Total', 'Remaining Amount', 'Fee', 'Total', 'Gross Total', 'Net Total']"
                >
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </x-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('js')
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
                order: [[ 0, "desc" ]],
                ajax: {
                    url: '{{ route('admin.incomes.datatable') }}',
                    data: function (d) {
                        d.filter_by_range = $('#filter_by_range').val()
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'user.name'},
                    {data: 'package.name'},
                    {data: 'agency', name: 'agency.guide.name'},
                    {data: 'advanced_amount'},
                    {data: 'advanced_amount_bank_charge'},
                    {data: 'advanced_total'},
                    {data: 'remaining_amount'},
                    {data: 'remaining_amount_bank_charge'},
                    {data: 'remaining_total'},
                    {data: 'gross_total'},
                    {data: 'net_total'},
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(), data;
        
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    $(api.column(3).footer()).html('Total');

                    for (j=4; j<=11; j++) {
                        let total = api.column(j).data().reduce( function (a, b) {
                            let amount = intVal(a) + intVal(b);

                            amount = amount.toFixed(2);

                            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }, 0 );

                        $(api.column(j).footer()).html(total);
                    }
                }
            }

            let dataTable = $('#incomes').DataTable(options);

            $('.dropdown-menu .form-check-input').click(function () {
                let column = dataTable.column($(this).val());

                column.visible(!column.visible());
            })

            $('#daterange-btn').daterangepicker({
                ranges : {
                    'Today'        : [moment(), moment()],
                    'Yesterday'    : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days'  : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days' : [moment().subtract(29, 'days'), moment()],
                    'This Month'   : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'   : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 6 Month' : [moment().subtract(6, 'month'), moment()],
                    'Last Year'    : [moment().subtract(12, 'month'), moment()],
                    'This Year'    : [moment().startOf('year'), moment().endOf('year')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
                },

                function (start, end) {
                    $('#filter_by_range:input:hidden').val(start.format('YYYY-MM-DD') + ' ' + end.format('YYYY-MM-DD'))

                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))

                    dataTable.draw();
                    
                    Livewire.emit('filterByDate', start.format('YYYY-MM-DD') + ' ' + end.format('YYYY-MM-DD'))
                }
            )
        });
    </script>
@stop