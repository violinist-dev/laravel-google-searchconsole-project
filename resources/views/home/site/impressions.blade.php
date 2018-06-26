<td>{{ $impressions[$id][2] }}</td>

@if($impressions[$id][2] > $impressions[$id][1])
    <td class="table-danger">{{ $impressions[$id][1] }}</td>
@elseif($impressions[$id][2] < $impressions[$id][1])
    <td class="table-success">{{ $impressions[$id][1] }}</td>
@else
    <td>{{ $impressions[$id][1] }}</td>
@endif

@if($impressions[$id][1] > $impressions[$id][0])
    <td class="table-danger">{{ $impressions[$id][0] }}</td>
@elseif($impressions[$id][1] < $impressions[$id][0])

    <td class="table-success">{{ $impressions[$id][0] }}</td>
@else
    <td>{{ $impressions[$id][0] }}</td>
@endif
