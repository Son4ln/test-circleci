@extends('layouts.ample')

@section('content-header')
  <!-- .page title -->
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('users.show_title')</h4>
  </div>
  <!-- /.page title -->
@endsection

@section('content')
  <div class="edit-profile white-box">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs customtab">
        <li class="active"><a href="#basic-info" data-toggle="tab">@lang('users.tabs.basic')</a></li>
        <li><a href="#public-info" data-toggle="tab">@lang('users.tabs.account')</a></li>
        <li><a href="#bank-info" data-toggle="tab">@lang('users.tabs.bank')</a></li>
        <li><a href="#client-info" data-toggle="tab">@lang('users.tabs.client')</a></li>
        <li><a href="#creator-info" data-toggle="tab">@lang('users.tabs.creator')</a></li>
      </ul>
      <!-- /.tab-content -->
    </div>
  </div>
@endsection

@push('scripts')
  {{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
  {{ Html::script('adminlte/plugins/jquery-ui/ui/i18n/datepicker-ja.js') }}
@endpush

@push('styles')
  {{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
  <style>
    .tab-content .tab-pane {
      padding-top: 2em;
    }
  </style>
@endpush
