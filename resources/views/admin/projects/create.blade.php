@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.projects.create_title')</h4>
  </div>
@endsection

@section('content')
<div class="white-box">
  {{ Form::open([
    'url' => route('admin.projects.store'),
    'class' => 'form-horizontal',
    'id' => 'project',
    'files' => true
  ]) }}
  <input type="hidden" name="is_prime" value="0">
  <div class="form-group">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
      {!! Form::select('is_certcreator', [
        0 => 'セルフコンペ',
        1 => '認定クリエイター※募集'
      ], null, [
        'class' => 'form-control',
      ]); !!}
    </div>
  </div>

  <div class="form-group {{ $errors->has('real_or_anime') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.video_style') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      @foreach (config('const.project_movie_style') as $key => $style)
        {{ Form::checkbox('real_or_anime[]', $key, null, [
          'class' => 'input-checkbox',
          'id' => 'style-' . $key,
          'data-parsley-multiple' => 'style',
          'data-parsley-errors-container' => '#style-error',
          'required' => '',
          'data-parsley-error-message' => __('admin.projects.fields.video_style_errror')
        ]) }}
        <label for="{{ 'style-' . $key }}" class="label-checkbox">{{ $style }}</label>
      @endforeach
      <div id="style-error"></div>
      @if ($errors->has('real_or_anime'))
        <div class="help-block">{{ $errors->first('real_or_anime') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('type_of_movie') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.video_type') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      @foreach (config('const.project_movie_type') as $key => $style)
        {{ Form::checkbox('type_of_movie[]', $key, null, [
          'class' => 'input-checkbox',
          'id' => 'type-' . $key,
          'data-parsley-multiple' => 'type',
          'data-parsley-errors-container' => '#type-error',
          'required' => '',
          'data-parsley-error-message' => __('admin.projects.fields.video_type_error')
        ]) }}
        <label for="{{ 'type-' . $key }}" class="label-checkbox">{{ $style }}</label>
      @endforeach
      <div id="type-error"></div>
      @if ($errors->has('type_of_movie'))
        <div class="help-block">{{ $errors->first('type_of_movie') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.budget') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6 {{ $errors->has('price_min') ? 'has-error' : '' }}">
          {{ Form::text('price_min', null, [
            'class' => 'form-control',
            'placeholder' => __('admin.projects.fields.lower'),
            'data-filter' => 'hankaku',
            'id' => 'price_min',
            'required' => '',
            'min' => 5,
            'max' => 9999
          ]) }}
          @if ($errors->has('price_min'))
            <div class="help-block">{{ $errors->first('price_min') }}</div>
          @endif
        </div>
        <div class="col-md-6 {{ $errors->has('price_min') ? 'has-error' : '' }}">
          {{ Form::text('price_max', null, [
            'class' => 'form-control',
            'placeholder' => __('admin.projects.fields.upper'),
            'data-filter' => 'hankaku',
            'required' => '',
            'min' => 5,
            'max' => 9999,
            'data-parsley-ge' => '#price_min'
          ]) }}
          @if ($errors->has('price_max'))
            <div class="help-block">{{ $errors->first('price_max') }}</div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.work') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6 {{ $errors->has('part_of_work') ? 'has-error' : '' }}">
      @foreach (config('const.project_requests') as $key => $value)
        {{ Form::checkbox('part_of_work[]', $key, null, [
          'class' => 'input-checkbox',
          'id' => 'part-of-work-' . $key,
          'data-parsley-multiple' => 'part_of_work',
          'data-parsley-errors-container' => '#part_of_work',
          'required' => '',
          'data-parsley-error-message' => __('admin.projects.fields.work_error')
        ]) }}
        <label for="part-of-work-{{ $key }}" class="label-checkbox">{{ str_replace('<br>', '', $value) }}</label>
      @endforeach
      <div id="part_of_work"></div>
      @if ($errors->has('part_of_work'))
        <div class="help-block">{{ $errors->first('part_of_work') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('client_arrange') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.arrange') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      @foreach (config('const.project_requests') as $key => $value)
        {{ Form::checkbox('client_arrange[]', $key, null, [
          'class' => 'input-checkbox',
          'id' => 'client-arrange-' . $key,
          'data-parsley-multiple' => 'client_arrange',
          'data-parsley-errors-container' => '#client_arrange',
          'required' => '',
          'data-parsley-error-message' => __('admin.projects.fields.arrange_error')
        ]) }}
        <label for="client-arrange-{{ $key }}" class="label-checkbox">{{ str_replace('<br>', '', $value) }}</label>
      @endforeach
      <div id="client_arrange"></div>
      <label>@lang('admin.projects.fields.another')</label>
      {{ Form::textarea('client_arrange_text', null, ['id' => 'client_arrange_text', 'cols' => '50', 'rows' => 3, 'class' => 'form-control']) }}
      @if ($errors->has('client_arrange'))
        <div class="help-block">{{ $errors->first('client_arrange') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('place_pref') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.place') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {{ Form::textarea('place_pref', null, [
        'cols' => '50',
        'rows' => 3,
        'class' => 'form-control',
        'required' => '',
        'placeholder' => __('admin.projects.fields.place_placeholder')]) }}
      @if ($errors->has('place_pref'))
        <div class="help-block">{{ $errors->first('place_pref') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('point') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.point') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {{ Form::textarea('point', null, [
        'cols' => '50',
        'rows' => 3,
        'class' => 'form-control',
        'required' => '',
        'style' => 'margin-bottom: 15px',
        'placeholder' => __('admin.projects.fields.point_placeholder')
      ]) }}
      @if ($errors->has('point'))
        <div class="help-block">{{ $errors->first('point') }}</div>
      @endif
      {{ Form::textarea('describe', null, [
        'cols' => '50',
        'rows' => 9,
        'class' => 'form-control',
        'required' => '',
        'placeholder' => __('admin.projects.fields.decribe_placeholder')
      ]) }}
      @if ($errors->has('describe'))
        <div class="help-block">{{ $errors->first('describe') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.image')</label>
    <div class="col-md-6">
      {{ Form::file('image', ['class' => 'form-control']) }}
      <img src="" alt="" width="300" id="project_image">
      @if ($errors->has('image'))
        <div class="help-block">{{ $errors->first('image') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('attachments') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.attachments')</label>
    <div class="col-md-6">
      {{ Form::file('attachments[]', ['class' => 'form-control', 'multiple' => '']) }}
      @if ($errors->has('attachments'))
        <div class="help-block">{{ $errors->first('attachments') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.project_name') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {{ Form::text('title', null, ['class' => 'form-control input-lg', 'required' => '']) }}
      @if ($errors->has('title'))
        <div class="help-block">{{ $errors->first('title') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('duedate_at') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.duedate')</label>
    <div class="col-md-6">
      <div class="input-group date margin-bottom10">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        {{ Form::text('duedate_at', null, [
          'id' => 'delivery_date',
          'class' => 'form-control',
          'required' => '',
          'data-parsley-errors-container' => '#duedate_at_error',
        ]) }}
      </div>
      {{ Form::checkbox('is_duedate_undecided', 1, null, ['class' => 'hidden-checkbox', 'id' => 'duedate_at']) }}
      <label for="duedate_at">@lang('admin.projects.fields.undecided')</label>
      @if ($errors->has('duedate_at'))
        <div class="help-block">{{ $errors->first('duedate_at') }}</div>
      @endif
      <div id="duedate_at_error"></div>
    </div>
  </div>

  @php
    $statues = config('const.project_status');
    unset($statues[0]);
  @endphp
  <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('admin.projects.fields.state')</label>
    <div class="col-md-6">
      {{ Form::select('status', $statues, null, [
          'class' => 'form-control'
      ]) }}
      @if ($errors->has('status'))
        <div class="help-block">{{ $errors->first('status') }}</div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-6 col-md-offset-3">
      <button class="btn btn-primary" type="submit">@lang('admin.projects.create_submit')</button>
    </div>
  </div>
  {{ Form::close() }}
</div>
@endsection

@push('scripts')
{{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}

<script src="{{ asset('adminlte/plugins/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/parsley/i18n/ja.js') }}"></script>
{{ Html::script('ample/js/extra-rules.js') }}
<script src="{{ asset('adminlte/plugins/parsley/i18n/ja.extra.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin_project.js') }}"></script>
<script type="text/javascript">
$('#delivery_date').datepicker({
  dateFormat: 'yy/mm/dd'
});
</script>
@endpush
@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
@endpush
