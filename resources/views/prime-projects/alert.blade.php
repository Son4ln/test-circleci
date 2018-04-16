@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('ui.alert')</h4>
</div>
@endsection

@section('content')
<section>
	<div class="white-box">
	<div class="box-body">

		{!! Form::open(['route' => 'alerts.store', 'method' => 'POST', 'class' => 'form row']) !!}
		<div class="col-md-3">
		{!! Form::label('ad_account_id', trans('ui.choose_ad_account'), array('class' => 'control-label')); !!}
		{!! Form::select('ad_account_id', array_pluck($adAccounts, 'name', 'id'), null, ['placeholder' => trans('ui.choose_ad_account'), 'class' => 'form-control', 'autofocus' => true]) !!}
		</div>

		<div class="col-md-3">
		{!! Form::label('campaign_id', trans('ui.choose_campaigns'), array('class' => 'control-label')); !!}
		{!! Form::select('campaign_id', array_pluck($campaigns, 'name', 'id'), null, ['placeholder' => trans('ui.choose_campaigns'), 'class' => 'form-control']) !!}
		</div>

		<div class="col-md-4">
		{!! Form::label('condition_type', trans('ui.choose_conditions'), array('class' => 'control-label')); !!}
		{!! Form::select('condition_type', \App\TrackingJob::getConditionTypes(), null, ['placeholder' => trans('ui.choose_conditions'), 'class' => 'form-control']) !!}
		</div>

		<div class="col-md-2">
		<div>
			{!! Form::label('condition_value', trans('ui.value'), array('class' => 'control-label')); !!}
			{!! Form::number('condition_value', null, ['class' => 'form-control']) !!}
		</div>
		<div>
			<div class="control-label" style="height:2em">&nbsp;</div>
			<button class="btn btn-l-pp-save btn-block color-white color-hover-white" type="submit">@lang('ui.save')</button>
		</div>
		</div>
		{!! Form::close() !!}

		<div>
		<table class="table mt-3">
			<thead class="thead-default">
			<tr class="row">
			<th class="col-2">@lang('ui.ad_account')</th>
			<th class="col-3">@lang('ui.campaign')</th>
			<th class="col-5">@lang('ui.condition')</th>
			<th class="col-2"></th>
			</tr>
			</thead>
			<tbody>
			@foreach($jobs as $job)
			<tr class="row">
				<td class="col-2">{{ $job->ad_account_id }}</td>
				<td class="col-3">{{ $job->campaign_id }}</td>
				<td class="col-5">{{ $job->condition_text }}</td>
				<td class="col-2">
				{!! Form::open(['url' => route('alerts.delete', ['id' => $job->id]), 'method' => 'DELETE', 'class' => 'form-inline']) !!}
				<button type="submit" class="btn btn-mini btn-danger-l-danger-bold color-white color-hover-white">@lang('ui.remove')<i class="fa fa-trash-o"></i></button>
				{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
			</tbody>
		</table>
		</div>

	</div>
	</div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/analyze.js') }}"></script>
@endpush
