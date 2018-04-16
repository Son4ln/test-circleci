<h2 class="bold margin-bottom40 step-title" id="request_job_8" >
@lang('projects.create.project_title')
</h2>
<div class="step8-content margin-bottom40">
<div class="row">
	<div class="col-md-12">
		{{ Form::text('title', null, [
		'id' => 'project_name',
		'class' => 'form-control input-lg',
		]) }}
	</div>
</div>
</div>
<div class="inline-block nextlink">
	<div class="width100 text-center">
	<a href="#request_job_9" class="scrollarrow-blue80">
		<span class="nexttext">@lang('projects.next')</span>
	</a>
	</div>
</div>
