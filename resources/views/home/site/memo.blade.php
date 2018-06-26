@if(!is_null($site->totals) and $site->totals->count() > 0)
    <p>{{ $site->totals->first()->memo ?? '' }}</p>
    <small>{{ $site->totals->first()->memo_at ?? ''}}</small>
@endif
