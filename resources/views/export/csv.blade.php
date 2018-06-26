<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table>
    <tr>
        <th>クエリ</th>
        <th>クリック数</th>
        <th>表示回数</th>
        <th>CTR</th>
        <th>掲載順位</th>

    </tr>
    @foreach($rows as $row)
        <tr>
            <td>{{ $row->keys[0] }}</td>
            <td>{{ $row->clicks }}</td>
            <td>{{ $row->impressions }}</td>
            <td>{{ round($row->ctr*100, 2) }} %</td>
            <td>{{ round($row->position, 1) }}</td>
        </tr>
    @endforeach
</table>

</html>
