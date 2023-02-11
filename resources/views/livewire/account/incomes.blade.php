<div class="row">
    @foreach ($incomes as $income)
        @php
            $currencySign = match($income->code) {
                'usd' => 'fas fa-lg fa-dollar-sign',
                'euro' => 'fas fa-lg fa-euro-sign',
                'pound' => 'fas fa-lg fa-pound-sign',
                'rupee' => 'fas fa-lg fa-rupee-sign',
                default => 'fas fa-lg fa-coins'
            };
        @endphp

        <div class="col-md-3 col-sm-12">
            <x-adminlte-info-box :title="$income->name" :text="$income->symbol . $income->total" :icon="$currencySign" icon-theme="blue" />
        </div>
    @endforeach
</div>
