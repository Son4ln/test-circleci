<!-----------クルオアド仕事を依頼・8.納品日を教えてください。--------------->
<h2 id="request_job_8" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.calendar')
</h2>
<div class="bind_delivery_date form-group margin-center text-center width400px margin-bottom30">
<div>
	<div class="input-group date margin-bottom10">
	<div class="input-group-addon">
		<i class="fa fa-calendar"></i>
	</div>
  @php
    if ($project->title) {
        $project->is_duedate_undecided = $project->duadate_at ? null : 1;
    }
  @endphp
	{!! Form::text('duedate_at', null, [
		'class' => 'form-control pull-right relative',
		'id' => 'delivery_date',
		'required' => false,
	]) !!}

	</div>
	<h4>
	<label class="light-blue60-back btn-lg" style="display: block;">
		{!! Form::checkbox('is_duedate_undecided', 1, null, ['class' => 'hidden']) !!}
		<span>@lang('prime_projects.create.undecided')</span>
	</label>
	</h4>
</div>
</div>
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_9" class="scrollarrow-blue80 padding-top-50">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
