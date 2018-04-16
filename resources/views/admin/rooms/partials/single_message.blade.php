<div class="flexable bottom-space {{ $message->user_id == Auth::user()->id ? 'self' : 'others' }}">
  <img class="user-image" src="{{ $message->user->photoUrl }}" alt="{{ $message->user->name }}"
         onerror="this.src='/images/user.png'">
  <div class="message-container">
    <div class="message-content">
      {!! nl2br($message->message) !!}
      @if ($files = $message->files)
        @foreach ($files as $file)
          <a href="{{ $file['path'] }}" download>{{ $file['name'] }}</a>
        @endforeach
      @endif
    </div>
    <div class="message-user-info">
         {{ $message->user_id == Auth::user()->id ? "" : mb_strimwidth($message->user->name, 0, 24, "...") }} {{ $message->created_at }}
    </div>
  </div>
</div>
