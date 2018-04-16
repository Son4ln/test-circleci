@extends('errors.layout')

@section('content')
  <h1 class="text-danger">@lang('errors.400.code')</h1>
  <h3 class="text-uppercase">@lang('errors.400.text')</h3>
  <p class="text-muted m-t-30 m-b-30">@lang('errors.400.description')</p>
@endsection
