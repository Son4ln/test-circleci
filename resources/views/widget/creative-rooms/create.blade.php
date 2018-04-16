<h3 class="mor-h3-color">作成するProjectの名前を入力してください:</h3>
{{ Form::open(['url' => 'creative-rooms/ajax-store', 'method' => 'post']) }}
	<input type="hidden" name="owner_id" value="{{ $input['owner_id'] }}">
	<input type="hidden" name="user_id" value="{{ $input['user_id'] }}">
	<input type="hidden" name="proposal_id" value="{{ $input['proposal_id'] }}">
	<input type="hidden" name="project_id" value="{{ $input['project_id'] }}">
	<div class="form-group row">
	<div class="form-group">
		<label class="control-label col-md-2">名前</label>
		<div class="col-md-10">
		{{ Form::text('title', null, ['class' => 'form-control']) }}
		@if($errors->has('title'))
			<span class="error">{{ $errors->first('title') }}</span>
		@endif
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-2">概要</label>
		<div class="col-md-10">
		{{ Form::textarea('desc', null, ['class' => 'form-control']) }}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2"></label>
		<div class="col-md-10">
		<button class="btn btn-info">作成する</button>
		</div>
	</div>
	</div>
{{ Form::close() }}
