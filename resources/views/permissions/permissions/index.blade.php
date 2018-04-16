@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('permissions.permissions.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="box-header with-border">
      <a href="{{ route('set-permissions.index') }}" class="btn btn-primary">Set permissions</a>
      <a href="{{ route('roles.index') }}" class="btn btn-primary">List roles</a>
      <a href="{{ route('roles.create') }}" class="btn btn-primary">Create role</a>
    </div>
    <div class="box-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>#ID</th>
          <th>@lang('permissions.permissions.fields.name')</th>
          <th>@lang('permissions.permissions.fields.description')</th>
          <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        @forelse ($permissions as $permission)
          <tr>
            <td style="text-align: center">{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->description }}</td>
            <td>
              <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-info">
                @lang('permissions.app_edit')
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4">@lang('permissions.app_no_entries_in_table')</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="box-footer">{{ $permissions->links() }}</div>
  </div>
@endsection

@push('styles')
  <style>
    .pagination {
      margin: 0
    }
  </style>
@endpush
