<thead class="thead-default">

<tr>
    <th>id</th>
    <th>URL</th>
    <th>メモ</th>

    <th>合計クリック数<br><br>先々月</th>
    <th>先月</th>
    <th>今月
        @if(isset($this_month))
            <span class="badge badge-info">{{ $this_month }}</span>
        @endif
    </th>

    <th>合計表示回数<br><br>先々月</th>
    <th>先月</th>
    <th>今月</th>

    <th>平均CTR<br><br>先々月</th>
    <th>先月</th>
    <th>今月</th>

    <th>平均掲載順位<br><br>先々月</th>
    <th>先月</th>
    <th>今月</th>

</tr>
</thead>
