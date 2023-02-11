<div>
    {{-- <div class="dropdown d-inline-block">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
            Export by Filter
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="javascript:;" wire:click="exportByFilter('upcoming')">Upcoming</a>
            <a class="dropdown-item" href="javascript:;" wire:click="exportByFilter('ongoing')">Ongoing</a>
            <a class="dropdown-item" href="javascript:;" wire:click="exportByFilter('completed')">Completed</a>
            <a class="dropdown-item" href="javascript:;" wire:click="exportByFilter('coming-season')">Coming Season</a>
            <a class="dropdown-item" href="javascript:;" wire:click="exportByFilter('next-season')">Next Season</a>
        </div>
    </div> --}}

    {{-- <div class="d-inline-block">
        <button type="button" class="btn btn-default" id="daterange-export-filter-btn">
            <i class="far fa-calendar-alt"></i> <span>Export by Date</span>
            <i class="fas fa-caret-down"></i>
        </button>
        <input type="hidden" id="filter_by_date_export">
    </div> --}}

    <div class="col-sm-12">
        <button id="export-data" class="btn btn-success"><i class="fas fa-file-export"></i> Export</button>
    </div>
</div>

@push('js')

    <script>
        $('#export-data').click(function () {
            let params = {}
            
            if ($('#filter-by-date').val()) {
                params.dates = $('#filter-by-date').val()
            }

            if ($('#filter-by-trip').val()) {
                params.trip = $('#filter-by-trip').val()
            }

            if ($('#filter-by-pickup').val()) {
                params.pickup = $('#filter-by-pickup').val()
            }

            if ($('#filter-by-guide').val()) {
                params.guide = $('#filter-by-guide').val()
            }

            if (Object.keys(params).length > 0) {
                Livewire.emit('exportByDate', JSON.stringify(params))
            }
        })
    </script>
    
@endpush