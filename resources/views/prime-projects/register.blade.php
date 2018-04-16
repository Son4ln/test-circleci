@extends('layouts.ample')

@section('content')
<div class="alert alert-warning alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<p><i class="icon fa fa-warning"></i> @lang('prime_projects.register.title')</p>
</div>
<div class="row">
	<div class="col-sm-6 col-lg-4 col-xs-12">
	<div class="small-box bg-aqua">
		<div class="inner">
		<h3 class="mor-h3-color">@lang('prime_projects.register.price') <small>万円/月</small></h3>
		<ul>
			<li>@lang('prime_projects.register.alert_1')</li>
			<li>@lang('prime_projects.register.alert_2')</li>
			<li>@lang('prime_projects.register.alert_3')</li>
		</ul>
		</div>
		<div class="icon">
		<i class="fa fa-shopping-cart"></i>
		</div>
		<a href="{{ route('subscriptions.pay', ['subscription' => 'prime']) }}" class="small-box-footer" style="padding: 10px 0">
		@lang('prime_projects.register.start') <i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
	</div>
</div>
@endsection
