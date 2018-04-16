@extends('layouts.ample')
<?php
$fbUser['accounts'] = [
	['name' => 'aaaa','fan_count' => '123'],
	['name' => 'aaaa','fan_count' => '123'],
	['name' => 'aaaa','fan_count' => '123'],
	['name' => 'aaaa','fan_count' => '123324234'],
];
?>
@section('content')
<section class="white-box">
	@isset($fbUser)
	<div class="col-md-4 col-xs-6 col-lg-3">
		<div class="small-box color-white border-000015">
		<div class="inner">
			<h3 class="mor-h3-color">&nbsp;</h3>
			<p class="color-black">@lang('prime_projects.facebook_cert.warning')</p>
		</div>
		<div class="icon">
			<i class="fa fa-facebook"></i>
		</div>
		<a href="{{ url('/connecting/facebook') }}" class="background-229393 small-box-footer">
			@lang('prime_projects.facebook_cert.connect') <i class="fa fa-arrow-circle-right"></i>
		</a>
		</div>
	</div>
	@else
	<div class="col-sm-6 col-lg-4">
		<!-- Widget: user widget style 1 -->
		<div class="white-box widget-user-2 border-000015">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="box-header widget-user-header ">
			<div class="widget-user-image pull-right">
			<img class="img-circle" src="{{ $fbUser['picture']['url'] or '' }}" alt="User Avatar" width="70px">
			</div>
			<!-- /.widget-user-image -->
			<a class="btn-link pull-left" href="{{ $fbUser['link'] or '#' }}">
			<h3 class="widget-user-username">{{ $fbUser['name'] }}</h3>
			<h5 class="widget-user-desc">@lang('prime_projects.facebook_cert.id') <span>{{ $fbUser['id'] }}</span></h5>
			</a>
		</div>
		<div class="box-footer no-padding">
			<ul class="nav nav-stacked">
			@foreach($fbUser['accounts'] as $page)
				<li>
				<a href="{{ $page['link'] or '#' }}">
					{{ $page['name'] or '' }}
					<span class="pull-right badge background-229393">{{ $page['fan_count'] or '-' }}</span>
				</a>
				</li>
			@endforeach
			</ul>
		</div>
		</div>
		<!-- /.widget-user -->
	</div>
	@endempty
	<div class="clearfix"></div>
</section>

@endsection

@push('styles')
<style>
.widget-user-username{
	margin-top: 0;
	line-height: 19px;
}
.widget-user-header a.btn-link {
	color: #fff;
}
.widget-user-header a.btn-link:hover {
	text-decoration: none;
}
.alert-error{
	background-color: #f53939;
	border-color: #f53939;
}
div.alert-error button{
	display: none;
}
</style>
@endpush
