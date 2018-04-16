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

{!! Form::model($user, ['url' => '/profile/bank', 'class' => 'form-horizontal', 'id' => 'profile-form']) !!}
<div class="form-group">
  <label class="col-md-2 control-label profile-accound-label">@lang('users.fields.bank_name')</label>
  <div class="col-md-8">
    {!! Form::text('bank', null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label profile-accound-label">@lang('users.fields.branch')</label>
  <div class="col-md-8">
    {!! Form::text('branch', null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label profile-accound-label">@lang('users.fields.account_kind')</label>
  <div class="col-md-8">
    {!! Form::select('account_kind', ['普通','当座'], null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label profile-accound-label">@lang('users.fields.account_no')</label>
  <div class="col-md-8">
    {!! Form::text('account_no', null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label profile-accound-label">@lang('users.fields.holder')</label>
  <div class="col-md-8">
    {!! Form::text('holder', null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label profile-accound-label">@lang('users.fields.holder_ruby')</label>
  <div class="col-md-8">
    {!! Form::text('holder_ruby', null, ['class' => 'form-control']) !!}
  </div>
</div>

@can ('update', $user)
  <div class="form-group" style="margin-top: 3em;">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <button type="submit" class="btn l-btn-new">@lang('users.profile_submit')</button>
    </div>
  </div>
@endcan
{!! Form::close() !!}
