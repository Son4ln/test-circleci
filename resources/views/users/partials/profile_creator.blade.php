@if (count($errors) > 0)
  <div class="alert alert-warning">
    <strong>@lang('ui.has_error')</strong>@lang('ui.has_error_text')<br><br>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

{!! Form::model($user, ['url' => '/profile/creator', 'class' => 'form-horizontal l-upgrade', 'id' => 'profile-form']) !!}
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.group')</span><span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::select('group', Config::get('const.group'), null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.name')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <p class="help-block">
      @lang('users.fields.alt_name_help')
    </p>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.ruby')</span><span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('ruby', null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.team')</span></label>
  <div class="col-md-6">
    {!! Form::text('team', null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.sex')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::select('sex', Config::get('const.sex'), old('sex'), ['class'=>'form-control']) !!}
    <p class="help-block">
      @lang('users.fields.sex_help')
    </p>
  </div>
</div>
<div class="form-group row">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.birth')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('birth', $user->birth, ['class' => 'form-control']) !!}
    <script type="text/javascript">
      $(function () {
        $("input[name='birth']").datepicker();
      });
    </script>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.base') <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::select('base', Config::get('const.base'), old('base'), ['class'=>'form-control']) !!}
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.tel')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    {!! Form::text('tel', old('tel'), ['class' => 'form-control']) !!}
    <p class="help-block">
      @lang('users.fields.tel_help')
    </p>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.skill')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    @php $skills = $user->userSkills->pluck('kind')->all(); @endphp
    @foreach (config('const.skill') as $key => $skill)
      <input type="checkbox" name="skills[]" value="{{ $key }}"
      id="skill-{{ $key }}" class="checkbox-skill"
      {{ in_array($key, $skills) ? 'checked' : '' }}>
      <label for="skill-{{ $key }}">{{ $skill }}</label>
    @endforeach
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
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.career')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    @php
    $careerPlaceHolder = __('users.fields.career_placeholder');
    @endphp
    {{ Form::textarea('career', old('career'), ['rows' => 5, 'class' => 'form-control', 'placeholder' => $careerPlaceHolder ]) }}
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.record')</span> <span class="label label-warning label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
  <div class="col-md-6">
    @php
    $recordPlaceHolder = __('users.fields.record_placeholder');
    @endphp
    {{ Form::textarea('record', old('record'), ['rows' => 5, 'class' => 'form-control', 'placeholder' => $recordPlaceHolder ]) }}
    <p class="help-block">
      @lang('users.fields.record_help')
    </p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.alt_motive')</span></label>
  <div class="col-md-6">
    {{ Form::textarea('motive', old('motive'), ['rows' => 5, 'class' => 'form-control']) }}
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label"><span class="padding-right-10">@lang('users.fields.knew')</span></label>
  <div class="col-md-6 l-upgrade-c">
    {{ Form::checkbox('knew[]', 'vivitoのサイトで', null, ['id' => 'knew-1']) }}
    <label for="knew-1"> vivitoのサイトで</label><br>

    {{ Form::checkbox('knew[]', 'vivitoの営業担当から', null, ['id' => 'knew-2']) }}
    <label for="knew-2"> vivitoの営業担当から</label><br>

    <p class="help-block">@lang('users.fields.knew_sales')</p>
    {{ Form::text('knew_sales', null, ['class' => 'form-control']) }}

    {{ Form::checkbox('knew[]', 'vivitoマガジン', null, ['id' => 'knew-3']) }}
    <label for="knew-3"> vivitoマガジン</label><br>

    {{ Form::checkbox('knew[]', 'クルオマガジン', null, ['id' => 'knew-4']) }}
    <label for="knew-4"> クルオマガジン</label><br>

    {{ Form::checkbox('knew[]', '検索サイトから', null, ['id' => 'knew-5']) }}
    <label for="knew-5"> 検索サイトから</label><br>

    {{ Form::checkbox('knew[]', 'バナー広告', null, ['id' => 'knew-6']) }}
    <label for="knew-6"> バナー広告</label><br>

    {{ Form::checkbox('knew[]', 'YouTube', null, ['id' => 'knew-7']) }}
    <label for="knew-7"> YouTube</label><br>

    {{ Form::checkbox('knew[]', 'Facebook', null, ['id' => 'knew-8']) }}
    <label for="knew-8"> Facebook</label><br>

    {{ Form::checkbox('knew[]', 'Twitter', null, ['id' => 'knew-9']) }}
    <label for="knew-9"> Twitter</label><br>

    {{ Form::checkbox('knew[]', 'セミナー・勉強会', null, ['id' => 'knew-10']) }}
    <label for="knew-10"> セミナー・勉強会</label><br>

    {{ Form::checkbox('knew[]', '友人・知人からの紹介', null, ['id' => 'knew-11']) }}
    <label for="knew-11"> 友人・知人からの紹介</label><br>

    <p class="help-block">@lang('users.fields.knew_other')</p>
    {{ Form::text('knew_other', null, ['class' => 'form-control']) }}
  </div>
</div>

@can ('update', $user)
  <div class="form-group" style="padding: 15px 50px 0 50px;">
    <label class="col-md-4 control-label"></label>
    <div class="nda col-md-6">
      @include('rules')
    </div>
  </div>

  @role('creator')
    <input type="hidden" name="nda" value="1">
  @else
  <div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-6 l-upgrade-c">
        <input type="checkbox" id="anda" name="nda" value="1">
        <label for="anda"> @lang('users.fields.rules_accept') </label>
    </div>
  </div>
  @endrole

  <div class="form-group" style="padding: 15px 50px 0 50px;">
    <label class="col-md-4 control-label"></label>
    <div class="nda col-md-6 ">
      @include('nda')
    </div>
  </div>

  @role('creator')
    <input type="hidden" name="agreement" value="1">
  @else
  <div class="form-group">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-6 l-upgrade-c">
      <input type="checkbox" name="agreement" value="1" id="l-nda_accept">
      <label for="l-nda_accept">@lang('users.fields.nda_accept')</label>
    </div>
  </div>
  @endrole

  <div class="form-group">
    <div class="col-md-6 col-md-offset-4">
      <button type="submit" class="btn l-btn-new">@lang('users.fields.creator_submit')</button>
    </div>
  </div>
@endcan
{!! Form::close() !!}

<script>
$(document).ready(function () {
  var $form = $('#profile-form');
  var $btn = $form.find('button[type=submit]');
  var $loading = $('#loading');

  $form.on('submit', function (e) {
    if (!rules.prop('checked') || !nda.prop('checked')) {
      e.preventDefault()
    }
  });
});
</script>
