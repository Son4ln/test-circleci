<div class="panel panel-default">
  <div class="panel-heading profile-accound-title">
    @lang('users.account.change_mail')
  </div>
  <div class="panel-body">
    {{ Form::open(['url' => route('users.email'), 'id' => 'change-email', 'class' => 'form-horizontal']) }}
      <div class="form-group">
        <label class="col-md-4 control-label profile-accound-label">@lang('users.account.current_mail')</label>
        <div class="col-md-6">
          {{ Form::email('old_email', null, ['class' => 'form-control']) }}
          @if ($errors->has('old_email'))
            <span class="text-danger">{{ $errors->first('old_email') }}</span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label profile-accound-label">@lang('users.account.new_mail')</label>
        <div class="col-md-6">
          {{ Form::email('email', null, ['class' => 'form-control']) }}
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label profile-accound-label">@lang('users.account.retype_mail')</label>
        <div class="col-md-6">
          {{ Form::email('email_confirmation', null, ['class' => 'form-control']) }}
          @if ($errors->has('email_confirmation'))
            <span class="text-danger">{{ $errors->first('email_confirmation') }}</span>
          @endif
        </div>
      </div>

      @can ('update', $user)
        <div class="form-group" style="margin-top: 3em;">
          <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn l-btn-new">@lang('users.account.change_mail_submit')</button>
          </div>
        </div>
      @endcan
    {{ Form::close() }}
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading profile-accound-title">
    @lang('users.account.change_password')
  </div>
  <div class="panel-body">
  {!! Form::model($user, [
    'url' => '/profile/account',
    'class' => 'form-horizontal',
    'id' => 'profile-form'
  ]) !!}

  <div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
    <label class="col-md-4 control-label  profile-accound-label">@lang('users.account.current_password')</label>
    <div class="col-md-6">
      {!! Form::password('old_password', ['class' => 'form-control']) !!}
      @if ($errors->has('old_password'))
        <span class="text-danger">{{ $errors->first('old_password') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label class="col-md-4 control-label  profile-accound-label">@lang('users.account.password')</label>
    <div class="col-md-6">
      {!! Form::password('password', ['class' => 'form-control']) !!}
      @if ($errors->has('password'))
        <span class="text-danger">{{ $errors->first('password') }}</span>
      @endif
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-4 control-label  profile-accound-label">@lang('users.account.retype_password')</label>
    <div class="col-md-6">
      {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    </div>
  </div>

  @can ('update', $user)
    <div class="form-group" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn l-btn-new">@lang('users.account.change_mail_submit')</button>
      </div>
    </div>
  @endcan
  {!! Form::close() !!}
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading profile-accound-title">
    @lang('users.account.facebook_connect')
  </div>
  <div class="panel-body text-center">
    @if ($user->facebook_id)
      <div class="text-center text-warning" style="margin-bottom: 15px">
        @lang('users.account.facebook_name', ['name' => $user->facebook_name])
      </div>
      <a href="{{ url('revoke/facebook') }}" onclick="return confirm(@lang('users.account.confirm_text'))">
        <button type="button" class="btn l-profile-btn-facebook" style="">@lang('users.account.disconnect_button')</button>
      </a>
    @else
      <a href="{{ url('connecting/facebook') }}">
        <button type="button" class="btn l-profile-btn-facebook" >@lang('users.account.connect_button')</button>
      </a>
    @endif
  </div>
</div>
