<a href="{{ route('sites.show', $site) }}" title="更新時間：{{ $site->updated_at }}">
    {{ str_replace(['http://', 'https://'], '', $site->url) }}
</a>
@if($site->fails > 0)
    <span class="badge badge-pill badge-danger">失敗 {{ $site->fails }}</span>
@endif
<br>
{{ $site->title }}
