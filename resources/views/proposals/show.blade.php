@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('proposals.show.title')</h4>
</div>
<!--
<a href="{{ route('users.show', ['id' => $creator->id]) }}" class="pull-right" style="margin-right: 15px">
	<button class="btn btn-primary">@lang('creators.show.profile_link')</button>
</a>
-->
@endsection

@section('content')
<!-----------ポートフォリオ詳細--------------->
<div class="col-lg-4 col-md-4 col-xs-12 profike-details">
	<div class="panel panel-default">
	    <div class="panel-heading padding-none">
	    	<img src="/images/creator-bg.jpg" width="100%">
	    </div>
	    <div class="panel-body padding-none proposal-info">
	    	<center>
	    		<table class="proposal-tb">
		    		<tr>
		    			<td><img src="{{ $creator->photoUrl }}" class="thumb-lg img-circle proposal-avatar" alt="img"></td>
		    			<td>
		    				<h4 class="bold">{{ $creator->name }}</h4>
							<h5>{{ $creator->email }}</h5>
		    			</td>
		    		</tr>
	    		</table>
	    	</center>
	    </div>
	  </div>
	{{-- <div class="user-btm-box">
	<div class="col-md-4 col-sm-4 text-center">
		<p class="text-purple"><i class="ti-facebook"></i></p>
		<h1 class="mor-h1-color">258</h1>
	</div>
	<div class="col-md-4 col-sm-4 text-center">
		<p class="text-blue"><i class="ti-twitter"></i></p>
		<h1 class="mor-h1-color" >125</h1>
	</div>
	<div class="col-md-4 col-sm-4 text-center">
		<p class="text-danger"><i class="ti-dribbble"></i></p>
		<h1 class="mor-h1-color">556</h1>
	</div>
	</div> --}}
</div>
<!--/col-lg-4 col-md-4 col-xs-12-->

<div class="col-lg-8 col-md-8 col-xs-12">
<div class="global-proposal">
<div class="row">
	<div class="col-md-6 proposal-tb-gb">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<td>@lang('proposals.show.amount')</td>
					<td><strong>{{ number_format($proposal->price) }}</strong> 円</td>
				</tr>

				<tr>
					<td>@lang('proposals.show.text')</td>
					<td><strong>{!! url2anker(nl2br($proposal->text)) !!}</strong></td>
				</tr>

				<tr>
					<td>@lang('proposals.show.attachments')</td>
					<td>
						@if (count($proposal->attachments))
							@foreach ($proposal->attachments as $file)
							<a href="{{ Storage::disk('s3')->url($file['url']) }}" download>
								{{ $file['name'] }}
							</a>,
							@endforeach
						@endif
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="col-md-6 proposal-global-map">
		<img src="/images/ban_do.png" width="100%">
	</div>
</div>
</div>
<div>
	<!-- <div class="well">
	<div class="row has-padding">
		<div class="col-md-3">@lang('proposals.show.amount')</div>
		<div class="col-md-8">{{ number_format($proposal->price) }} 円</div>
	</div>
	<div class="row has-padding">
		<div class="col-md-3 text-bold">@lang('proposals.show.text')</div>
		<div class="col-md-8">{!! url2anker(nl2br($proposal->text)) !!}</div>
	</div>
	<div class="row has-padding">
		<div class="col-md-3 text-bold">@lang('proposals.show.attachments')</div>
		<div class="col-md-8">
		@if (count($proposal->attachments))
			@foreach ($proposal->attachments as $file)
			<a href="{{ Storage::disk('s3')->url($file['url']) }}" download>
				{{ $file['name'] }}
			</a>,
			@endforeach
		@endif
		</div>
	</div>
	</div> -->
	<div class="nav-tabs-custom">
	<ul class="nav nav-tabs customtab">
		<li class="active"><a href="#basic-info" data-toggle="tab">@lang('creators.show.profile')</a></li>
		<li><a href="#portfolio" data-toggle="tab">@lang('creators.show.portfolio')</a></li>
	</ul>
	<div class="tab-content">

		<div class="tab-pane active" id="basic-info">
		<!--background-cdeef0 margin-top140 margin-bottom40 padding100151520-->
		<h4 class="bold">@lang('creators.show.base')</h4>
		<p>{{ config('const.base.' . $creator->base) }}</p>
		<h4 class="bold">@lang('creators.show.record')</h4>
		<p class="line-height17" style="word-break: break-all;">
			{!! url2anker(nl2br($creator->record))!!}
		</p>
		<h4 class="bold">@lang('creators.show.career')</h4>
		<p class="line-height17" style="word-break: break-all;">
			{!! url2anker(nl2br($creator->career))!!}
		</p>
		</div><!-- /.tab-pane -->

		<div class="tab-pane" id="portfolio">
		<div class="space-between">
			@if (isset($portfolios))
			@foreach ($portfolios as $portfolio)
				@include('portfolios.partials.item', ['portfolio' => $portfolio])
			@endforeach
			@endif
		</div>
		</div><!-- /.tab-pane -->
	</div>
	<!-- /.tab-content -->
	</div>
</div>

</div>

<!-----------編集終わり--------------->

<?php
	function url2anker($text){
		return mb_ereg_replace('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', '<a href="\1" target="_blank">\1</a>', $text);
	}
?>

<!-- @push('styles')
<style>
video.preview {
	max-width:90%;
	height:auto;
}
img.preview {
	max-width:90%;
	height:auto;
}
.ui-portfolio-detail {
	color:#bbbbbb;
	text-align:left;
	padding: 5px;
	padding-left:20px;padding-right:20px;display:none;
}
</style> 
{{ Html::style('css/style.css') }}
@endpush
<script src="/js/jquery.isotope.js" type="text/javascript"></script>
<script>
(function($){
	var container = $('.isopanel');
	container.isotope({
		filter: '*',
		animationOptions: {
			duration: 250,
			easing: 'linear',
			queue: false
		}
	});
	$('.ui-portfolio-prev').hover(
		function () {
			$(this).css('z-index',parseInt($(this).css('z-index'))+1);
			//$(this).css('max-width',480);
			$('.ui-portfolio-detail', this).show('fast', function(){
				container.isotope({
					filter: '*',
					animationOptions: {
						duration: 250,
						easing: 'linear',
						queue: false
					}
				});
			});
		},
		function () {
			$(this).css('z-index',parseInt($(this).css('z-index'))-1);
			//$(this).css('max-width',340);
			$('.ui-portfolio-detail', this).hide('fast', function(){
				container.isotope({
					filter: '*',
					animationOptions: {
						duration: 250,
						easing: 'linear',
						queue: false
					}
				});
			});
		}
	);
	/* modal dialog */
	$('button.ui-profile-edit[data-toggle="modal"]').click(function (){
		name = $(this).attr('data-procname');
		$('.modal-title', '#modalWindow').html($(this).html());
		$('div.modal-body', '#modalWindow').load('/'+name);
	});


	$('span.ui-send-message[data-toggle="modal"]').click(function (){
		$('.modal-title', '#modalWindow').html($(this).attr('data-title'));
		$('div.modal-body', '#modalWindow').load( $(this).attr('data-procname'));
	});

	/* modal dialog */
	$('img[data-toggle="modal"]').click(function (){
		if ($(this).attr('data-mime').match(/video/)) {
			var video = document.createElement("video");
			video.src = $(this).attr('data-procname');
			video.poster = $(this).attr('src');
			video.controls = true;
			video.autoplay = true;
			video.loop = true;
			$(video).addClass("preview");
			$('div.modal-body', '#modalPreviewWindow').html(video);
		} else {
			var img = document.createElement("img");
			img.src = $(this).attr('data-procname');
			$(img).addClass("preview");
			$('div.modal-body', '#modalPreviewWindow').html(img);
		}
		$('.modal-title', '#modalPreviewWindow').html($(this).siblings('.ui-portfolio-detail').children('.media-heading').html());
		$('.portfolio-detail', '#modalPreviewWindow').html($(this).siblings('.ui-portfolio-detail').children('.portfolio-detail').html());
	});

	$('#modalPreviewWindow').on('shown.bs.modal', function (e) {
		$('.modal-backdrop').css("opacity",1);
	})
	$('#modalPreviewWindow').on('hidden.bs.modal', function (e) {
		$('div.modal-body', '#modalPreviewWindow').html('');
		$('div.portfolio-detail', '#modalPreviewWindow').html('');
	})
})(jQuery);

</script>
@endsection
