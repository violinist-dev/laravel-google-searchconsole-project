@extends('layouts.app')

@section('content')

  <div class="col-sm-12">

    <h2>サイト ({{ $sites->count() }}件)
      <a href="{{ action('SiteController@add') }}"
         class="btn btn-outline-primary"
         data-toggle="tooltip"
         data-html="true"
         data-placement="bottom"
         title="1.Googleアカウントで認証。<br>2.Search Consoleに登録しているURLが出てくるので追加。<br>3.アカウントごとに繰り返し。"
      >サイト追加</a>
    </h2>

    <div class="card mb-2">
      <div class="card-header">

        <ul class="nav nav-tabs card-header-tabs">
          @foreach($groups as $group)
            @php
              $class = ($group == $input_group) ? ' active' : '';
            @endphp

            <li class="nav-item">
              <a href="/sites?group={{ $group }}" class="nav-link{{ $class }}">{{ $group }}
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
          @endforeach
        </ul>
      </div>

      <div class="card-body p-0">

        <table class="table table-responsive table-striped table-bordered table-hover table-sm" id="sort-table">
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

          <tbody>

          @foreach ($sites as $site)
            @if(empty($input_group) or $input_group === config('sc.group_all') or $input_group === $site->group or ($input_group === config('sc.group_empty') and empty($site->group)))
              <tr>
                <td>{{ $site->id }}</td>
                <td>
                  <a href="/sites/{{ $site->id }}" title="更新時間：{{ $site->updated_at }}">
                    {{ str_replace(['http://', 'https://'], '', $site->url) }}
                  </a>
                  @if($site->fails > 0)
                    <span class="badge badge-pill badge-danger">失敗 {{ $site->fails }}</span>
                  @endif
                  <br>
                  {{ $site->title }}
                </td>

                <td>
                  @if(!is_null($site->totals) and $site->totals->count() > 0)
                    <p>{{ $site->totals->first()->memo ?? '' }}</p>
                    <small>{{ $site->totals->first()->memo_at ?? ''}}</small>
                  @endif
                </td>

                @php
                  $id = $site->id;
                @endphp

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


                <td>{{ $positions[$id][2] }}</td>

                @if($positions[$id][2] > $positions[$id][1])
                  <td class="table-danger">{{ $positions[$id][1] }}</td>
                @elseif($positions[$id][2] < $positions[$id][1])
                  <td class="table-success">{{ $positions[$id][1] }}</td>
                @else
                  <td>{{ $positions[$id][1] }}</td>
                @endif

                @if($positions[$id][1] > $positions[$id][0])
                  <td class="table-danger">{{ $positions[$id][0] }}</td>
                @elseif($positions[$id][1] < $positions[$id][0])
                  <td class="table-success">{{ $positions[$id][0] }}</td>
                @else
                  <td>{{ $positions[$id][0] }}</td>
                @endif


              </tr>
            @endif

          @endforeach

          </tbody>

        </table>


      </div>

    </div>


    <a href="/logout" class="btn btn-outline-secondary">ログアウト</a>

  </div>



@endsection
