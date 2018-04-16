<div class="form-horizontal">
  <div class="form-group row">
    <label class="col-md-4 control-label">銀行名</label>
    <div class="col-md-6">
      {!! Form::text('bank', $user->bank, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">支店名</label>
    <div class="col-md-6">
      {!! Form::text('branch', $user->branch, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">口座種別</label>
    <div class="col-md-6">
      {!! Form::select('account_kind', ['普通','当座'], $user->account_kind, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">口座番号</label>
    <div class="col-md-6">
      {!! Form::text('account_no', $user->account_no, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">口座名義</label>
    <div class="col-md-6">
      {!! Form::text('holder', $user->holder, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">口座名義カナ</label>
    <div class="col-md-6">
      {!! Form::text('holder_ruby', $user->holder_ruby, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  {{-- @can('update', $user)
    <div class="form-group row" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-3">
        <a href="{{ url('profile/bank') }}"><button class="btn btn-primary">Change</button></a>
      </div>
    </div>
  @endcan --}}

</div>
