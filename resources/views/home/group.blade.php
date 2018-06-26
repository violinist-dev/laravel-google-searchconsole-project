@php
    $class = ($group == $input_group) ? ' active' : '';
@endphp

<li class="nav-item">
    <a href="{{ route('home', ['group' => $group]) }}" class="nav-link{{ $class }}">{{ $group }}
        @if($group === config('sc.group_empty'))
            <span class="badge badge-pill badge-primary">
                {{ $sites->where('group', '')->count() }}
              </span>
        @elseif(!in_array($group, [config('sc.group_all')], true))
            <span class="badge badge-pill badge-primary">
                {{ $sites->where('group', $group)->count() }}
              </span>
        @endif
    </a>
</li>
