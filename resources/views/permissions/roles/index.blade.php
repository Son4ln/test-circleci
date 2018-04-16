@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('permissions.roles.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="box-header with-border">
      <a href="{{ route('set-permissions.index') }}" class="btn btn-primary">Set permissions</a>
      <a href="{{ route('permissions.index') }}" class="btn btn-primary">List permissions</a>
      <a href="{{ route('roles.create') }}" class="btn btn-primary">@lang('permissions.app_add_new')</a>
    </div>
    <div class="box-body table-responsive">
      <table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
          <th>@lang('permissions.roles.fields.name')</th>
          {{--<th>@lang('permissions.roles.fields.description')</th>--}}
          <th>@lang('permissions.roles.fields.permission')</th>
          <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
          @forelse ($roles as $role)
            <tr>
              <td>{{ $role->name }}</td>
              {{--<td>{{ $role->description }}</td>--}}
              <td>
                @foreach ($role->permissions()->pluck('name') as $permission)
                  <span class="label label-info label-many">{{ $permission }}</span>
                @endforeach
              </td>
              <td>
                @can('update', $role)
                  <a class="btn btn-sm btn-default" href="{{ route('roles.edit', $role->id) }}">@lang('permissions.app_edit')</a>
                @endcan
                @can('delete', $role)
                  <a class="btn btn-sm btn-danger post-link"
                     data-confirm="{{ trans('このデータを削除しますか？') }}"
                     href="{{ route('roles.destroy', $role->id) }}">@lang('permissions.app_delete')</a>
                @endcan
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">@lang('permissions.app_no_entries_in_table')</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="box-footer">
      {{ $roles->links() }}
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
      padding: 0.5em;
    }
  </style>
@endpush
