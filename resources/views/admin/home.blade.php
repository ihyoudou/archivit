@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="row text-center">
                            <div class="col">
                                <h1>{{$archive_list_count}}</h1>
                                Elements to archive
                            </div>
                            <div class="col">
                                <h1>{{$posts_archived_count}}</h1>
                                Post archived
                            </div>
                            <div class="col">
                                <h1>{{$comments_archived_count}}</h1>
                                Comments archived
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
