@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title u-title-color">@lang('users.upgrade.creator_title')</h4>
</div>
@endsection

@section('content')
<div class="">
	<div class="">
	<div class="col-md-12 "><!-- col-md-offset-2 -->
		<div class="">
		<div class="" style="background: #ffffff">
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>@lang('ui.has_error')</strong>@lang('ui.has_error_text')<br><br>
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
			@else
			<div class="alert alert-info alert-dismissable " style="background:#60bfb3;border:1px solid #60bfb3">
				<!-- <button class="close" data-dismiss="alert" aria-label="close">&times;</button> -->
				@lang('users.upgrade.creator_alert_1')
				<br><br>
				@lang('users.upgrade.creator_alert_2')
			</div>
			@endif
			{{ Form::open(['url' => url('/profile/creator'), 'id' => 'upgrade', 'role' => 'form', 'class' => 'form-horizontal l-upgrade']) }}
			<input type="hidden" name="creator_need_active" value="1">
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.group') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				{!! Form::select('group', Config::get('const.group'), old('group'), ['class'=>'form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.name') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control " name="name" value="{{ old('name') }}" required>
				<p class="help-block">
					@lang('users.upgrade.name_help_1')<br>
					@lang('users.upgrade.name_help_2')
				</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.ruby') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="ruby" value="{{ old('ruby') }}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.team')</label>
				<div class="col-md-6">
				<input type="text" class="form-control" name="team"
				value="{{ old('team') }}" {{ in_array(old('group'), ['1', '8' ,0]) ? 'disabled' : '' }}>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.sex') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				{!! Form::select('sex', Config::get('const.sex'), old('sex'), ['class'=>'form-control']) !!}
				<p class="help-block">
					@lang('users.fields.sex_help')
				</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.base') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				{!! Form::select('base', Config::get('const.base'), old('base'), ['class'=>'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.tel') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				<input type="tel" class="form-control" name="tel" value="{{ old('tel') }}" required>
				<p class="help-block">
					@lang('users.fields.tel_help')
				</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">@lang('users.fields.skill') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
				<div class="col-md-6">
				@foreach (config('const.skill') as $key => $skill)
					<input type="checkbox" name="skills[]" value="{{ $key }}" id="skill-{{ $key }}" class="checkbox-skill" {{ old('skills') && in_array($key, old('skills')) ? 'checked' : '' }}>
					<label for="skill-{{ $key }}">{{ $skill }}</label>
				@endforeach
				</div>
			</div>
			{{--<div class="form-group">
			<label class="col-md-4 control-label">郵便番号</label>
			<div class="col-md-6">
			<p class="help-block">
			半角数字ハイフン無し
			</p>
			<input type="zip" class="form-control" name="zip" value="{{ old('zip') }}">
		</div>
		</div>
		<div class="form-group">
		<label class="col-md-4 control-label">住所</label>
		<div class="col-md-6">
		<input type="address" class="form-control" name="address" value="{{ old('address') }}">
	</div>
	</div>--}}
			<div class="form-group">
			<label class="col-md-4 control-label">@lang('users.fields.birth') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
			<div class="col-md-6">
				<input type="birth" class="form-control" name="birth" value="{{ old('birth') }}">
			</div>
			</div>

			<div class="form-group">
			<label class="col-md-4 control-label">@lang('users.fields.career') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
			<div class="col-md-6">
				<textarea type="career" class="form-control" name="career" rows='5' placeholder="@lang('users.fields.career_placeholder')">{{ old('career') }}</textarea>
			</div>
			</div>

			<div class="form-group">
			<label class="col-md-4 control-label">@lang('users.fields.record') <span class="label label-warning-new padding-left-right-25">@lang('ui.required')</span></label>
			<div class="col-md-6">
				<textarea type="record" class="form-control" name="record" rows='5' placeholder="@lang('users.fields.record_placeholder')">{{ old('record') }}</textarea>
				<p class="help-block">
				@lang('users.fields.record_help')
				</p>
			</div>
			</div>

			<div class="form-group">
			<label class="col-md-4 control-label">@lang('users.fields.alt_motive')</label>
			<div class="col-md-6">
				<textarea type="motive" class="form-control" name="motive" rows='5'>{{ old('motive') }}</textarea>
			</div>
			</div>

			<div class="form-group">
			<label class="col-md-4 control-label">@lang('users.fields.knew')</label>
			<div class="col-md-6 l-upgrade-c">
				{{ Form::checkbox('knew[]', 'vivitoのサイトで', null, ['id' => 'knew-1']) }}
				<label for="knew-1"> vivitoのサイトで</label><br>

				{{ Form::checkbox('knew[]', 'vivitoの営業担当から', null, ['id' => 'knew-2']) }}
				<label for="knew-2"> vivitoの営業担当から</label><br>

				<p class="help-block margin-0">@lang('users.fields.knew_sales')</p>
				{{ Form::text('knew_sales', null, ['class' => 'form-control margin-botton-10']) }}

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

			<div class="form-group" style="padding: 15px 0 0 20px;">
			<div class="nda col-md-6 col-md-offset-4">
				@include('rules')
			</div>
			</div>

			<div class="form-group">
			<label class="col-md-4 control-label"></label>
			<div class="col-md-6 l-upgrade-c" style="margin-top: -19px;">
				<input type="checkbox" name="nda" value="1" id="nda">
				<label for="nda">@lang('users.fields.rules_accept')</label>
			</div>
			</div>

			<div class="form-group" style="padding: 15px 0 0 20px;">
			<div class="nda col-md-6 col-md-offset-4" style="background: #e9e9e9; border-color:#e9e9e9">
				@include('nda')
			</div>
			</div>

			<div class="form-group">
			<label class="col-md-4 control-label"></label>
			<div class="col-md-6 l-upgrade-c" style="margin-top: -11px;">
				<input type="checkbox" name="agreement" value="1" id="agreement">
				<label for="agreement">@lang('users.fields.nda_accept')</label>
			</div>
			</div>

			<div class="form-group">
			<div class="text-center" style="padding-bottom: 50px">
				<button type="submit" class="btn btn-primary disabled background-05348b l-new-button l-bg-color-60bfb3">
				@lang('users.upgrade.creator_submit')
				</button>
			</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>
	</div>
</div>
</div>

@endsection

@push('styles')
{{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
<style media="screen">
	.nda {
	height: 200px;
	overflow-y: scroll;
	border: 1px solid #ddd;
	padding-left: 15px;
	padding-right: 15px;
	background-color: #ddd;
	}

	.checkbox-skill {
	display: none;
	}

	.checkbox-skill + label {
	padding: 5px 7px 3px 7px;
	border-radius: 2px;
	border: 1px solid #626262;
	color: #555;
	font-weight: bold;
	background:#626262;
	color:#ffffff;
	}

	.checkbox-skill:checked + label {
		color: #fff;
		border-color: #60bfb3;
		background: #60bfb3;
		
	}
</style>
@endpush

@push('scripts')
{{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
<script>
$(function ($) {
	var nda = $('input[name="agreement"]')
	var rules = $('input[name="nda"]')
	if (rules.prop('checked') && nda.prop('checked')) {
	$('button[type="submit"]').removeClass('disabled')
	} else {
	$('button[type="submit"]').addClass('disabled')
	}

	$('input[name="agreement"], input[name="nda"]').change(function() {
	if (rules.prop('checked') && nda.prop('checked')) {
		$('button[type="submit"]').removeClass('disabled')
	} else {
		$('button[type="submit"]').addClass('disabled')
	}
	})

	$('#upgrade').submit(function(e) {
	if (!rules.prop('checked') || !nda.prop('checked')) {
		e.preventDefault()
	}
	})

	$("input[name='birth']").datepicker();
	$("input[name='birth']").datepicker("setDate", "{{date('Y/m/d',strtotime(old('birth')!=null? old('birth'):'1980/1/1'))}}");

	$("select[name='group']").change(function () {
	if (jQuery.inArray($(this).val(), ['1', '8']) == -1) {
		$("input[name='team']").removeProp("disabled");
	} else {
		$("input[name='team']").prop("disabled", 'disabled');
	}
	});

	if (jQuery.inArray($("select[name='group']").val(), ['1', '8']) == -1) {
	$("input[name='team']").prop("disabled", 'disabled');
	}
});
</script>
@endpush
