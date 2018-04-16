<div class="flexable padding-15 message_hover {{ $message->user_id == Auth::user()->id ? '' : '' }}">
  <img src="{{ $message->user->photoUrl }}" class="user-image">
  <div class="message-container">
    <h5>{{ mb_strimwidth($message->user->name, 0, 24, "...") }}
      &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-muted">{{ $message->created_at->format('Y/m/d') }}</span>
    </h5>
    <span class="content">
      {!! nl2br($message->message) !!}
    </span>
  </div>
</div>
