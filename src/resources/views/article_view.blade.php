@extends('layouts.copy')

@section('content')
<head>
    <link href="{{ asset('assets/css/article_view.css') }}" rel="stylesheet">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div class="container">
    <div class="article_area">
        <div class="article">
            <div class="text_area">
                @if(isset( $article->path ))
                    <img class="article_img" src="{{ asset($article->path) }}">
                @else
                    <img class="article_img" src="{{ asset('images/article.jpg') }}">
                @endif
                <h1 class="title">{{ $article->title }}</h1>
                <div class="user_area">
                    @if(Auth::check() && $article->user_id === Auth::user()->id)
                        <a href="{{ route('Profile') }}">
                        <p class="user">投稿者：{{ $article_user->name }}</p>
                        </a>
                    @else
                        <a href="{{ route('user_page', ['id'=>$article->user_id]) }}">
                        <p class="user">投稿者：{{ $article_user->name }}</p>
                        </a>
                    @endif
                    @if($user_id !== $article->user_id)
                        @if(isset( $already_followed ))
                            <button class="follow" onclick="follow({{ $article->user_id }})" style="display: none">フォロー</button>
                            <button class="un_follow" onclick="destroy({{ $article->user_id }})">フォロー解除</button>
                        @else
                            <button class="follow" onclick="follow({{ $article->user_id }})">フォロー</button>
                            <button class="un_follow" onclick="destroy({{ $article->user_id }})" style="display: none">フォロー解除</button>
                        @endif
                    @endif
                </div>
                <div class="like_date_area">
                    <div class="like_area">
                    @if(isset( $already_liked ))
                        <i class="fas fa-heart fa-lg un_nice" onclick="unlike({{$article->id}})"></i>
                        <i class="far fa-heart fa-lg nice" onclick="like({{ $article->id }})" style="display:none"></i>
                    @else
                        <i class="far fa-heart fa-lg nice" onclick="like({{ $article->id }})"></i>
                        <i class="fas fa-heart fa-lg un_nice" onclick="unlike({{ $article->id }})" style="display:none"></i>
                    @endif
                    </div>
                    <p class="date">{{ \Carbon\Carbon::createFromTimeString($article->updated_at)->format('Y/m/d') }}</p>
                </div>
                <div class="tag_area">
                @foreach($article->tags as $tag)
                    <p class="tag">#{{ $tag->name }}</p>
                @endforeach
                </div>
                <p class="text">{{ $article->content }}</p>
            </div>
            <div class="comment_area">
                <h4 class="comment_title">コメント</h4>
                <div class="comment_scroll_area">
                @foreach ($comments as $comment)
                <div class="comment_content_area">
                    <p class="comment_content">{{ $comment->comment }}</p>
                    <div class="comment_date_user_area">
                        <p class="comment_user_name">{{ $comment->user->name }}</p>
                        <p class="comment_date">{{ \Carbon\Carbon::createFromTimeString($comment->updated_at)->format('Y/m/d') }}</p>
                    </div>
                </div>
                @endforeach
                </div>
                <div class="comment_form_area">
                    <form method="POST" action="{{ route('comment', ['id'=>$article->id]) }}">
                    @csrf
                        <input type="text" name="comment" class="comment"></textarea>
                        <button type="submit" class="comment_btn">コメント</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/like.js') }}"></script>
<script>
    function follow(userId) {
        $('.follow').css("display", "none");
        $('.un_follow').css("display", "block");
        $.ajax({
        // これがないと419エラーが出ます
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: `/follow/${userId}`,
        type: "POST",
        })
        .done((data) => {
            console.log(data);
        })
        .fail((data) => {
            console.log(data);
        });
    }
    function destroy(userId) {
        $('.follow').css("display", "block");
        $('.un_follow').css("display", "none");
        $.ajax({
        // これがないと419エラーが出ます
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        url: `/follow/${userId}/destroy`,
        type: "POST",
    })
        .done((data) => {
        console.log(data);
        })
        .fail((data) => {
        console.log(data);
        });
    }
</script>
@endsection
