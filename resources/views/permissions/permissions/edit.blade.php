@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('permissions.permissions.title')</h4>
  </div>
@endsection

@section('content')
  {!! Form::model($permission, [
        'method' => 'PUT',
        'url' => route('permissions.update', $permission->id),
        'class' => 'box'
      ]) !!}
  <div class="box-header with-border">
    <a href="{{ route('permissions.index') }}" class="btn btn-primary">List permissions</a>
  </div>

  <div class="box-body form-horizontal">
    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>エラー</strong>入力にいくつかの問題が有ります。<br><br>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="form-group">
      <label class="col-sm-3 control-label">Permission Name</label>
      <div class="col-sm-6">
        {!! Form::text('name', old('name'), [
          'class' => 'form-control',
          'placeholder' => '',
          'readonly' => true,
        ]) !!}
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Description</label>
      <div class="col-sm-6">
        {!! Form::textarea('description', old('description'), [
          'class' => 'form-control',
          'placeholder' => '',
          'required' => false,
        ]) !!}
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-6 col-sm-offset-3">
        {!! Form::submit(trans('permissions.app_update'), ['class' => 'btn btn-danger']) !!}
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@endsection
