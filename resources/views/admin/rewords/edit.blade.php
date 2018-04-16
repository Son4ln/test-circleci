@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.rewords.edit.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    {!! Form::model($reword, [
      'class' => 'form-horizontal',
      'url' => route('admin.rewords.update', ['id' => $reword->id]),
      'method' => 'put'
    ]) !!}
    {{-- <div class="form-group {{ $errors->has('reword') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label">プロジェクト</label>
      <div class="col-md-6">
        {{ Form::select('project_id', $projects, null, ['class' => 'form-control']) }}
        @if ($errors->has('project_id'))
          <span class="help-block">{{ $errors->first('project_id') }}</span>
        @endif
      </div>
    </div> --}}

    <div class="form-group {{ $errors->has('reword') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label">@lang('admin.rewords.fields.amount')</label>
      <div class="col-md-6">
        {!! Form::number('reword', null, ['required' => true, 'class' => 'form-control']) !!}
        @if ($errors->has('reword'))
          <span class="help-block">{{ $errors->first('reword') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group {{ $errors->has('reword_date') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label">@lang('admin.rewords.fields.date')</label>
      <div class="col-md-6">
        {!! Form::text('reword_date', null, ['required' => true, 'class' => 'form-control']) !!}
        @if ($errors->has('reword_date'))
          <span class="help-block">{{ $errors->first('reword_date') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-3">
        <button type="submit" class="btn btn-primary btn-lg">@lang('admin.rewords.edit.submit')</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
@endsection

@push('scripts')
  {{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
  {{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
  <script type="text/javascript">
    $(function () {
      $("input[name='reword_date']").datepicker({dateFormat: 'yy/mm/dd'});
      @if ($reword->reword_date)
        $("input[name='reword_date']").datepicker('setDate', '{{ $reword->reword_date->format('Y/m/d') }}');
      @else
        $("input[name='reword_date']").datepicker('setDate', '{{ $reword->created_at->format('Y/m/d') }}');
      @endif
    });
  </script>
@endpush

@push('styles')
  {{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
@endpush
