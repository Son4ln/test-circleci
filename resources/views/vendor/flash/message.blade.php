<?php
function flashLevelIcon($level) {
  switch ($level) {
    case 'success':
      return 'check-circle';
    case 'warning':
      return 'exclamation-circle';
    case 'error':
      return 'times-circle';
    case 'info':
    default:
      return 'info-circle';
  }
}
?>

@if (session()->has('flash_notification'))
  @foreach(session('flash_notification') as $message)
    @if ($message['overlay'])
      @include('flash:modal', [
          'modalClass' => 'flash-model',
          'title'      => $message['title'],
          'body'       => $message['message'],
      ])
    @else
      <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }}"
           role="alert">
        @if ($message['important'])
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @endif
        <span class="fa fa-{{flashLevelIcon($message['level'])}}"></span>
        {!! $message['message'] !!}
      </div>
    @endif
  @endforeach
@endif
@php session()->forget('flash_notification') @endphp
