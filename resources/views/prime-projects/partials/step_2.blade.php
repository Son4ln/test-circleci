<!-----------クルオアド仕事を依頼・2.動画の目的は何ですか？--------------->
<h2 id="request_job_2" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.purpose')
</h2>
<div class="bind_purpose margin-left5">
<ul class="columns4 flexbox text-center margin-bottom30">
	@foreach(config('const.project_purpose', []) as $value => [$label, $color])
	<li class="flexbox1">
	<label class="{{ $color }} btn-lg" style="display: block;">
		{!! Form::radio('purpose', $value, null, ['class' => 'hidden']) !!}
		<span>{{ $label }}</span>
	</label>
	</li>
	@endforeach
</ul>
</div>
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_3" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
