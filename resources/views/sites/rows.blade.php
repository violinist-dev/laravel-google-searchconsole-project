@if(count($query_rows) > 0)
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-sm">
            <thead class="thead-inverse">
            <tr>
                <th>合計クリック数</th>
                <th>合計表示回数</th>
                <th>平均CTR</th>
                <th>平均掲載順位</th>
            </tr>
            </thead>

            <tbody>

            <tr>
                <td>{{ $clicks }}</td>
                <td>{{ $impressions }}</td>
                <td>{{ $ctr }}</td>
                <td>{{ $position }}</td>

            </tr>

            </tbody>

        </table>

    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-sm" id="sort-table">
            <thead class="thead-default">
            <tr>
                <th>クエリ</th>
                <th>クリック数</th>
                <th>表示回数</th>
                <th>CTR</th>
                <th>掲載順位</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($query_rows as $row)
                @php
                    $class = '';
                    $position = round($row->position, 1);
                    $ctr = round($row->ctr * 100, 2);
                    if ($position < 11 and $ctr > 0 and $ctr < 20) {
                      $class = ' class="table-danger"';
                    } elseif ($position == 1) {
                      $class = ' class="table-success"';
                    }

                    if ($dimension === 'query') {
                      $query_dimension = 'page';
                      $query_filter_dimension = 'query';
                    } else {
                      $query_dimension = 'query';
                      $query_filter_dimension = 'page';
                    }

                    $url = '/' . request()->path() . "?" . http_build_query([
                        'dimension'        => $query_dimension,
                        'year'             => $year,
                        'month'            => $month,
                        'filter'           => $row->keys[0],
                        'filter_dimension' => $query_filter_dimension
                      ]);

                    $query_item = $row->keys[0];

                @endphp

                <tr{!! $class !!}>
                    <td>
                        @if($dimension === 'query')
                            <a href="https://www.google.co.jp/search?q={{ $query_item }}" target="_blank" class="mr-1">
                                <i class="fa fa-google" aria-hidden="true"></i>
                            </a>
                        @else
                            <a href="{{ $query_item }}" target="_blank" class="mr-1">
                                <i class="fa fa-share-square" aria-hidden="true"></i>
                            </a>
                        @endif
                        <a href="{{ $url }}" title="{{ $query_item }}">{{ str_limit($query_item, 80) }}</a></td>
                    <td>{{ $row->clicks }}</td>
                    <td>{{ $row->impressions }}</td>
                    <td>{{ round($row->ctr*100, 2) }} %</td>
                    <td>{{ round($row->position, 1) }}</td>

                </tr>
            @endforeach

            </tbody>

        </table>
    </div>

@else
    データがありません。
@endif
