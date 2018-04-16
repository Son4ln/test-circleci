@extends('layouts.ample')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">会員登録</div>
          <div class="panel-body">
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

            {!! Form::open([
              'url' => route('register'),
              'method' => 'POST',
              'role' => 'form',
              'class' => 'form-horizontal',
              'id' => 'register'
            ]) !!}
              {!! Form::hidden('agreement', 1) !!}

              <div class="form-group">
                <label class="col-md-4 control-label">メールアドレス <span class="label label-warning">必須</span></label>
                <div class="col-md-6">
                  {!! Form::email('email', null, [
                    'class' => 'form-control',
                    'required' => true,
                    'autofocus' => true,
                  ]); !!}
                  <span class="help-block">ログインに必要となるメールアドレスです</span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">パスワード <span class="label label-warning">必須</span></label>
                <div class="col-md-6">
                  {!! Form::password('password', [
                    'class' => 'form-control',
                    'required' => true,
                    'minlength' => 8,
                    'id' => 'password',
                    'pattern' => '^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$',
                    'data-parsley-pattern-message'=>__('users.new_password.error')
                  ]); !!}
                  <span class="help-block">8文字以上でお願いいたします</span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">パスワード確認 <span class="label label-warning">必須</span></label>
                <div class="col-md-6">
                  {!! Form::password('password_confirmation', [
                    'class' => 'form-control',
                    'required' => true,
                    'data-parsley-equalto' => '#password',
                  ]); !!}
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  {!! Form::submit(trans('messages.register'), ['class' => 'btn btn-primary']) !!}
                </div>
              </div>
            {!! Form::close() !!}
            <!--
            <div class="text-center">
              <a href="/connecting/facebook">
                <button class="loginBtn loginBtn--facebook">
                   Register as Facebook account
                </button>
              </a>
            </div>
            -->
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
    $('#register').parsley();
  </script>
@endpush
