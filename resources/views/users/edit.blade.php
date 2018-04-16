@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title u-title-color">@lang('users.profile_title')</h4>
  </div>
  @if (auth()->user()->isCreator())
    <a href="{{ route('creators.show', ['id' => auth()->user()->id]) }}" class="pull-right" style="margin-right: 15px">
      <button class="btn btn-primary">@lang('users.profile_link')</button>
    </a>
  @endif
@endsection

@section('content')
  <div class="edit-profile white-box">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs customtab">
        <li class="{{ $tab == 'basic' ? 'active': '' }}"><a href="{{ url('/profile/basic') }}">@lang('users.tabs.basic')</a></li>
        <li class="{{ $tab == 'account' ? 'active': '' }}"><a href="{{ url('/profile/account') }}">@lang('users.tabs.account')</a></li>
        <li class="{{ $tab == 'bank' ? 'active': '' }}"><a href="{{ url('/profile/bank') }}">@lang('users.tabs.bank')</a></li>
        <li class="{{ $tab == 'client' ? 'active': '' }}"><a href="{{ url('/profile/client') }}">@lang('users.tabs.client')</a></li>
        <li class="{{ $tab == 'creator' ? 'active': '' }}"><a href="{{ url('/profile/creator') }}">@lang('users.tabs.creator')</a></li>
      </ul>
      <div class="tab-content">
        @if($tab == 'basic')
          <div class="tab-pane active" id="basic-info">
            @include('users.partials.profile_basic')
          </div><!-- /.tab-pane -->
        @endif
        @if($tab == 'account')
          <div class="tab-pane active" id="public-info">
            @include('users.partials.profile_account')
          </div><!-- /.tab-pane -->
        @endif
        @if($tab == 'bank')
          <div class="tab-pane active" id="bank-info">
            @include('users.partials.profile_bank')
          </div><!-- /.tab-pane -->
        @endif
        @if($tab == 'client')
          <div class="tab-pane active" id="client-info">
            @include('users.partials.profile_client')
          </div><!-- /.tab-pane -->
        @endif
        @if($tab == 'creator')
          <div class="tab-pane active" id="creator-info">
            @include('users.partials.profile_creator')
          </div><!-- /.tab-pane -->
        @endif
      </div>
      <!-- /.tab-content -->
    </div>
  </div>
  <script type="text/javascript">
    $(document).on('click', '.profile-hide', function() {
      $('#profile-alert').addClass('hidden')
    })
  </script>
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

    .nda {
      height: 200px;
      overflow-y: scroll;
      border: 1px solid #eee;
      padding-left: 15px;
      padding-right: 15px;
      background-color: #e9e9e9;
    }

    .checkbox-skill {
      display: none;
    }

    .checkbox-skill + label {
      padding: 5px 7px 3px 7px;
      border-radius: 2px;
      border: 1px solid #626262;
      color: #ffffff;
      background:#626262;
    }

    .checkbox-skill:checked + label {
      color: #fff;
      border-color: #3c8dbc;
      background: #77cad2;
    }

    .customtab li.active a, .customtab li.active a:hover, .customtab li.active a:focus {
      border-bottom: 2px solid #60bfb3 !important;
      color: #6ec4b9  !important;
    }
    
    .form-control:focus {
      box-shadow: none;
      border-color: #60bfb3;
    }
    .checkbox-skill:checked + label {
      border-color: #77cad2;
    }

  </style>
@endpush
