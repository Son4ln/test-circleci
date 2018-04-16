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

{!! Form::model($user, [
  'url' => '/profile/basic',
  'class' => 'form-horizontal',
  'id' => 'profile-form',
  'files' => true
]) !!}
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10"> @lang('users.fields.alt_name') </span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <p class="help-block">@lang('users.fields.name_help')</p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.ruby')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('ruby', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.tel')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('tel', null, ['class' => 'form-control']) !!}
    <p class="help-block">@lang('users.fields.tel_help')</p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.zip')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('zip', null, ['class' => 'form-control']) !!}
    <p class="help-block">@lang('users.fields.zip_help')</p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.address')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.alt_company_name')</span></label>
  <div class="col-md-6">
    {!! Form::text('company', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.alt_department')</span></label>
  <div class="col-md-6">
    {!! Form::text('department', null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.homepage')</span></label>
  <div class="col-md-6">
    {!! Form::text('homepage', $user->homepage ? null : 'http://', ['class' => 'form-control']) !!}
  </div>
</div>

@if($user->isCreator())
  <div class="form-group">
    <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.catchphrase')</span></label>
    <div class="col-md-6">
      {!! Form::text('catchphrase', null, ['class' => 'form-control']) !!}
      <p class="help-block">
        @lang('users.fields.catchphrase_text')
      </p>
    </div>
  </div>
@endif

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.image')</span></label>
  <div class="col-md-6">
    <img class="img-rounded user-icon-large" src="{{ $user->photoUrl }}"
         onerror="this.src='/images/user.png'" alt="User Image"/>
    <p></p>
    {!! Form::file('photo') !!}
    <p class="help-block"> PNG / JPEG </p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.background')</span></label>
  <div class="col-md-6">
    <p class="jumbotron" style="background: #cccccc url({{ $user->backgroundUrl }}) top center;
      width: 70%; min-width: 50%;
      background-size: cover;
      border:none;">
    </p>
    {!! Form::file('background') !!}
    <p class="help-block"> PNG / JPEG </p>
  </div>
</div>
{{--
<div class="form-group">
  <label class="col-md-4 control-label">誕生日 <span class="label label-warning">必須</span></label>
  <div class="col-md-6">
    {!! Form::text('birth', null, ['class' => 'form-control']) !!}
    <script type="text/javascript">
      $(function () {
        $("input[name='birth']").datepicker();
      });
    </script>
  </div>
</div>
--}}

@can ('update', $user)
  <div class="form-group" style="margin-top: 3em;">
    <div class="col-md-6 col-md-offset-4">
      <button type="submit" class="btn l-btn-new">@lang('users.profile_submit')</button>
    </div>
  </div>
@endcan
{!! Form::close() !!}
