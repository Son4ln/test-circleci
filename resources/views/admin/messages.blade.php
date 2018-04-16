@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.messages.header')</h4>
  </div>
@endsection

@section('content')
<div class="white-box">
  <div class='col-md-8'>
    @include('admin.partials.messages')
  </div>
  <div class='col-md-4'>
    @include('admin.partials.send_message')
  </div>
  <div class="clearfix"></div>
</div>
@endsection

{{-- Push scripts to admin panel --}}
@push('scripts')
  <script>
    $(document).ready(function () {
      $('#adminmessageform').crluoFormInputSearch({dest: '#admin-message-list'})

      $('#adminuserform').crluoFormInputSearch({dest: '#admin-user-list'})

      /* update dialog */
      $('#create-message').submit(function (e) {
        e.preventDefault()
        var form = $(this)
        var url = $(this).attr('action')
        var $btn = $(this).button('loading');
        var $div = $('#loading').fadeIn();
        //$.ajaxSetup({ async: false });
        $.ajax({
          url: url,
          data: form.serializeArray(),
          type: "post",
          dataType: "html",
          success: function (data) {
            $('input[name=title]', '#sendmesform').val("");
            $('textarea[name=message]', '#sendmesform').val("");
          },
          error: function (xhr, status) {
            console.log(xhr);
            $('div#error').html(xhr.responseText);
          },
          complete: function (xhr, status) {
            $btn.button('reset');
            $div.fadeOut();
          }
        });
        //$.ajaxSetup({ async: true });
      });
    })
  </script>
@endpush

@push('styles')
  <style media="screen">
    .panel-default {
      border: 1px solid #ddd;
    }
    .media {
      border: 0;
    }
  </style>
@endpush
