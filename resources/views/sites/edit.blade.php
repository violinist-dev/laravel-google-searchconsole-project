@extends('layouts.app')

@section('content')

    <div class="col-sm-12">

        <a href="{{ route('sites.show', ['id' => $site->id]) }}">戻る</a>

        <h2>{{ $site->title }} {{ $site->url }} 設定</h2>

        <div class="card my-3">
            <div class="card-body">

                {{ Form::open(['route' => ['sites.update', $site->id], 'method' => 'put', 'class' => 'form-horizontal']) }}

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">サイトタイトル</label>

                    <div class="col-sm-10">
                        {{ Form::text('title', $site->title, ['class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">グループ</label>

                    <div class="col-sm-10">
                        {{ Form::text('group', $site->group, ['class' => 'form-control']) }}
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-10 ml-auto">

                        {{ Form::submit('変更', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>

                {{ Form::close() }}
            </div>

        </div>


        <div class="card my-3">
            <div class="card-body">

                {{ Form::open(['route' => ['sites.password', $site->id], 'method' => 'put', 'class' => 'form-horizontal']) }}

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">共有用パスワード（設定済でも表示されません。）</label>

                    <div class="col-sm-4">
                        {{ Form::password('shared', ['class' => 'form-control']) }}

                        <a href="{{ route('share.show',  $site->id) }}" target="_blank">{{ route('share.show', $site->id) }}</a>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 ml-auto">

                        {{ Form::submit('変更', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>

                {{ Form::close() }}
            </div>

        </div>


        <div class="card border-danger my-3">
            <div class="card-header">非表示</div>

            <div class="card-body">

                <p>一覧から非表示、データ取得されなくなります。サイト追加からやり直すと再度表示されます。</p>
                <a class="btn btn-danger" href="{{ route('sites.hide', $site->id) }}" role="button">非表示</a>
            </div>

        </div>

    </div>


@endsection
