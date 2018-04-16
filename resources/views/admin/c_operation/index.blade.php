@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.c_operation.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <table class="table">
      <tr>
        <th>@lang('admin.c_operation.user_name')</th>
        <th>@lang('admin.c_operation.email')</th>
        <th>@lang('admin.c_operation.end_at')</th>
        <th>@lang('admin.c_operation.created_at')</th>
        <th></th>
      </tr>
      @foreach ($users as $user)
        <tr>
          <td rowspan="{{ $user->subscriptions()->count() }}">{{ $user->name }}</td>
          <td rowspan="{{ $user->subscriptions()->count() }}">{{ $user->email }}</td>
          @foreach ($user->subscriptions as $subscription)
            @if (!$loop->first)
            <tr>
            @endif
              <td>{{ $subscription->ends_at ? $subscription->ends_at->format('Y/m/d') : '' }}</td>
              <td>{{ $subscription->created_at->format('Y/m/d') }}</td>
              <td>
                @if ($subscription->ends_at == NULL)
                  {{ Form::open([
                    'url' => route('admin.c_operation.destroy', ['id' => $user->id]),
                    'method' => 'DELETE',
                    'onsubmit' => 'return confirm("'. __('admin.c_operation.confirm_cancel') .'")'])
                  }}
                    <button class="btn btn-info btn-xs cancel-plan">@lang('admin.c_operation.cancel')</button>
                  {{ Form::close() }}
                @endif
              </td>
            @if (!$loop->first)
            </tr>
            @endif
          @endforeach
        </tr>
      @endforeach
    </table>
    {{ $users->render() }}
  </div>
@endsection
