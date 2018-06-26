<td>{{ $ctrs[$id][2] }} %</td>

@if($ctrs[$id][2] > $ctrs[$id][1])
    <td class="table-danger">{{ $ctrs[$id][1] }} %</td>
@elseif($ctrs[$id][2] < $ctrs[$id][1])
    <td class="table-success">{{ $ctrs[$id][1] }} %</td>
@else
    <td>{{ $ctrs[$id][1] }} %</td>
@endif

@if($ctrs[$id][1] > $ctrs[$id][0])
    <td class="table-danger">{{ $ctrs[$id][0] }} %</td>
@elseif($ctrs[$id][1] < $ctrs[$id][0])
    <td class="table-success">{{ $ctrs[$id][0] }} %</td>
@else
    <td>{{ $ctrs[$id][0] }} %</td>
@endif
