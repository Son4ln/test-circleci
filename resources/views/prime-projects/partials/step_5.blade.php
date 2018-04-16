<!-----------クルオアド仕事を依頼・5.イメージに近い動画は？--------------->
<h2 id="request_job_5" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.similar')
</h2>
<div class="bind_close_to_image columns32 flexbox margin-bottom10 space-between">
@for($i = 1; $i <= 6; $i++)
<div class="flexbox1 background-fff relative margin-bottom20">
	<label class="moviesearch3-back relative">
	{!! Form::radio('similar_video', $i, null, ['class' => 'hidden']) !!}
	<span ><span class="hidden">movie{{ $i }}</span>  <img src="https://s3-ap-northeast-1.amazonaws.com/crluo/assets/images/movie{{ $i }}.gif" width="100%" height="100%">
</span>
	</label>
</div>
@endfor
</div>
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_6" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
