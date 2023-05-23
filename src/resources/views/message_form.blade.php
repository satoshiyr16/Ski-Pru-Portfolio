@extends('layouts.copy')

@section('content')
<head>
    <link href="{{ asset('assets/css/message_form.css') }}" rel="stylesheet">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="message_area">
            <div class="message_content_area">
                @if(isset($messages))
                    @foreach($messages as $message)
                    <div class="message_content">
                        <p class="text">{{ $message->text }}</p>
                        @if($message->path)
                        <img class="message_img" src="{{ asset($message->path) }}" alt="画像">
                        @endif
                        <div class="sub_text">
                            <p class="name">{{ $message->user->name }}</p>
                            <p class="date">{{ \Carbon\Carbon::createFromTimeString($message->updated_at)->format('Y/m/d H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                @endif
            </div>
            <div class="chat_area">
                <form action="{{ route('message_data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="chat_position">
                    <input class="chat" type="text" name="text" placeholder="メッセージを入力">
                    <input class="chat" type="file" name="image">
                    <button type="submit" class="">送信</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    // function room_create(user) {
    //     $.ajax({
    //     headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    //     url: `/room_create/${user}`,
    //     type: "POST",
    //     })
    //     .done((data) => {
    //         console.log(data);
    //     })
    //     .fail((data) => {
    //         console.log(data);
    //     });
    // }
</script>
@endsection
