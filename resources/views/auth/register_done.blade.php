@extends('layouts.ample')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">@lang('ui.registration')</div>
          <div class="panel-body">
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
            @lang('ui.registration_alert')
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
