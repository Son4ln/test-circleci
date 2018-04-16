@if ($project->estimate)
<div class="panel panel-default">
  <div class="panel-heading" >
  @lang('projects.show.estimate') {{ number_format(@@$project->estimate) }} 円
  </div>
</div>
@endif

@if (empty($offeredProposal->price2))
<div class="panel panel-default" >
  <div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-size: 13px;">

  @lang('projects.show.request_title')
  </div>
  <div class="panel-body">
  {{ Form::open(['url' => route('proposals.acceptance'), 'method' => 'PUT']) }}
    <div class="form-group ">
    <label for="creator_amount">@lang('projects.show.creator_amount')</label>
    </div>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <div class="form-group {{ $errors->has('price2') ? 'has-error' : '' }}">
    {{ Form::text('price2', null, [
      'class' => 'form-control',
      'id' => 'creator_amount',
      'data-filter' => 'hankaku'
    ]) }}
    @if ($errors->has('price2'))
      <span class="text-danger">{{ $errors->first('price2') }}</span>
    @endif
    </div>
    <div class="form-group">
    <button class="btn btn-default" style="color:#ffffff;background:#60bfb3;border-color:#60bfb3;border-radius:0">@lang('projects.show.request_submit')</button>
    </div>
  {{ Form::close() }}
  </div>
</div>
@else
<div class="panel panel-default">
  <div class="panel-heading">
  @lang('projects.show.request_title')
  </div>
  <div class="panel-body">
  {{ Form::open(['url' => route('proposals.acceptance'), 'method' => 'PUT']) }}
    <div class="form-group text-center">
    <label for="creator_amount">
      @lang('projects.show.creator_amount_text', ['amount' => number_format($offeredProposal->price2)])
    </label>
    </div>
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <div class="form-group {{ $errors->has('price2') ? 'has-error' : '' }}">
    {{ Form::text('price2', null, [
      'class' => 'form-control',
      'id' => 'creator_amount',
      'data-filter' => 'hankaku'
    ]) }}
    @if ($errors->has('price2'))
      <span class="text-danger">{{ $errors->first('price2') }}</span>
    @endif
    </div>
    <div class="form-group">
    <button class="btn btn-default" style="width: 100%">@lang('projects.show.request_submit_2')</button>
    </div>
  {{ Form::close() }}
  </div>
</div>
@endif
