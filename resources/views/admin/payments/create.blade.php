@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.payments.create.title')</h4>
  </div>
  <a href="{{ route('admin.payments.index', ['userId' => request()->route()->parameters['userId']]) }}"
    style="margin-right: 15px" class="pull-right">
    <button type="button" class="btn btn-primary">@lang('payments.list.title')</button>
  </a>
@endsection

@section('content')
  <div class="white-box">
    {!! Form::open([
      'class' => 'form-horizontal',
      'url' => route('admin.payments.store', ['userId' => request()->route()->parameters['userId']])
    ]) !!}
    <div class="form-group">
      <label class="col-md-3 control-label">@lang('admin.payments.fields.project_name')</label>
      <div class="col-md-6">
        {{ Form::select('project_id', $projects, null, ['class' => 'form-control']) }}
      </div>
    </div>

    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label">@lang('admin.payments.fields.title')</label>
      <div class="col-md-6">
        {!! Form::text('title', null, ['required' => true, 'class' => 'form-control']) !!}
        @if ($errors->has('title'))
          <span class="help-block">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label">@lang('admin.payments.fields.amount')</label>
      <div class="col-md-6">
        {!! Form::number('amount', null, ['required' => true, 'class' => 'form-control']) !!}
        @if ($errors->has('amount'))
          <span class="help-block">{{ $errors->first('amount') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label">@lang('admin.payments.fields.state')</label>
      <div class="col-md-6">
        {!! Form::select('status', config('const.payment_status', []), null, ['required' => true, 'class' => 'form-control']) !!}
      </div>
    </div>

    <div class="form-group {{ $errors->has('paid_at') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label">@lang('admin.payments.fields.date')</label>
      <div class="col-md-6">
        {!! Form::text('paid_at', null, ['required' => true, 'class' => 'form-control']) !!}
        @if ($errors->has('paid_at'))
          <span class="help-block">{{ $errors->first('paid_at') }}</span>
        @endif
        <script type="text/javascript">
          $(function () {
            $("input[name='paid_at']").datepicker({dateFormat: 'yy/mm/dd'});
          });
        </script>
      </div>
    </div>

    <div class="form-group" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-3">
        <button type="submit" class="btn btn-primary btn-lg">@lang('admin.payments.create.submit')</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
@endsection

@push('scripts')
  {{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
  {{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
@endpush

@push('styles')
  {{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
@endpush
