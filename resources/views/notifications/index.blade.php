@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('notifications.title')</h4>
  </div>
@endsection

@section('content')
  <div class="ui-crluo-info">
    @include('widget.admin_info')
  </div>
@endsection
