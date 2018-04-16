@extends('layouts.ample')
@section('content')

<!-- MOR modify 20171207 change alert-warning -> cop-alert-warning, remove close button -->
<!--
<div class="alert alert-warning alert-dismissable">
	<button class="close" data-dismiss="alert" aria-label="close">&times;</button>
-->
<div class="alert cop-alert-warning alert-dismissable">
	<span class="fa fa-exclamation-circle"></span>
	@lang('subscriptions.index.alert')
</div>
<div class="row">
	<div class="col-sm-12 col-lg-12 col-xs-12">
		<div class="panel panel-success">
			<!-- MOR modify 20171207 ③緑帯の色をクルオのロゴの緑色に合わせる（#229393） -->
			<!--div class="panel-heading"-->
			<div class="panel-heading cop-panel-heading">
				@lang('subscriptions.index.heading')
			</div>
			<div class="panel-body">
				<!-- MOR modify 20171207 ④緑帯ブロック内の文言の枠要らない -->
				<!-- pre class="cop-pre" @lang('subscriptions.index.content')</pre-->
				<pre class="cop-pre">@lang('subscriptions.index.content')</pre>

				{{--
				<div class="row">
				@foreach($plans as $plan)
					<div class="col-sm-6 col-lg-4 col-xs-12">
						<div class="small-box bg-aqua">
							<div class="inner">
								<!--<p>{{ $plan->id }}: {{ $plan->name }}</p> -->
								<h3 class="mor-h3-color">@lang('subscriptions.index.plans.22')</h3>
							</div>
							<div class="icon">
								<i class="fa fa-shopping-cart"></i>
							</div>
							@if($isSubscribed && $subscription && ($subscription->stripe_plan == $plan->id))
							<a href="javascript:void(0)" class="small-box-footer" style="padding: 10px 0">
								@lang('subscriptions.index.plans.current') <i class="fa fa-check-circle"></i>
							</a>
							@else
							<a href="{{ route('subscriptions.show', ['planId' => $plan->id]) }}" class="small-box-footer" style="padding: 10px 0">
							@lang('subscriptions.index.plans.link') <i class="fa fa-arrow-circle-right"></i>
							</a>
							@endif
						</div>
					</div>
				@endforeach
				</div>
				--}}
			</div>
		</div>
	</div>
</div>
@endsection
