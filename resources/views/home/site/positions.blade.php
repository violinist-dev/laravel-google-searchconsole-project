<td>{{ $positions[$id][2] }}</td>

@if($positions[$id][2] < $positions[$id][1])
    <td class="table-danger">{{ $positions[$id][1] }}</td>
@elseif($positions[$id][2] > $positions[$id][1])
    <td class="table-success">{{ $positions[$id][1] }}</td>
@else
    <td>{{ $positions[$id][1] }}</td>
@endif

@if($positions[$id][1] < $positions[$id][0])
    <td class="table-danger">{{ $positions[$id][0] }}</td>
@elseif($positions[$id][1] > $positions[$id][0])
    <td class="table-success">{{ $positions[$id][0] }}</td>
@else
    <td>{{ $positions[$id][0] }}</td>
@endif
