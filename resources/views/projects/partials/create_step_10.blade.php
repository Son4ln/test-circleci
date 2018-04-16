<h2 class="bold step-title" id="request_job_10">
@lang('projects.create.project_image')
</h2>
<div class="margin-bottom40" style="/* min-height:500px; */">
<div class="margin-bottom40 step-desc">
	@lang('projects.create.project_image_alert')
</div>
<!-- <div class="btn-file drop-file text-center center-block">
	<div class="drop-file-icon center-block"></div>
	Drop,select or import files
	{{ Form::file('image', ['accept' => 'image/*']) }}
</div> -->

{{ Form::file('image', ['accept' => 'image/*']) }}

<img src="{{ $project->image ? Storage::disk('s3')->url($project->image) : '' }}" alt="" id="project_image" width="400">
</div>

<div class="inline-block nextlink">
<div class="width100 text-center">
	<a href="#request_job_11" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next')</span>
	</a>
</div>
</div>
