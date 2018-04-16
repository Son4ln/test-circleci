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

{!! Form::model($user, ['url' => '/profile/client', 'class' => 'form-horizontal', 'id' => 'profile-form']) !!}
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.alt_name')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
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
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.tel')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('tel', null, ['class' => 'form-control']) !!}
    <p class="help-block">@lang('users.fields.tel_help')</p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.zip')</span><span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
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
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.homepage')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('homepage', null, ['class' => 'form-control']) !!}
  </div>
</div>

@can ('update', $user)
  <div class="form-group" style="margin-top: 3em;">
    <div class="col-md-6 col-md-offset-4">
      <button type="submit" class="btn l-btn-new">@lang('users.client_submit')</button>
    </div>
  </div>
@endcan
{!! Form::close() !!}
