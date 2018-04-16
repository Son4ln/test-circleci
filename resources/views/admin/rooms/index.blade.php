@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.rooms.list.title')</h4>
  </div>
@endsection

@section('content')
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table table-bordered">
        <tr>
          <th>@lang('admin.rooms.list.name')</th>
          <th>@lang('admin.rooms.list.member')</th>
          <th>@lang('admin.rooms.list.action')</th>
        </tr>
        @foreach ($rooms as $room)
          @php
            $users = $room->roomUsers->pluck('name');
          @endphp
          <tr>
            <td>{{ mb_strimwidth($room->title, 0, 30, "...") }}</td>
            <td>{{ mb_strimwidth(implode(', ', $users->all()), 0, 30, "...") }}</td>
            <td>
              <a href="{{ route('admin.rooms.show', ['id' => $room->id]) }}">
                <button class="btn btn-primary">@lang('admin.rooms.list.detail')</button>
              </a>
            </td>
          </tr>
        @endforeach
      </table>
      <div class="table-pagination">
        {{ $rooms->render() }}
      </div>
    </div>
  </div>
@endsection
