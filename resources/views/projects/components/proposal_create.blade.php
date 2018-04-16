<div class="panel panel-info">
<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-weight: 13px;font-weight: bold">
	@lang('projects.show.proposal_title')
</div>
<div class="panel-body">
	<form action="{{ url('proposals') }}" method="post" id="create-proposal" enctype="multipart/form-data" style="padding-top: 30px;">
	{{ csrf_field() }}
	<input type="hidden" name="project_id" value="{{ $project->id }}">
	<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
	@if (!$project->isPrime())
		<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
		<label class="control-label col-md-4 l-font-size-18" style="max-width:183px;padding-top: 10px;">@lang('projects.show.proposal_budget')</label>
		<div class="input-group col-sm-4">
			<div class="input-group-addon l-input-group-addon">
					¥
			</div>
			{{ Form::number('price', null, ['class' => 'form-control', 'pattern' => '[0-9]{0,20}', 'data-filter' => 'hankaku']) }}
			
		</div>
			@if ($errors->has('price'))
				<span style="color: red; padding-left:160px" >{{ $errors->first('price') }}</span>
			@endif
		</div>
		<div><pre class="border-none color-454545">@lang('projects.show.budget_description')</pre></div>
	@else
		<div class="form-group">
		<label class="propo_title">@lang('projects.show.proposal_budget'): <span>{{ $project->operationFees/10000 }}</span> 万円</label>
		</div>
	@endif

	<div class="form-group {{ $errors->has('text') ? 'has-error' : '' }}">
		<label style="font-size: 18px;">@lang('projects.show.sumary')</label>
		{{ Form::textarea('text', null, ['class' => 'form-control']) }}
		@if ($errors->has('text'))
		<span style="color: red">{{ $errors->first('text') }}</span>
		@endif
	</div>

	<div class="form-group">
		<label class="l-font-size-18">@lang('projects.show.proposal_attachments')</label>
		<input type="file" name="attachments[]" multiple class="form-control">
	</div>

	<div class="form-group">
		<button class="btn l-btn-new btn-block" id="l-upload-fix">@lang('projects.show.proposal_submit')</button>
	</div>
	</form>
</div>
</div>
