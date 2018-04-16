<h2 class="margin-bottom40 bold step-title" id="request_job_12">
@lang('projects.create.sumary.title')
</h2>

<div class="row">
<div class="col-md-12">
<table id="preview_table" class="table table-hover dataTable margin-bottom30" style="word-break: break-all;">
<tr>
	<th class="white-space-nowrap text-center">@lang('projects.create.sumary.project_name')</th>
	<td class="relative preview_project_name td-highligh">
	<span data-input="title" class="padding-right10"></span>
	<a href="#request_job_8" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.duedate')</th>
	<td class="relative preview_delivery_date">
	<span class="padding-right10"></span>
	<a href="#request_job_9" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.expiration')</th>
	<td class="relative preview_expiration_date td-highligh">
	<span class="padding-right10"></span>
	<a href="#request_job_11" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.request')</th>
	<td class="relative preview_request_form">
	<span data-input="plan" class="padding-right10"></span>
	<a href="#request_job_0" class="absolute-right step12-icon"></a>
	</td>
</tr>
{{-- <tr>
	<th class="text-center">@lang('projects.create.sumary.video_purpose')</th>
	<td class="relative preview_purpose">
	<span class="padding-right10"></span>
	<a href="#request_job_6" class="absolute-right step12-icon"></a>
	</td>
</tr> --}}
<tr>
	<th class="text-center">@lang('projects.create.sumary.video_style')</th>
	<td class="relative preview_movie_style td-highligh">
	<span data-input="real_or_anime[]" class="padding-right10"></span>
	<a href="#request_job_1_1" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.video_type')</th>
	<td class="relative preview_movie_type">
	<span data-input="type_of_movie[]" class="padding-right10"></span>
	<a href="#request_job_1_2" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.budget')</th>
	<td class="relative preview_budget td-highligh">
	<span class="padding-right10"></span>
	<a href="#request_job_2" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.ask')</th>
	<td class="relative preview_request_what">
	<span data-input="aa[]" class="padding-right10" style="word-wrap:break-word;"></span>
	<a href="#request_job_3" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.arrange')</th>
	<td class="relative preview_arrange_anything td-highligh">
	<span data-input="ab[]" class="padding-right10" style="word-wrap:break-word;"></span>
	<span data-input="ab_other" class="padding-right10" style="word-wrap:break-word;"></span>
	<a href="#request_job_4" class="absolute-right step12-icon"></a>
	</td>
</tr>
<tr>
	<th class="text-center">@lang('projects.create.sumary.location')</th>
	<td class="relative preview_shooting_location">
	<span class="padding-right10" data-input="shooting_location">
		@lang('projects.create.sumary.location_default')
	</span>
	<a href="#request_job_5" class="absolute-right step12-icon"></a>
	</td>
</tr>
</table>
</div>
</div>
<div class="margin-bottom10 preview_purpose_detail_pencil">
	<p>@lang('projects.create.sumary.video_description')：</p>
	<a href="#request_job_6" class="step12-icon" id="preview_purpose_detail_pencil"></a>
</div>

<div class="row margin-none">
	<div class="col-md-12 margin-bottom30 border-all-ccc" style=" word-wrap: break-word;">
	<div class=" preview_purpose" style="padding: 15px">
		<span class="padding-right10"></span>
	</div>
	<div class=" preview_purpose_detail" style="padding: 0 15px 15px 15px">
		<span class="padding-right10" ></span>
	</div>
	</div>
</div>
<div class="text-center margin-bottom40">
<button class="btn step12-submit-btn" type="submit" id="submit_btn" disabled>@lang('projects.create.create_submit')</button>
</div>
