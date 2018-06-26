<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover table-sm">
    <thead class="thead-inverse">
    <tr>
      <th>月</th>
      <th>合計クリック数</th>
      <th>合計表示回数</th>
      <th>平均CTR</th>
      <th>平均掲載順位</th>
      <th>メモ</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($site->totals as $total)

      <tr>
        <td>{{  $total->month->format('Y-m') }}
        </td>
        <td>{{ $total->clicks }}</td>
        <td>{{ $total->impressions }}</td>
        <td>{{ $total->ctr }} %</td>
        <td>{{ $total->position }}</td>
        <td>
          {!! Form::open(['route' => [$route_memo, $site->id, $total->id], 'method' => 'post', 'class' => 'form-inline']) !!}

          {{ Form::text('memo', $total->memo,  ['class' => 'form-control']) }}
          {{ Form::hidden('month', $total->month->format('Y-m'),  ['class' => 'form-control']) }}

          {{ Form::submit('更新', ['class' => 'btn btn-primary ml-1']) }}
          {!! Form::close() !!}

        </td>

      </tr>
    @endforeach

    </tbody>
  </table>
</div>
