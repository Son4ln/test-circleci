@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('creative_rooms.create.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="row">
      <div class="col-md-10 col-sm-12">
        @can ('create', \App\CreativeRoom::class)
          <div class="form-group text-center">
            @lang('creative_rooms.create.message')
          </div>
          {{ Form::open(['url' => 'creative-rooms', 'method' => 'post', 'class' => 'form-horizontal']) }}
          <div class="form-group {{ $errors->has('title') ? 'has-error' : ''  }}">
            <label class="control-label col-md-2">@lang('creative_rooms.create.name')</label>
            <div class="col-md-10">
              {{ Form::text('title', null, ['class' => 'form-control']) }}
              @if ($errors->has('title'))
                <div class="text-danger">
                  {{ $errors->first('title') }}
                </div>
              @endif
            </div>
          </div>

          <div class="form-group {{ $errors->has('desc') ? 'has-error' : ''  }}">
            <label class="control-label col-md-2">@lang('creative_rooms.create.description')</label>
            <div class="col-md-10">
              {{ Form::textarea('desc', null, ['class' => 'form-control']) }}
              @if ($errors->has('desc'))
                <div class="text-danger">
                  {{ $errors->first('desc') }}
                </div>
              @endif
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2"></label>
            <div class="col-md-10">
              <button class="btn btn-info">@lang('creative_rooms.create.submit')</button>
            </div>
          </div>
          {{ Form::close() }}
        @else
          <div class="alert alert-danger alert-dismissable">
            <button class="close" data-dismiss="alert" aria-label="close">×</button>
            @lang('flash_messages.rooms.room_limit')
          </div>
        @endcan
      </div>
    </div>
  </div>
@endsection
