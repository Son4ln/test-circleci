@extends('layouts.ample')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">@lang('messages.login')</div>
          <div class="panel-body">
            {!! Form::open([
              'url' => route('login'),
              'method' => 'POST',
              'role' => 'form',
              'class' => 'form-horizontal',
              'id' => 'login'
            ]) !!}
              @if (session('invitation'))
                <div class="text-center" style="margin-bottom: 15px">
                  招待URLからお越しの方で、<br>
                  会員登録がまだの方は、<a style="color: #00f" href="/register">こちら</a>から会員登録をしてください
                </div>
              @endif
              {{--<div class="text-center" style="margin-bottom: 15px">
                新規プロジェクト・新規会員登録はapp.crluo.comにて、進行中のプロジェクトに関しては旧サイトで行う形となります。ユーザー情報は引き続き利用可能となっております。
              </div>--}}
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">@lang('messages.email')</label>

                <div class="col-md-6">
                  {!! Form::email('email', null, [
                    'class' => 'form-control',
                    'id' => 'email',
                    'required' => true,
                    'autofocus' => true,
                  ]); !!}
                  @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">@lang('messages.password')</label>

                <div class="col-md-6">
                  {!! Form::password('password', [
                    'class' => 'form-control',
                    'id' => 'password',
                    'required' => true,
                    'minlength' => 6
                  ]); !!}
                  @if ($errors->has('password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <div>
                    <label for="remember">
                      {!! Form::checkbox('remember', 1, old('remember'), ['id' => 'remember']) !!} @lang('messages.remember')
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  {!! Form::submit(trans('messages.login'), ['class' => 'btn btn-primary']) !!}

                  <a class="btn btn-link" href="{{ route('password.request') }}">
                    @lang('messages.forgot')
                  </a>
                  <br>
                  <a href="/connecting/facebook">
                    <button type="button" class="loginBtn loginBtn--facebook">
                      Login with Facebook
                    </button>
                  </a>
                  <br><br>
                  {{-- <a href="http://crluo.com/auth/login" target="_blank">
                    旧クルオ ログインはこちら


                  </a> --}}

                </div>
{{--
                <div class="col-md-12">
                  <br>
                  <div class="alert alert-info">
                    <h5>動作環境</h5>
                    <table class='user-env-table' cellpadding=20>
                      <tr>
                        <td colspan=4 style='text-align:left;font-weight:normal'>
                          <small>各ブラウザの<strong>最新バージョン</strong>をお使いください<br>※それ以外では正常に動作しません</small>
                        </td>
                      </tr>
                      <tr>
                        <td><img class='user-icon-small' src='/images/chrome_128x128.png'><br>Chrome</td>
                        <td><img class='user-icon-small' src='/images/firefox_128x128.png'><br>Firefox</td>
                        <td><img class='user-icon-small' src='/images/safari_128x128.png'><br>Safari</td>
                        <td><img class='user-icon-small' src='/images/edge_128x128.png'><br>Edge</td>
                      </tr>
                    </table>
                  </div>
                </div>
                  --}}
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style media="screen">
    .loginBtn {
      box-sizing: border-box;
      position: relative;
      /* width: 13em;  - apply for fixed size */
      margin-top: 1em;
      padding: 0 15px 0 46px;
      border: none;
      text-align: left;
      line-height: 34px;
      white-space: nowrap;
      border-radius: 0.2em;
      font-size: 16px;
      color: #FFF;
    }
    .loginBtn:before {
      content: "";
      box-sizing: border-box;
      position: absolute;
      top: 0;
      left: 0;
      width: 34px;
      height: 100%;
    }
    .loginBtn:focus {
      outline: none;
    }
    .loginBtn:active {
      box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
    }


    /* Facebook */
    .loginBtn--facebook {
      background-color: #4C69BA;
      background-image: linear-gradient(#4C69BA, #3B55A0);
      /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
      text-shadow: 0 -1px 0 #354C8C;
    }
    .loginBtn--facebook:before {
      border-right: #364e92 1px solid;
      background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
    }
    .loginBtn--facebook:hover,
    .loginBtn--facebook:focus {
      background-color: #5B7BD5;
      background-image: linear-gradient(#5B7BD5, #4864B1);
    }
  </style>
@endpush

@push('scripts')
  <script src="{{ asset('adminlte/plugins/parsley/parsley.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/parsley/i18n/ja.js') }}"></script>
  <script type="text/javascript">
    $('#login').parsley();
  </script>
@endpush
