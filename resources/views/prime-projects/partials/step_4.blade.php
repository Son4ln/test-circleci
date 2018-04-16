<!-----------クルオアド仕事を依頼・4.動画の尺想定--------------->
<h2 id="request_job_4" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.moviesec')
</h2>
<div class="margin-center text-center width30 margin-bottom40">
{!! Form::text('moviesec_min', null, [
	'class' => 'width30 margin-bottom40',
	'id' => 'lower_limit',
	'onChange' => 'slider(this);',
]) !!}@lang('prime_projects.create.sec_unit')
～
{!! Form::text('moviesec_max', null, [
	'class' => 'width30 margin-bottom40',
	'id' => 'upper_limit',
	'onChange' => 'slider(this);',
]) !!}@lang('prime_projects.create.sec_unit')
<div id="slider-range"></div>
<div>
	<div style="float:left;">1 @lang('prime_projects.create.sec_unit')</div>
	<div style="float:right; width:50%; text-align:right;">60 @lang('prime_projects.create.sec_unit')</div>
	<div style="clear:both;"></div>
</div>
</div>
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_5" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
