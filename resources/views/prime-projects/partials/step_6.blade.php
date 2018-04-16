<!-----------クルオアド仕事を依頼・6.動画のアスペクト比はどれですか？--------------->
<h2 id="request_job_6" class="cop-p-border-bottom-333 margin-bottom30">
@lang('prime_projects.create.aspect')
</h2>
<div class="bind_aspect_ratio margin-left5">
<ul class="columns4 flexbox text-center margin-bottom10">
	@foreach(config('const.project_aspect', []) as $value => $label)
	<li class="flexbox1">
	<label class="light-blue60-back btn-lg" style="display: block;">
		{!! Form::radio('aspect', $value, null, ['class' => 'hidden']) !!}
		<span>{{$label}}</span>
	</label>
	</li>
	@endforeach
</ul>
<label>@lang('prime_projects.create.aspect_another')</label>
<div class="margin-bottom40">
	{!! Form::text('aspect_text', null, [
	'class' => 'form-control input-lg width80',
	'id' => 'aspect_ratio_another',
	]) !!}
</div>
{{-- <div class="columns48 width60 flexbox margin-bottom10 space-between">
	<!--1-->
	<div class="flexbox1 background-fff relative margin-bottom20">
	<a class="moviesearch3-back relative">
		<i class="fa fa-fw fa-play white fontsize18 absolute-left3325 z-index8"></i>
		<i class="fa fa-fw fa-youtube-play light-blue60 fontsize54 absolute-left8"></i>
	</a>
	</div>
	<!--2-->
	<div class="flexbox1 background-fff relative margin-bottom20">
	<a class="moviesearch3-back relative">
		<i class="fa fa-fw fa-play white fontsize18 absolute-left3325 z-index8"></i>
		<i class="fa fa-fw fa-youtube-play light-blue60 fontsize54 absolute-left8"></i>
	</a>
	</div>
</div> --}}
</div>
<!--margin-left5-->
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_7" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
