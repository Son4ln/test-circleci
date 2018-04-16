<div class="form-horizontal">
  <div class="form-group row">
    <label class="col-md-4 control-label">お名前 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('name', $user->name, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">よみがな <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('ruby', $user->ruby, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">会社名（法人のみ）</label>
    <div class="col-md-6">
      {!! Form::text('company', $user->company, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">部署名（法人のみ）</label>
    <div class="col-md-6">
      {!! Form::text('department', $user->department, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">電話番号 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('tel', $user->tel, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">郵便番号 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('zip', $user->zip, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">住所 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('address', $user->address, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  {{-- @can('update', $user)
    <div class="form-group row" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-3">
        <a href="{{ url('profile/client') }}"><button class="btn btn-primary">Change</button></a>
      </div>
    </div>
  @endcan --}}
</div>
