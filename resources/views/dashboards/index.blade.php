@extends('layouts.ample')

@section('content-header')
<!-- .page title -->
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">{{ __('dashboards.title') }}</h4>
</div>
<!-- /.page title -->
@endsection

@section('content')
	<section class="content index">

	<!-- Small boxes (Stat box) -->
	<div class="row">
		<!-- MOR 20171208 -->
		<!-- クライアント, クリエイター: KV部分のcssを.col-md-8から.col-md-12に変更するのはどうでしょう？ -->
		<!-- div class="col-md-8"-->
		<div class="col-md-12">
			<!-- Info box -->
			<div class="white-box text-center ">
					<!-- MOR 20171208 -->
					<!-- ①KV画像のmarginを10px 0 35px に変更 -->
				<!-- img src="/crluo/public/images/t3.png" width="150" style="margin:10px 0 35px 0;"-->
				{{ Html::image('images/img-header.png?v=1', 'KV', array('style' => 'width:100%')) }}
				<br>
					<p class="bbb text-right title_index">@lang('dashboards.message')</p>
			</div>
			<!-- /.box -->
		</div>

		<div class="col-md-8">
			<div class="white-box main_title">
			<!-- projects -->
			@include('dashboards.partials.client')
			</div>

			<div class="white-box col-md-12  pull-left">
			<!-- making && proposals-->
			@include('dashboards.partials.creator')
			</div>
		</div>
		<!-- /.col -->
		<!-- MOR 20181211 Change col-md-4 to col-md-12 -->
		<div class="col-md-4 pull-left">





		<div class="white-box main_title">

			<small class="badge pull-right bg-green">@lang('dashboards.nof_badge')</small>
			<h2 class="oshirase-page-header"><img src="../images/index_tit_icon2.png" alt=""> @lang('dashboards.nof_title')</h2>
			<div class="box box-info">
			<div class="box-body">
					<!-- MOR 20181208 ①KV画像のmarginを10px 0 35px に変更。文字との間が狭すぎるので、画像の上下の間が同じ高さになるように。 -->
		@foreach ($notifications as $notification)
		<div class="oshirase-msg-box">
			
			<img src="{{ @@auth()->user()->photoThumbnailUrl }}" alt="User Image" class="avatar" onerror="this.src='/images/user.png'">
			<div class="info_mes">
				<h5 class="bbb">{{$notification->title}}</h5>
				<small class="mes_date">{{ !empty($notification->created_at) ? $notification->created_at->format('Y/m/d H:i') : '' }}</small>
				<p style="margin-top:5px">{!!nl2br($notification->message)!!}</p>
			</div>
			<div class="clearfix"></div>
		</div>
		@endforeach
			</div><!-- /.box-body -->
			</div><!-- /.box -->

			<h3 class="oshirase-page-header">@lang('dashboards.info_title')</h3>
			<div class="alert oshirase-alert-info alert-dismissable">
			<img src="../images/index_ques.png" alt=""> ご不明点は? クルオ 運営までお気軽にお問合せください。
			</br>
			<!-- MOR 20171208 info@crluo-mail.com => info@vi-vito.com -->
			<span class="bbb" style="font-size: 16px;"><img src="../images/index_mail.png" alt=""><a href='mailto:info@vi-vito.com'>info@vi-vito.com</a></span>
			</br>
			{{-- <span style="font-size:1.4em;"><strong> TEL.03-6383-4725</strong></span> --}}
			</div>
		</div>
		</div><!-- /.col -->
	</div>
	</div>
<!-- /.row -->
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
	/* send crluo */
	$('a.ui-modal-message').click(function (){
	$('.modal-title', '#modalWindow').html($(this).attr('data-title'));
	$('div.modal-body', '#modalWindow').load( $(this).attr('data-procname'));
	});
})

//$('.wrap').css({'display' : 'box', 'width':'150px', 'height':'250pxpx'});
</script>
@endpush
<style>
	
</style>
