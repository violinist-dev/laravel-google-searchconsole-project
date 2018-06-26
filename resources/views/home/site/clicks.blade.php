<td>{{ $clicks[$id][2] }}</td>

@if($clicks[$id][2] > $clicks[$id][1])
    <td class="table-danger">{{ $clicks[$id][1] }}</td>
@elseif($clicks[$id][2] < $clicks[$id][1])
    <td class="table-success">{{ $clicks[$id][1] }}</td>
@else
    <td>{{ $clicks[$id][1] }}</td>
@endif

@if($clicks[$id][1] > $clicks[$id][0])
    <td class="table-danger">{{ $clicks[$id][0] }}</td>
@elseif($clicks[$id][1] < $clicks[$id][0])
    <td class="table-success">{{ $clicks[$id][0] }}</td>
@else
    <td>{{ $clicks[$id][0] }}</td>
@endif
