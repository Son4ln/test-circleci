@extends('layouts.ample')

@section('content')
    @include('dashboards.admin')
@endsection

{{-- Push scripts to admin panel --}}
@push('scripts')
  <script>
    $(document).ready(function () {
      $('#adminmessageform').crluoFormInputSearch({dest: '#admin-message-list'});
      $('#formSearchDoc').crluoFormInputSearch({dest: '#document-list'})
      /* modal dialog */
      $('span[data-toggle="modal"]', '.admin-user-list-table').click(function () {
        $('.modal-title', '#modalWindow').html($(this).attr('data-title'));
        $('div.modal-body', '#modalWindow').load($(this).attr('data-procname'));
      });
      $('button.admin-user-enable-btn', '.admin-user-list-table').click(function () {
        var $parent = $(this).parent();
        var $btn = $(this).button('loading');
        var $div = $('#loading').fadeIn();
        //$.ajaxSetup({ async: false });
        var $data = {'_token': '{{{ csrf_token() }}}', 'id': $(this).attr('data-id')};
        $.ajax({
          url: "/admin/user/enable",
          data: $data,
          type: "post",
          dataType: "html",
          success: function (data) {
            $parent.html('有効');
            $div.fadeOut();
          },
          error: function (xhr, status) {
            console.log(xhr);
            $('#loading').html(xhr.responseText);
          },
          complete: function (xhr, status) {
            $btn.button('reset');
          }
        });
      });

      $('#admin-user-list').load('/users/filter', {
        kind: 1,
        enabled: 0,
        name: ''
      })

      $('#adminuserform').crluoFormInputSearch({dest: '#admin-user-list'});

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

      $(document).on('click', '.active-creator', function() {
        var id = $(this).data('id')
        var el = $(this)
        $('#loading').fadeIn()
        $.ajax({
          url: 'creators/active',
          type: 'POST',
          data: {
            id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function() {
            el.replaceWith('有効')
          },
          complete: function() {
            $('#loading').fadeOut()
          }
        })
      })
    })
  </script>
@endpush
