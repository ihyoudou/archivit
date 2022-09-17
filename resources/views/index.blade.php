@extends('shared.main')
@section('body')

    <div class="container mt-5">
        @if(count($posts)>0)
            @foreach($posts as $post)
                <div class="d-flex justify-content-end">
                    <p>
                    @if($post->source->type == "subreddit")
                            <a href="/r/{{ $post->source->name }}">/r/{{ $post->source->name }}</a>
                    @else
                            <a href="/u/{{ $post->source->name }}">/u/{{ $post->source->name }}</a>
                    @endif
                    </p>
                    <a style="margin-left:5px" href="https://old.reddit.com{{$post->permalink }}" target="_blank">{{ $post->created_at }}</a>
                </div>
                <span><i class="bi bi-caret-up"></i>{{ $post->upvotes }}</span>
                <a href="{{$post->url}}" class="title"><h1>{{ $post->title }}</h1></a>
                <x-markdown>
                    {{ $post->selftext }}
                </x-markdown>
                <p>URL: <a href="{{$post->url}}" target="_blank">{{$post->url}}</a></p>
                @foreach($post->media_archive as $media)
                    @if($media->type == "image")
                        <img src="{{ env('APP_MEDIA_URL') }}/{{$media->uri}}" class="img-fluid" style="max-height:400px">
                    @elseif($media->type == "video")
                        <video
                            style="width:100%"
                            controls
                            src="{{ env('APP_MEDIA_URL') }}/{{$media->uri}}">
                        </video>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col">
                        <a href="/r/{{ $post->source->name }}/comments/{{ $post->reddit_id }}">
                            <span>
                                <i class="bi bi-chat-right-fill"></i>
                                Comments ({{ count($post->comments) }})
                            </span>
                        </a>

                    </div>
                    <div class="col d-flex justify-content-end">
                        <a href="/user/{{ $post->author->name }}"><span>{{ $post->author->name }}</span></a>
                    </div>
                </div>
            <hr>
            @endforeach
            <div class="d-flex">
                {!! $posts->links() !!}
            </div>
        @else
            <div class="d-flex justify-content-center">
                <h2>No posts found</h2>
            </div>
        @endif
    </div>
@endsection
