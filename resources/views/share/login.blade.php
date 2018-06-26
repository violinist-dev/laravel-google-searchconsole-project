@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="card p-3">
                    <div class="card-block">
                        <h2 class="card-title">ログイン</h2>
                        <form role="form" method="POST" action="{{ route('share.login', $site) }}">

                            {{ csrf_field() }}

                            <fieldset class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <label for="password" class="col-md-4 form-control-label">パスワード</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control{{ $errors->has('password') ? ' form-control-danger' : '' }}"
                                           name="password">

                                    @if ($errors->has('password'))
                                        <span class="text-muted">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                                    @endif
                                </div>
                            </fieldset>


                            <fieldset class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> ログイン
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
