@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.mails.header')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="box-body">
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

      {!! Form::open(['method' => 'post', 'url' => route('broadcast.send'), 'class' => 'form-horizontal']) !!}
      <div class="form-group">
        <label class="col-md-3 control-label">@lang('admin.mails.object')</label>
        <div class="col-md-6">
          <div>
            <label class="radio-inline">
              {!! Form::radio('mail', 2, true, ['class' => 'ui-mail-target']) !!}
              @lang('admin.mails.all')
            </label>
            <label class="radio-inline">
              {!! Form::radio('mail', 3, null, ['class' => 'ui-mail-target']) !!}
              @lang('admin.mails.skill_only')
            </label>
          </div>
          <fieldset class="ui-mail-skills">
            <legend>@lang('admin.mails.skill')</legend>
            <div>
              @foreach (config("const.skill") as $key => $value)
                <label class="checkbox-inline">
                  {!! Form::checkbox('skill[]', $key, null, ['class' => 'ui-mail-skill']) !!}
                  {{ $value }}
                </label>
              @endforeach
            </div>
          </fieldset>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">@lang('admin.mails.title')</label>
        <div class="col-md-6">
          {!! Form::text('title', __('admin.mails.title_text'), ['class' => 'form-control ui-mail-title']) !!}
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">@lang('admin.mails.content')</label>
        <div class="col-md-6">
          {!! Form::textarea('mailtext', '', ['class' => 'form-control ui-mail-text', 'rows' => 8]) !!}
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
          {!! Form::submit(__('admin.mails.submit'), ['class' => 'btn btn-warning ui-submit']) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@push('styles')
  <style>
    .ui-mail-skills legend {
      font-size: 18px;
      margin: 5px 0;
    }

    .ui-mail-skills .checkbox-inline:first-of-type {
      margin-left: 10px;
    }
  </style>
@endpush

@push('scripts')
  <script>
    (function ($) {
      if (!$('.ui-mail-target:checked').val()) {
        $('.ui-mail-target-default').attr('checked', 'checked');
      }
      if ($('.ui-mail-target:checked').val() != 3) {
        $('.ui-mail-skill').attr('disabled', true);
      }
      $('.ui-mail-target').click(function () {
        if ($(this).val() == 3) {
          $('.ui-mail-skill').attr('disabled', false);
          $('.ui-mail-skill').parent('label').removeClass('disabled');
        } else {
          $('.ui-mail-skill').attr('disabled', true);
          $('.ui-mail-skill').parent('label').addClass('disabled');
        }
      });
    })(jQuery);
  </script>
@endpush
