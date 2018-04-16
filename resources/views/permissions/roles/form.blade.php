@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">{{$role->exists ? 'Update role: ' . $role->name : 'Create new role'}}</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    {!! Form::model($role, [
        'method' => $role->exists ? 'PUT' : 'POST',
        'url' => $role->exists ? route('roles.update', $role->id): route('roles.store'),
      ]) !!}
  <div>
    <a href="{{ route('roles.index') }}" class="btn btn-primary">List roles</a>
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
      <label class="col-sm-3 control-label">Role Name</label>
      <div class="col-sm-6">
        {!! Form::text('name', old('name'), [
          'class' => 'form-control',
          'placeholder' => '',
          'required' => !$isDefaultRole,
          'readonly' => $isDefaultRole,
        ]) !!}
      </div>
    </div>
    <div class="col-xs-12 form-group">
      <label class="col-sm-3 control-label">Permissions</label>
      <div class="col-sm-9">
        {!! Form::select('permissions[]', $permissions, $role->permissions()->pluck('name', 'name'), [
          'class' => 'form-control select2',
          'multiple' => 'multiple',
        ]) !!}
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-6 col-sm-offset-3">
        {!! Form::submit($role->exists ? 'Update' : 'Create', ['class' => 'btn btn-danger']) !!}
      </div>
    </div>
  </div>
  {!! Form::close() !!}
</div>
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
