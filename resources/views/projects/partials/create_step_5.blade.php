<h2 class="bold margin-bottom40 step-title" id="request_job_5">
@lang('projects.create.location_title')
</h2>
<div class="step5-content margin-bottom40" style="/* min-height:500px; */">
<div class="row">
	<div class="col-md-12">
		{{ Form::textarea('place_pref', null, [
		'id'          => 'shooting_location',
		'class'       => 'form-control',
		'rows'        => 3,
		'placeholder' => __('projects.create.location_placeholder')
		]) }}
	</div>
</div>
</div>
<div class="inline-block nextlink margin-bottom40">
	<div class="width100 text-center">
	<a href="#request_job_6" class="scrollarrow-blue80">
		<span class="nexttext">@lang('projects.next')</span>
	</a>
	</div>
</div>
