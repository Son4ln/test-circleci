@extends('errors.layout')

@section('content')
  <h1 class="text-danger">@lang('errors.401.code')</h1>
  <h3 class="text-uppercase">@lang('errors.401.text')</h3>
  <p class="text-muted m-t-30 m-b-30">@lang('errors.401.description')</p>
@endsection
