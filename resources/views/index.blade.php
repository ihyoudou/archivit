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
                <h1>{{ $post->title }}</h1>
                <x-markdown>
                    {{ $post->selftext }}
                </x-markdown>
                <div class="row">
                    <div class="col">
                        <span><i class="bi bi-arrow-up-circle"></i>{{ $post->upvotes }}</span>
                        <span><i class="bi bi-arrow-down-circle"></i>{{ $post->downvotes }}</span>

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
