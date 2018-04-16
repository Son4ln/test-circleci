@extends('emails.layout-html')

@section('content')
{{--<a href="{{ url('creative-rooms', ['id' => $room->id]) }}">システム開発　交流場所</a>　にメッセージが届きました。<br>--}}
<a href="{{ url('creative-rooms', ['id' => $room->id]) }}"> {{$room->title}} </a>　にメッセージが届きました。<br>
{{$sendMsgInfo->created_at->format('H:i')}} by {{$sendUserInfo->name}} <br>
{{$sendMsgInfo->message}}<br>
<br>
返信は<a href="{{ url('creative-rooms', ['id' => $room->id]) }}">こちら</a>から<br>

@endsection
