@extends('layouts.ample')
@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('projects.creator_list.title')</h4>
</div>
@endsection
@section('content')
<div class="white-box">
    <p>C-Operationは現在開発中です。今しばらくお待ちください。</p>
    <p>C-Operationに関するお問い合わせは以下のボタンを押してください。</p>
    <p>ボタンを押すと、登録されたメールアドレスへ後ほどご連絡いたします。</p>
    <center>
        <a href="{{url('senemailcoperation')}}" class="btn btn-primary width600px fontsize20 border-none" style="background: rgb(34, 147, 147);">お問い合わせする</a>
    </center>
</div>
@endsection