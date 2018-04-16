@if ($messages->first())
  <input type="hidden" id="last_message" value="{{ $messages->first()->id }}">
@endif

@foreach ($messages as $message)
  @include('admin.rooms.partials.single_message')
@endforeach
