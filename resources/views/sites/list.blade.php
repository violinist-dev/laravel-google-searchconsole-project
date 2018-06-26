@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">

                <h2>サイト追加 ({{ $sites->count() }}件)</h2>
                {{ Form::open(['url' => 'sites/create']) }}

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>追加</th>
                            <th>URL</th>
                            <th>確認</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach ($sites as $site)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <label>
                                            {{ Form::checkbox('url[]', $site['url'], ($site['permission'] === 'siteOwner'), ['class' => 'form-check-input position-static','aria-label' => $site['url']]) }}
                                        </label>
                                    </div>

                                </td>

                                <td>{{ $site['url'] }}</td>
                                <td>{{ $site['permission'] }}</td>
                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                    <div class="form-group">

                        <label>グループ</label>
                        {{ Form::text('group', '',  ['class' => 'form-control']) }}
                    </div>


                    {{ Form::hidden('access_token', $access_token) }}
                    {{ Form::hidden('refresh_token', $refresh_token) }}

                    <div class="form-group">

                        {{ Form::submit('追加', ['class' => 'btn btn-primary']) }}

                        <a href="{{ route('home') }}" class="btn btn-outline-secondary float-right">キャンセル</a>
                    </div>

                    {{ Form::close() }}

                </div>

            </div>

        </div>
    </div>
@endsection
