<h2 class="bold margin-bottom40 step-title" id="request_job_9">
@lang('projects.create.duedate')
</h2>
<div class="step9-content margin-bottom40">
<div class="row bind_delivery_date">
	<div class="step9-form col-md-12">
	<div class="input-group date margin-bottom10">
		<div class="input-group-addon text-white">
		<i class="fa fa-calendar"></i>
		</div>
		@if ($project->duedate_at)
		{{ Form::text('duedate_at', date('Y/m/d', strtotime($project->duedate_at)), [
			'class' => 'form-control pull-right',
			'id'    => 'delivery_date'
		]) }}
		@else
		<input name="duedate_at" id="delivery_date" class="form-control pull-right" type="text" value="">
		@endif

	</div>
	@php
		if ($project->title) {
		    $project->is_duedate_undecided = $project->duadate_at ? null : 1;
		}
	@endphp
	<h4>
		<label class="label-btn btn-lg text-white">
		{{ Form::checkbox('is_duedate_undecided', 1, null, [
			'style' => 'display:none'
		]) }} @lang('projects.create.undecided')</span>
		</label>
	</h4>
	</div>
</div>
</div>

<div class="inline-block nextlink">
	<div class="width100 text-center bold">
	<a href="#request_job_10" class="scrollarrow-blue80">
		<span class="nexttext">@lang('projects.next')</span>
	</a>
	</div>
</div>
