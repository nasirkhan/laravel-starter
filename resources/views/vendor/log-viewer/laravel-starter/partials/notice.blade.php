<div class="card">
    <div class="card-body {{ $item['count'] === 0 ? '' : 'text-white bg-success' }}">
        <div class="text-value">
            {!! log_styler()->icon($level) !!} {{ $item['name'] }}
        </div>
        <div>{{ $item['count'] }} entries - {!! $item['percent'] !!} %</div>
        <div class="progress progress-white progress-xs my-2">
            <div class="progress-bar" role="progressbar" style="width: {{ $item['percent'] }}%" aria-valuenow="{{ $item['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $item['name'] }}: {{ $item['count'] }} entries - {!! $item['percent'] !!} %</small>
    </div>
</div>
