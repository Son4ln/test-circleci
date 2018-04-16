@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('permissions.users.title') #{{$user->id}} {{$user->name}}</h4>
  </div>
@endsection

@section('content')
  {!! Form::model($user, [
        'method' => 'PUT',
        'url' => route('set-permissions.update', $user->id),
        'class' => 'white-box',
      ]) !!}
  <div>
    <a href="{{ route('set-permissions.index') }}" class="btn btn-primary">Set permissions</a>
  </div>

  <div class="form-horizontal">
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
      <label class="col-sm-3 control-label">Roles</label>
      <div class="col-sm-6">
        {!! Form::select('roles[]', $roles, $user->roles->pluck('name', 'name'), [
          'class' => 'form-control select2',
          'multiple' => 'multiple',
          'required' => false,
        ]) !!}
      </div>
    </div>
    <div class="col-xs-12 form-group">
      <label class="col-sm-3 control-label">Special Permissions</label>
      <div class="col-sm-9">
        {!! Form::select('permissions[]', $permissions, $user->permissions->pluck('name', 'name'), [
          'class' => 'form-control select2',
          'multiple' => 'multiple',
          'required' => false,
        ]) !!}
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-6 col-sm-offset-3">
        {!! Form::submit('Update', ['class' => 'btn btn-danger']) !!}
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@endsection

@push('styles')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <style media="screen">
    li[aria-selected="true"] {
      background: #ccc;
    }
  </style>
@endpush

@push('scripts')
  <script type="text/javascript" src="{{ asset('adminlte/plugins/select2/js/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('adminlte/plugins/select2/js/i18n/ja.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('.select2').select2({theme: "classic"});
    });
  </script>
@endpush
