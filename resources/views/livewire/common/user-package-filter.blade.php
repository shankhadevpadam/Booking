<div class="row">
    <div class="col-sm-12">
        <ul class="table-nav">
            <li><a href="{{ $upcomingRoute }}" @class(['active' => ! request('status')])>Upcoming ({{ $data['upcomingTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $ongoingRoute }}" @class(['active' => request('status') === 'ongoing'])>Ongoing ({{ $data['ongoingTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $completedRoute }}" @class(['active' => request('status') === 'completed'])>Completed ({{ $data['completedTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $completedCurrentSeasonRoute }}" @class(['active' => request('status') === 'completed-current-season'])>Completed Current Season({{ $data['completedCurrentSeasonTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $currentSeasonRoute }}" @class(['active' => request('status') === 'current-season'])>Current Season ({{ $data['currentSeasonTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $nextSeasonRoute }}" @class(['active' => request('status') === 'next-season'])>Next Season ({{ $data['nextSeasonTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $soloRoute }}" @class(['active' => request('status') === 'solo'])>Solo ({{ $data['soloTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $privateRoute }}" @class(['active' => request('status') === 'private'])>Private ({{ $data['privateTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $groupRoute }}" @class(['active' => request('status') === 'group'])>Group ({{ $data['groupTotal'] ?? 0 }})</a></li>
            <li><a href="{{ $trashRoute }}" @class(['active' => request('status') === 'trash'])>Trash ({{ $data['trashedTotal'] ?? 0 }})</a></li>
        </ul>
    </div>
</div>