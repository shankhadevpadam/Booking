<div class="row">
    <div class="col-sm-12">
        <ul class="table-nav">
            <li><a href="{{ $route }}" @class(['active' => ! request('status')])>All ({{ $data['countTotalRecords'] }})</a></li>
            <li><a href="{{ $trashRoute }}" @class(['active' => request('status') === 'trash'])>Trash ({{ $data['countTotalTrashedRecords'] }})</a></li>
        </ul>
    </div>
</div>
