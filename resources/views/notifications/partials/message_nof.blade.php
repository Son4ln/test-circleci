@if ($notifications->count())
  <li>
    <div class="drop-title">You have {{ $notifications->count() }} new messages</div>
  </li>
  @foreach ($notifications as $notification)
    <li>
      <div class="message-center">
        <a href="{{ $notification->data['link'] }}">
          <div class="user-img"> <img src="{{ isset($notification->data['photo']) ? $notification->data['photo'] : '' }}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
          <div class="mail-contnet">
            <h5>{{ isset($notification->data['name']) ? $notification->data['name'] : '' }}</h5>
            <span class="mail-desc">{{ $notification->data['message'] }}</span> <span class="time">{{ $notification->created_at->format('m/d H:i') }}</span>
          </div>
        </a>
      </div>
    </li>
  @endforeach
    {{-- <li>
      <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
    </li> --}}
@else
  <li>
    <div class="drop-title">お知らせはありません</div>
  </li>
@endif
