<h2 class="bold margin-bottom40 step-title" id="request_job_6">
@lang('projects.create.video.title')
</h2>
<div class="step6-content margin-bottom40">
<h3 class="mor-create-step-title text-white text-center bold margin-bottom40">
	@lang('projects.create.video.heading')
</h3>
<div class="row">
	<div class="col-md-12 margin-bottom10">
		{{ Form::textarea('point', null, [
		'id'          => 'purpose',
		'placeholder' => __('projects.create.video.placeholder_1'),
		'rows'        => 3,
		'class'       => 'form-control'
		]) }}

	</div>
</div>

<div class="row">
	<div class="col-md-12">
		{{ Form::textarea('describe', null,
		[
		'placeholder' => __('projects.create.video.placeholder_2'),
		'id'          => 'purpose_detail',
		'class'       => 'form-control',
		'rows'        => 16
		]) }}

		</div>
	</div>
</div>

<div class="inline-block nextlink">
<div class="width100 text-center">
	<a href="#request_job_7" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next')</span>
	</a>
</div>
</div>