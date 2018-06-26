@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-sm-12">

                <h2>サイト ({{ $sites->count() }}件)</h2>

                <div class="card mb-2">
                    <div class="card-header">

                        <ul class="nav nav-tabs card-header-tabs">
                            @foreach($groups as $group)
                                @include('home.group')
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-body p-0">

                        <table class="table table-responsive table-striped table-bordered table-hover table-sm"
                               id="sort-table">
                            @include('home.head')

                            <tbody>

                            @foreach ($sites as $site)
                                @if(empty($input_group) or $input_group === config('sc.group_all') or $input_group === $site->group or ($input_group === config('sc.group_empty') and empty($site->group)))
                                    @include('home.site')
                                @endif
                            @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
