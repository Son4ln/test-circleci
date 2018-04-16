@if ($messages->first())
  <input type="hidden" id="last_message" value="{{ $messages->first()->id }}">
@endif
@foreach ($messages as $message)
  @include('creative-rooms.partials.message_template', compact('message'))
@endforeach
