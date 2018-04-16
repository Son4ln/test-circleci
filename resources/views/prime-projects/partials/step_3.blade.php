<!-----------クルオアド仕事を依頼・3.あなたの動画について教えてください（こちらの情報を元に提案が集まります。）--------------->
<h2 id="request_job_3" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.target.title')
</h2>
<div class="margin-left5 margin-bottom30">
<h3 class="purposetext mor-h3-color">@lang('prime_projects.create.target.text')</h3>
<div class="margin-bottom10 relative">
	{!! Form::textarea('target_product', null, [
	'class' => 'form-control width80',
	'id' => 'tell_about_movie_1',
	'rows' => 2,
	'placeholder' => __('prime_projects.create.target.target_placeholder'),
	]) !!}
	<!--span class="required">必須</span-->
</div>
<h3>@lang('prime_projects.create.target.point')</h3>
<div class="margin-bottom10 relative">
	{!! Form::textarea('point', null, [
	'class' => 'form-control width80',
	'id' => 'tell_about_movie_2',
	'rows' => 2,
	'placeholder' => __('prime_projects.create.target.point_placeholer'),
	]) !!}
	<!--span class="required">必須</span-->
</div>
<h3>@lang('prime_projects.create.target.keyword')</h3>
<div class="margin-bottom10 relative flexbox">
	{!! Form::text('keyword1', null, [
	'class' => 'form-control input-lg width20 margin-right10',
	'id' => 'tell_about_movie_31',
  'data-change' => 'keyword',
	]) !!}
	{!! Form::text('keyword2', null, [
	'class' => 'form-control input-lg width20 margin-right10',
	'id' => 'tell_about_movie_32',
	'data-change' => 'keyword',
	]) !!}
	{!! Form::text('keyword3', null, [
	'class' => 'form-control input-lg width20 margin-right10 margin-bottom10',
	'id' => 'tell_about_movie_33',
	'data-change' => 'keyword',
	]) !!}
	<!--span class="required">必須</span-->
</div>
<div class="margin-bottom30">
	{{ Form::textarea('describe', null,
	[
	'placeholder' => __('prime_projects.create.target.describe'),
	'id'          => 'tell_about_movie_detail',
	'class'       => 'form-control',
	'rows'        => 14
	]) }}
</div>
</div>
<!--/.margin-left5-->
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_4" class="scrollarrow-blue80 padding-top-50">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
