@extends('layouts.ample')

@section('content-header')
  <!-- .page title -->
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('chat.title')</h4>
  </div>
  <!-- /.page title -->
@endsection

@section('content')
<section class="content">
  <div class="alert alert-info alert-dismissable" style="background:#f26361;border-color:#f26361">
    <i class="fa fa-info"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @lang('chat.alert_1')<br>
    @lang('chat.alert_2')
  </div>
  <div class="container-fluid ">
    <div class="col-md-3 col-sm-3">
      <div class="ui-chat-users list-group" role="group" aria-label="...">
        @foreach($members as $member)
          <button type="button" class="list-group-item " data-id='{{$member->user_id}}'>
            <strong>{{$member->name}}</strong>
            @if ($member->unread > 0)
            <span class="label label-success badge">{{$member->unread}}</span>
            @endif
          </button>
        @endforeach

      </div>
      <div class="">
        <br>
        <br>
      </div>
      <div class="alert alert-success alert-dismissable" style="background:#229393;border-color:#229393">
        <i class="fa  fa-question"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>@lang('chat.hint_title')</b> @lang('chat.hint_text')
      </div>
    </div>
    <div class="col-md-6 col-sm-6">
      <div id="user-chat-list">
        @isset ($messages)
          @include('widget.chat')
        @endisset
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
  <style media="screen">
    .media {
      border: 0;
    }
  </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.ui-chat-users').crluoDispChat({dest: '#user-chat-list'});
            var id = getParameterByName('user');
            if (!isNaN(id)) {
              $('[data-id="'+id+'"]').click();
            }
        });

        function getParameterByName(name, url) {
          if (!url) url = window.location.href;
          name = name.replace(/[\[\]]/g, "\\$&");
          var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
          results = regex.exec(url);
          if (!results) return null;
          if (!results[2]) return '';
          return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    </script>
@endpush
