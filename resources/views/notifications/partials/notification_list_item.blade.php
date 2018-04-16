<div class="list-group-item ui-del-parent">
  <div class="list-group-item-heading">
    <div class="text-muted text-right">
      <small>{{$notification->created_at->format('Y/n/j G:i ')}}</small>
      <span roll='button'
            class="glyphicon glyphicon-remove-sign ui-del-info"
            data-target="{{ url('notifications/' . $notification->id) }}"></span>
    </div>
    <h4>
      {!!nl2br($notification->title)!!}
    </h4>
  </div>
  <p class="list-group-item-text">{!!nl2br($notification->message)!!}</p>
</div>
