@if ($notifications->count())
  <li>
    <div class="drop-title">You have {{ $notifications->count() }} new messages</div>
  </li>
  <li>
    @foreach ($notifications as $notification)
      @php $color = 'text-info' @endphp
      @isset($notification->data['type'])
        @if (substr($notification->data['type'], -1) == 1)
          @php $color = 'text-info' @endphp
        @else
          @php $color = 'text-danger' @endphp
        @endif
      @endisset
      <a href="{{ $notification->data['link'] }}">
        <i class="fa fa-users {{ $color }}"></i> {!! $notification->data['message'] !!}
      </a>
    @endforeach
  </li>
@else
  <li>
    <div class="drop-title">お知らせはありません</div>
  </li>
@endif

{{-- <li class="divider"></li>
<li>
  <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
</li> --}}
