@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('users.create_title')</h4>
  </div>
@endsection

@section('content')
  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>@lang('ui.has_error')</strong>@lang('ui.has_error_text')<br><br>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  {{ Form::open([
    'class' => 'form-horizontal white-box',
    'method' => 'POST',
    'url' => route('admin.user.store'),
    'enctype' => 'multipart/form-data'
  ])
}}
<div class="">
  <h4>@lang('users.fields.account')</h4>
</div>

<div class='well'>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.type')</label>
    <div class="col-md-6">
      {!! Form::select('roles[]', $roles, null, [
        'class' => 'form-control select2',
        'multiple' => 'multiple',
        'required' => false,
      ]) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.enabled')</label>
    <div class="col-md-6">
      {{ Form::select('enabled', config('const.enabled'), 1, ['class' => 'form-control']) }}
    </div>
  </div>

  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('users.fields.name') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {{ Form::text('name', null, ['class' => 'form-control']) }}
      @if ($errors->has('name'))
        <span class="help-block">{{ $errors->first('name') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('users.fields.mail') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {{ Form::email('email', null, ['class' => 'form-control', 'required' => true]) }}
      @if ($errors->has('email'))
        <span class="help-block">{{ $errors->first('email') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label">@lang('users.fields.password') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {!! Form::password('password', [
        'class' => 'form-control',
      ]); !!}
      <span>@lang('users.fields.password_warning')</span>
      @if ($errors->has('password'))
        <span class="help-block">{{ $errors->first('password') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.re_password') <span class="label label-warning">@lang('ui.required')</span></label>
    <div class="col-md-6">
      {!! Form::password('password_confirmation', [
        'class' => 'form-control',
      ]); !!}
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.ruby')</label>
    <div class="col-md-6">
      {{ Form::text('ruby', null, ['class' => 'form-control']) }}
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.tel')</label>
    <div class="col-md-6">
      {{ Form::text('tel', null, ['class' => 'form-control']) }}
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.zip')</label>
    <div class="col-md-6">
      {{ Form::text('zip', null, ['class' => 'form-control']) }}
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.address')</label>
    <div class="col-md-6">
      {{ Form::text('address', null, ['class' => 'form-control']) }}
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.image')</label>
    <div class="col-md-6">
      {!! Form::file('photo') !!}
      <p class="help-block"> PNG / JPEG </p>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.background')</label>
    <div class="col-md-6">
      {!! Form::file('background') !!}
      <p class="help-block"> PNG / JPEG </p>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.created')</label>
    <div class="col-md-6">
      {{ Form::text('created_at', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.activated')</label>
    <div class="col-md-6">
      {{ Form::text('activated_at', null, ['class' => 'form-control']) }}
      @lang('users.fields.activated_text')
    </div>
  </div>
</div>

<div class=""><h4>@lang('users.fields.client')</h4></div>
<div class="well">
  {{-- Client here --}}
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.company_name')</label>
    <div class="col-md-6">
      {{ Form::text('company', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.department')</label>
    <div class="col-md-6">
      {{ Form::text('department', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.homepage')</label>
    <div class="col-md-6">
      {!! Form::text('homepage', null, ['class' => 'form-control']) !!}
    </div>
  </div>
</div>
<div class=""><h4>@lang('users.fields.creator')</h4></div>
<div class="well">
  {{-- Creator info here --}}
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.group')</label>
    <div class="col-md-6">
      {{ Form::select('group', config('const.group'), null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.catchphrase')</label>
    <div class="col-md-6">
      {!! Form::text('catchphrase', null, ['class' => 'form-control']) !!}
      <p class="help-block">
        @lang('users.fields.catchphrase_text')
      </p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.team')</label>
    <div class="col-md-6">
      {{ Form::text('team', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.skill')</label>
    <div class="col-md-6">
      @foreach (config('const.skill') as $key => $skill)
        <input type="checkbox" name="skills[]" value="{{ $key }}"
        id="skill-{{ $key }}" class="checkbox-skill"
        {{ in_array($key, old('skills') ?? []) ? 'checked' : '' }}>
        <label for="skill-{{ $key }}">{{ $skill }}</label>
      @endforeach
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.base')</label>
    <div class="col-md-6">
      {{ Form::select('base', config('const.base'), null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.career')</label>
    <div class="col-md-6">
      {{ Form::textarea('career', null, ['class' => 'form-control', 'style' => 'margin: 1rem 0']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.sex')</label>
    <div class="col-md-6">
      {!! Form::select('sex', config('const.sex'), null, ['class'=>'form-control']) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.birth')</label>
    <div class="col-md-6">
      {{ Form::text('birth', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.record')</label>
    <div class="col-md-6">
      <p class="help-block">
        @lang('users.fields.record_text')
      </p>
      {{ Form::textarea('record', null, ['class' => 'form-control', 'style' => 'margin: 1rem 0']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.motive')</label>
    <div class="col-md-6">
      {{ Form::textarea('motive', null, ['class' => 'form-control', 'style' => 'margin: 1rem 0']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.knew')</label>
    <div class="col-md-6">
      {{ Form::checkbox('knew[]', 'vivitoのサイトで', null, ['id' => 'knew-1']) }}
        <label for="knew-1"> vivitoのサイトで</label><br>

        {{ Form::checkbox('knew[]', 'vivitoの営業担当から', null, ['id' => 'knew-2']) }}
        <label for="knew-2"> vivitoの営業担当から</label><br>

        <p class="help-block">@lang('users.fields.knew_sales')</p>
        {{ Form::text('knew_sales', null, ['class' => 'form-control']) }}

        {{ Form::checkbox('knew[]', 'vivitoマガジン', null, ['id' => 'knew-3']) }}
        <label for="knew-3"> vivitoマガジン</label><br>

        {{ Form::checkbox('knew[]', 'クルオマガジン', null, ['id' => 'knew-4']) }}
        <label for="knew-4"> クルオマガジン</label><br>

        {{ Form::checkbox('knew[]', '検索サイトから', null, ['id' => 'knew-5']) }}
        <label for="knew-5"> 検索サイトから</label><br>

        {{ Form::checkbox('knew[]', 'バナー広告', null, ['id' => 'knew-6']) }}
        <label for="knew-6"> バナー広告</label><br>

        {{ Form::checkbox('knew[]', 'YouTube', null, ['id' => 'knew-7']) }}
        <label for="knew-7"> YouTube</label><br>

        {{ Form::checkbox('knew[]', 'Facebook', null, ['id' => 'knew-8']) }}
        <label for="knew-8"> Facebook</label><br>

        {{ Form::checkbox('knew[]', 'Twitter', null, ['id' => 'knew-9']) }}
        <label for="knew-9"> Twitter</label><br>

        {{ Form::checkbox('knew[]', 'セミナー・勉強会', null, ['id' => 'knew-10']) }}
        <label for="knew-10"> セミナー・勉強会</label><br>

        {{ Form::checkbox('knew[]', '友人・知人からの紹介', null, ['id' => 'knew-11']) }}
        <label for="knew-11"> 友人・知人からの紹介</label><br>

        <p class="help-block">@lang('users.fields.knew_other')</p>
      {{ Form::text('knew_other', null, ['class' => 'form-control']) }}
    </div>
  </div>
</div>

<div class=""><h4>@lang('users.fields.bank')</h4></div>
<div class="well">
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.bank_name')</label>
    <div class="col-md-6">
      {{ Form::text('bank', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.branch')</label>
    <div class="col-md-6">
      {{ Form::text('branch', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.account_kind')</label>
    <div class="col-md-6">
      {{ Form::select('account_kind', ['普通','当座'], null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.account_no')</label>
    <div class="col-md-6">
      {{ Form::text('account_no', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.holder')</label>
    <div class="col-md-6">
      {{ Form::text('holder', null, ['class' => 'form-control']) }}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">@lang('users.fields.holder_ruby')</label>
    <div class="col-md-6">
      {{ Form::text('holder_ruby', null, ['class' => 'form-control']) }}
    </div>
  </div>
</div>

<div class="panel-footer" style="margin-bottom: 100px">
  <div>
    <button id='user-edit-btn' class='btn btn-warning' data-loading-text="更新中">@lang('users.fields.submit')</button>
  </div>
</div>
{{ Form::close() }}
@endsection

@push('styles')
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

@push('scripts')
{{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
<script type="text/javascript" src="{{ asset('adminlte/plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminlte/plugins/select2/js/i18n/ja.js') }}"></script>
<script type="text/javascript">
  $('.select2').select2({theme: "classic"});
  $("input[name='birth']").datepicker();
  $('input[name="created_at"]').datepicker();
  $('input[name="created_at"]').datepicker("setDate", new Date());
  $('input[name="activated_at"]').datepicker();
</script>
@endpush

@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endpush
