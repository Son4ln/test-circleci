<!-----------クルオアド仕事を依頼・1.発注主の業種は何ですか？--------------->
<h2 id="request_job_1" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.title1')
</h2>
<div class="form-group margin-left5">
<div class="width70 margin-bottom40">
	<div class="flexbox margin-top20">
	<label class="margin-top12">@lang('prime_projects.create.business_type.gyoushu')</label>
		{!! Form::select('business_type', config('const.business_type', []), null, [
		'class' => 'form-control input-lg width80',
		'id' => 'industry_of_owner',
		'placeholder' => __('prime_projects.create.business_type.placeholder'),
		'data-change' => 'business',
		]) !!}
	</div>
	<div class="flexbox margin-top20">
	<label class="margin-top12">@lang('prime_projects.create.business_type.name')</label>
	{!! Form::text('business_name', null, [
		'class' => 'form-control input-lg width80',
		'id' => 'corporate_name_of_owner',
		'placeholder' => '',
    'data-change' => 'business'
	]) !!}
	</div>
	<div class="flexbox margin-top20">
	<label class="margin-top12">@lang('prime_projects.create.business_type.url')</label>
	{!! Form::text('business_url', $project->business_url ? null : 'http://', [
		'class' => 'form-control input-lg width80',
		'id' => 'url_of_owner',
		'placeholder' => 'http://',
		'data-change' => 'business',
	]) !!}
	</div>
</div>
</div>
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_2" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
