<tr>
    <td>{{ $site->id }}</td>
    <td>
        @include('home.site.url')
    </td>

    <td>
        @include('home.site.memo')
    </td>

    @php
        $id = $site->id;
    @endphp

    @include('home.site.clicks')
    @include('home.site.impressions')
    @include('home.site.ctrs')
    @include('home.site.positions')

</tr>
