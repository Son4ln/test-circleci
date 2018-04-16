@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('permissions.users.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="box-body table-responsive">
      <table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
          <th>@lang('permissions.users.fields.name')</th>
          <th>@lang('permissions.users.fields.email')</th>
          <th>@lang('permissions.users.fields.roles')</th>
          <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        @forelse($users as $user)
          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @foreach ($user->roles()->pluck('name') as $role)
                <span class="label label-info label-many">{{ $role }}</span>
              @endforeach
            </td>
            <td>
              @can('updateRoles', $user)
              <a href="{{ route('set-permissions.edit', $user->id) }}" class="btn btn-sm btn-info">
                @lang('permissions.set_roles')
              </a>
              @endcan
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
    <div class="box-footer">
      {{ $users->links() }}
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
