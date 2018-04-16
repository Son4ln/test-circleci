@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('ui.report')</h4>
</div>
@endsection

@section('content')
<section>
	<div class="white-box">
	<div class="box-body">

		{!! Form::open(['route' => 'analyze.index', 'method' => 'GET', 'class' => 'form form-horizontal']) !!}
		<div class="form-group row">
		<label class="col-sm-4 col-md-3 control-label">@lang('ui.choose_ad_account')</label>
		<div class="col-sm-6 col-md-7">
			{!! Form::select('ad_account_id', array_pluck($adAccounts, 'name', 'id'), null, ['placeholder' => trans('ui.choose_ad_account'), 'class' => 'form-control', 'autofocus' => true]) !!}
		</div>
		</div>

		<div class="form-group row">
		<label class="col-sm-4 col-md-3 control-label">@lang('ui.choose_campaigns')</label>
		<div class="col-sm-6 col-md-7 mb-3">
			{!! Form::select('campaign_id', array_pluck($campaigns, 'name', 'id'), null, ['placeholder' => trans('ui.choose_campaigns'), 'class' => 'form-control']) !!}
		</div>
		<div class="col-sm-2 col-md-2">
			<button type="button" class="btn btn-primary btn-block background-229393" id="add-campaigns"
					disabled>@lang('ui.btn_add')</button>
		</div>
		</div>
		{!! Form::close() !!}

	</div>

	<table class="table table-bordered">
		<thead>
		<tr>
		<th style="width: 15px">#</th>
		<th>@lang('prime_projects.facebook_report.campaign')</th>
		<th style="width: 40px"></th>
		</tr>
		</thead>
		<tbody id="list-campaigns"></tbody>
	</table>

	<div class="box-body">
		<canvas id="chart"></canvas>

		<div class="box-footer">
		<ul class="nav nav-pills" id="chart-type">
			<li class="nav-item">
			<a class="nav-link active color-white" data-type="impressions" href="#">@lang('ui.impressions')</a>
			</li>
			<li class="nav-item">
			<a class="nav-link  color-white" data-type="clicks" href="#">@lang('ui.clicks')</a>
			</li>
			<li class="nav-item">
			<a class="nav-link  color-white" data-type="" href="#">@lang('prime_projects.facebook_report.disabled')</a>
			</li>
		</ul>
		</div>

	</div>
	</div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('adminlte/plugins/chart.js/dist/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('js/analyze.js') }}"></script>
@endpush

@push('styles')
<style>
	.nav.nav-pills > li > .nav-link.active {
	background-color: #05348b !important;
	color: #ffffff;
	}

	.nav.nav-pills > li > .nav-link:hover {
	background-color: #6664e4 !important;
	color: #ffffff;
	}
</style>
@endpush
