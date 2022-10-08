<div>
    @foreach($comments as $comment)
        <div
                class="card"
                {{-- checking if comment is a reply to main post --}}
                @if(strpos($comment->parent_id, "t3_"))
                    style="width:90%"
                @endif
        >
            <div class="card-body">
{{--                parent: {{$comment->parent_id}}<br>--}}
{{--                ownid: {{$comment->rid}}<br>--}}
                <a href="/user/{{$comment->get_author->name}}">{{$comment->get_author->name}}</a>
                <x-markdown>
                    {{$comment->body}}
                </x-markdown>
                <span><i class="bi bi-caret-up"></i>{{ $comment->score }}</span> |
{{--                <a href="https://old.reddit.com{{$post->permalink}}{{substr($comment->rid, 3)}}" target="_blank">--}}
                    {{$comment->created_at}}
{{--                </a>--}}

                <div style="width:90%">
                    @if(count($comment->replies)>0)
                        <livewire:show-comments :post_rid="$comment->rid">
                    @endif
                </div>
            </div>
        </div>

    @endforeach
</div>
