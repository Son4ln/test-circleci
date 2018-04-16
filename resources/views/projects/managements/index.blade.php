@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('project_states.list.title')</h4>
  </div>
  <a href="{{ route('admin.projects.create') }}" class="pull-right" style="margin-right: 15px">
    <button type="button" class="btn btn-primary">@lang('project_states.list.create')</button>
  </a>
@endsection

@section('content')
  @php
    $statuses = config('const.project_status');
    $statuses = ['' => '全て'] + $statuses;
    unset($statuses[0]);
  @endphp
  <div class="custom-breadcrumbs">
    @php $currentStatus = request()->status or ''  @endphp
    @foreach ($statuses as $index => $status)
      <a class="arrow-breadcrumb {{ $index == $currentStatus ? 'active' : '' }} status-{{ $index }}" href="{{ route('project-states.index', ['status' => $index], false) }}">
        {{ $status }}
      </a>
    @endforeach
  </div>
  <div id="project_list" class="white-box">
    @include('projects.managements.projects_list')
  </div>

@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#project_filter').crluoFormInputSearch({dest: '#project_list'});
    });
  </script>
@endpush

@push('styles')
  {{ Html::style('css/breadcrump.css') }}
@endpush
