@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('users.edit_title')</h4>
  </div>
@endsection

@section('content')
    @include('widget.user_edit')
@endsection

@push('scripts')
  {{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
  {{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
  <script type="text/javascript" src="{{ asset('adminlte/plugins/select2/js/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('adminlte/plugins/select2/js/i18n/ja.js') }}"></script>
  <script type="text/javascript">
    $("input[name='birth']").datepicker();
    $("input[name='birth']").datepicker("setDate", "{{date('Y/m/d',strtotime($user['birth']))}}");
    $('.select2').select2({theme: "classic"});
    $('input[name="created_at"]').datepicker();
    @if ($user->created_at)
      $('input[name="created_at"]').datepicker("setDate", "{{date('Y/m/d',strtotime($user['created_at']))}}");
    @endif
    $('input[name="activated_at"]').datepicker();
    @if ($user->activated_at)
      $('input[name="activated_at"]').datepicker("setDate", "{{date('Y/m/d',strtotime($user['activated_at']))}}");
    @endif
  </script>
@endpush

@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<style media="screen">
.checkbox-skill {
  display: none;
}

.checkbox-skill + label {
  padding: 5px 7px 3px 7px;
  border-radius: 2px;
  border: 1px solid #ccc;
  color: #555;
  font-size: 0.7em;
}

.checkbox-skill:checked + label {
  color: #fff;
  border-color: #3c8dbc;
  background: #77cad2;
}
</style>
@endpush
