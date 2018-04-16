@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title u-title-color">@lang('portfolios.show.header')</h4>
</div>
@endsection

@section('content')

@php
$portfolio_user_photo_url = url('/images/user.png');
if (strpos($portfolio->user_photo, 'http') !== false) {
    $portfolio_user_photo_url = $portfolio->user_photo;
}else if (!empty($portfolio->user_photo)) {
    $portfolio_user_photo_url = Storage::disk('s3')->url(ltrim($portfolio->user_photo, "/"));
}

$portfolio_user_backgroundThumbnailUrl = url('/images/user.png');
@endphp

<link href="https://vjs.zencdn.net/6.2.7/video-js.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

<div class="col-lg-8 col-md-8 col-xs-12 padding-right40 relative">
	@if (strpos($portfolio->mime, 'video') !== false)
	<video id="my-video" class="video-js" controls preload="auto" controlsList="nodownload" width="600" height="450"
	poster="{{$portfolio->thumb_path}}" data-setup="{}">
		<source src="{{$portfolio->url}}" type='video/mp4'>
		<p class="vjs-no-js">
		@lang('portfolios.show.not_support')
		<a href="https://videojs.com/html5-video-support/" target="_blank">@lang('portfolios.show.not_support_2')</a>
		</p>
	</video>
	@else
	<img src="{{ $portfolio->url }}" alt="{{ $portfolio->title }}" class="img-responsive" width="100%">
	@endif

<script src="https://vjs.zencdn.net/6.2.7/video.js"></script>

	
</div><!--/col-lg-8 col-md-8 col-xs-12 padding-right40 relative-->


<div class="col-lg-4 col-md-4 col-xs-12 padding-left40">

	<center>
		<img src="{{$portfolio_user_backgroundThumbnailUrl}}" style="max-width:100%" />
	</center>
	<div class="p-detail">

		<img class="avatar1-back-150" src="{{$portfolio->user->photo_url}}" onerror="this.src='/images/user.png'">
		<h3 class="">{{$portfolio->user_nickname ? $portfolio->user_nickname : $portfolio->user_name}}</h3>
		<p class="">{{$portfolio->user_comment}}</p>
		<div class="" style="position: absolute;left: 142px;bottom: 60px;">
		<a href="{{ url('/creators/' . $portfolio->user->id) }}" style="color: grey;">@lang('portfolios.show.link')</a>

	</div>
	</div>
	
	<div class="c-table" style="border-top:1px solid #e9e9e9;    padding-top: 70px;">
	<table class="table c-table1">
		<tr class="bgececec">
			<td><strong>@lang('portfolios.show.title')</strong></td>
			<td>{{ $portfolio->title }}</td>
		</tr>
		<tr>
			<td><strong>@lang('portfolios.show.style')</strong></td>
			<td>
				@foreach ($styles as $key)
				@if ($loop->first)
					{{ config('const.project_movie_style.' . $key) }}
				@else
					&nbsp;,{{ config('const.project_movie_style.' . $key) }}
				@endif
				@endforeach
			</td>
		</tr>
		<tr class="bgececec">
			<td><strong>@lang('portfolios.show.type')</strong></td>
			<td>
				@foreach ($types as $key)
				@if ($loop->first)
					{{ config('const.project_movie_type.' . $key) }}
				@else
					&nbsp;,{{ config('const.project_movie_type.' . $key) }}
				@endif
				@endforeach
			</td>
		</tr>
		<tr>
		<td><strong>@lang('portfolios.show.budget')</strong></td>
		<td>{{ $portfolio->amount == 0 ? '非公開' : $portfolio->amount.'万円' }}</td>
		</tr>
	</table>

	@can ('update', $portfolio)
		<form action="/portfolio/{{ $portfolio->id }}/scope" method="post">
		{{ csrf_field() }}
		<p style="margin-top:30px;">
			<strong>
				@lang('portfolios.show.scope')
			</strong>
		</p>
		{{ Form::select('scope', ['0' => '公開', '1' => '会員限定'] ,
			$portfolio->scope,
			['class' => 'form-control s-c-update-status', 'style' => 'width:100%; margin-top:20px '])
		}}
		<button class="btn color-white color-white-hover" style="margin-top:20px;background:#60bfb3;border-radius: 0; padding: 10px 50px;">@lang('portfolios.show.change')</button>
		</form>
	@endcan
	</div>
	
</div><!--/col-lg-4 col-md-4 col-xs-12 padding-left40-->

@endsection
@push('styles')
<style media="screen">
#page-wrapper{
background:#fff !important;
}
</style>
@endpush