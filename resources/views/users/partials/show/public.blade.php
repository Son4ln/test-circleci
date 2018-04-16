<div class="form-horizontal">
  <div class="form-group show">
    <label class="col-md-4 control-label">表示名</label>
    <div class="col-md-6">
      {!! Form::text('nickname', $user->nickname, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  @if($user->isCreator())
    <div class="form-group show">
      <label class="col-md-4 control-label">キャッチフレーズ</label>
      <div class="col-md-6">
        {!! Form::text('catchphrase', $user->catchphrase, ['disabled' => '', 'class' => 'form-control']) !!}
      </div>
    </div>
  @endif

  <div class="form-group show">
    <label class="col-md-4 control-label">写真</label>
    <div class="col-md-6">
      <img class="img-rounded user-icon-large" src="{{ $user->photoUrl }}"
           onerror="this.src='/images/user.png'" alt="User Image"/>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">背景</label>
    <div class="col-md-6">
      <p class="jumbotron" style="background: #cccccc url({{ $user->backgroundUrl }}) top center;
        width: 70%; min-width: 50%;
        background-size: cover;
        border:none;">
      </p>
    </div>
  </div>

  {{-- @can('update', $user)
    <div class="form-group row" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-3">
        <a href="{{ url('profile/public') }}"><button class="btn btn-primary">Change</button></a>
      </div>
    </div>
  @endcan --}}

</div>
