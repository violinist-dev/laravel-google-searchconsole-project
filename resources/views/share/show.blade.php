@extends('layouts.app')

@section('content')

    <div class="col-sm-12">

        @if (session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif

        <div class="border-bottom mb-3">
            <h1>
                {{ $site->title }} {{ $site->url }}
            </h1>
        </div>

        <ul class="nav nav-tabs mb-1">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#now" role="tab">最新のデータ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#past" role="tab">過去のデータ</a>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="now" role="tabpanel">

                <div class="card mb-2">
                    <div class="card-block p-2">

                        {!! Form::open(['route' => ['share.show', $site->id], 'method' => 'post', 'class' => 'form-inline']) !!}
                        <div class="form-group">
                            {{ Form::select('dimension', [
                            'query' => '検索クエリ',
                            'page' => 'ページ'
                            ], $dimension, [
                            'class' => 'form-control'
                            ]) }}
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                {{ Form::number('year', $year, [
                                'class' => 'form-control',
                                'placeholder' => '年',
                                'aria-describedby' => 'year-addon'
                                ]) }}
                                <div class="input-group-append">
                                    <span class="input-group-text" id="year-addon">年</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                {{ Form::number('month', $month, [
                                'class' => 'form-control',
                                 'placeholder' => '月',
                                  'aria-describedby' => 'month-addon'
                                  ]) }}
                                <div class="input-group-append">
                                    <span class="input-group-text" id="month-addon">月</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::button('取得して表示', ['type' => 'submit', 'class' => 'btn btn-primary m-1', 'name' => 'action', 'value' => 'get']) }}
                        </div>

                        {!! Form::close() !!}

                        <small class="text-muted">取得できるのは90日前のデータまで。</small>
                    </div>

                </div>

                @include('sites.rows')
            </div>

            <div class="tab-pane" id="past" role="tabpanel">
                @include('sites.past', ['route_memo' => 'share.memo'])
            </div>

        </div>

    </div>


@endsection
