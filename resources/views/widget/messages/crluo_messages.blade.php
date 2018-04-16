@if ($messages->first())
  <input type="hidden" id="last_crluo_message" value="{{ $messages->first()->id }}">
@endif

@foreach ($messages as $message)
  <div class="flexable bottom-space {{ $message->user_id == Auth::user()->id ? 'self' : 'others' }}">
    <img class="user-image" src="{{ $message->user->photoUrl }}" alt="{{ $message->user->name }}"
           onerror="this.src='/images/user.png'">
    <div class="message-container">
      <div class="message-content">
        {!! nl2br($message->message) !!}
      </div>
      <div class="message-user-info">
        {{ $message->user_id == Auth::user()->id ? "" : mb_strimwidth($message->user->name, 0, 24, "...") }} {{ $message->created_at }}
      </div>
    </div>
  </div>
@endforeach
{{-- <div class='ui-page-info'>
    {!! $infos->render() !!}
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.ui-page-info').crluoPagenationNonForm({
            dest: '#crluo-messages',
            creativeroom_id: $('#creativeroom_id').val()
        });
    })
</script> --}}
