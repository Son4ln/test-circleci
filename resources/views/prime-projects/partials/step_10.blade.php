<!-----------クルオアド仕事を依頼・10.参考になる、会社案内、商品資料あるいはURLを入力して下さい--------------->
<h2 id="request_job_10" class="cop-p-border-bottom-333 margin-bottom40">
@lang('prime_projects.create.standard')
</h2>
<div class="text-center">
<div id="standard" class="prime-upload width70 margin-center"></div>
<div class="margin-bottom40">
	{!! Form::text('standard_url', null, [
	'class' => 'form-control input-lg width70 margin-center',
	'id' => 'criterion_of_creative',
	'placeholder' => 'http://',
	]); !!}
</div>
</div>
<div class="inline-block cop-p-nextlink">
<div class="width100 text-center">
	<a href="#request_job_11" class="scrollarrow-blue80">
	<span class="nexttext">@lang('projects.next') </span>
	</a>
</div>
</div>
<input type="hidden" name="standard_files" id="standard_files">
