@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('users.list.title')</h4>
  </div>
@endsection

@section('content')
  @include('admin.partials.users_list')
@endsection

{{-- Push scripts to admin panel --}}
@push('scripts')
  {{ Html::script('js/users.list.js') }}
@endpush

@push('styles')
  <style media="screen">
    .btn-default {
      margin-bottom: 2px;
    }
  </style>
@endpush
