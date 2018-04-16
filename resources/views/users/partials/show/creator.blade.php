<div class="form-horizontal">
  <div class="form-group row">
    <label class="col-md-4 control-label">希望登録区分 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::select('group', Config::get('const.group'), $user->group, ['class'=>'form-control', 'disabled' => '']) !!}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">名前 <span class="label label-warning">必須</span></label>
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
    <label class="col-md-4 control-label">チーム名</label>
    <div class="col-md-6">
      {!! Form::text('team', $user->team, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">性別 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::select('sex', Config::get('const.sex'), $user->sex, ['class'=>'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-4 control-label">スキル <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      @php $skills = $user->userSkills->pluck('kind')->all(); @endphp
      @foreach ($skills as $skill)
        <label>{{ config('const.skill.'.$skill) }}, </label>
      @endforeach
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">誕生日 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('birth', $user->birth, ['class' => 'form-control', 'disabled' => '']) !!}
      <script type="text/javascript">
        $(function () {
          $("input[name='birth']").datepicker();
        });
      </script>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">対応エリア <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::select('base', Config::get('const.base'), $user->base, ['class'=>'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">電話番号 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {!! Form::text('tel', $user->tel, ['class' => 'form-control', 'disabled' => '']) !!}
    </div>
  </div>
  {{--
  <div class="form-group">
    <label class="col-md-4 control-label">郵便番号</label>
    <div class="col-md-6">
      {!! Form::text('zip', old('zip'), ['class' => 'form-control']) !!}
      <p class="help-block">
        半角数字ハイフン無し
      </p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-4 control-label">住所</label>
    <div class="col-md-6">
      {!! Form::text('address', old('address'), ['class' => 'form-control']) !!}
    </div>
  </div>
  --}}

  <div class="form-group row">
    <label class="col-md-4 control-label">経歴 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {{ Form::textarea('career', $user->career, ['rows' => 5, 'class' => 'form-control', 'disabled' => '']) }}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">実績 <span class="label label-warning">必須</span></label>
    <div class="col-md-6">
      {{ Form::textarea('record', $user->record, ['rows' => 5, 'class' => 'form-control', 'disabled' => '']) }}
    </div>
  </div>

  <div class="form-group row">
    <label class="col-md-4 control-label">クルオに登録しようと思ったキッカケを教えてください</label>
    <div class="col-md-6">
      {{ Form::textarea('motive', $user->record, ['rows' => 5, 'class' => 'form-control', 'disabled' => '']) }}
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 control-label">クルオを何で知りましたか？</label>
    <div class="col-md-6">
      @if (is_array($user->knew))
        {{ implode(', ', $user->knew) }}
      @endif
    </div>
  </div>

  {{-- @can('update', $user)
    <div class="form-group row" style="margin-top: 3em;">
      <div class="col-md-6 col-md-offset-3">
        <a href="{{ url('profile/creator') }}"><button class="btn btn-primary">Change</button></a>
      </div>
    </div>
  @endcan --}}

</div>
