@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title u-title-color">@lang('projects.client_list.title')</h4>
  </div>
@endsection

@section('content')
  <div id='projects'>
    @include('widget.client_project')
  </div>
@endsection

@push('styles')
  {{ Html::style('css/style.css') }}
@endpush
