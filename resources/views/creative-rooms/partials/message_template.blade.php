<!--by dk Mor-->
	@php
	$message_user_photo = url('/images/user.png');
	if (strpos($message->user_photo, 'http') !== false) {
	    $message_user_photo = $message->user_photo;
	}

	if (!empty($message->user_photo)) {
	    $message_user_photo = Storage::disk('s3')->url(ltrim($message->user_photo, "/"));
	}
	@endphp
<!--end by dk Mor-->
<div class="margin-15 {{ $message->user_id == Auth::user()->id ? '' : '' }}">
<div class="avata_message">
	<img src="{{ $message_user_photo }}" class="user-image">
</div>

<div class="message-container">
	<h5>{{ mb_strimwidth($message->user_name, 0, 24, "...") }}

	</h5>
	<span class="content">
	{!! nl2br($message->message) !!}
	</span>
	<span class="text-muted date_mes">{{ $message->created_at->format('Y/m/d') }}</span>
	@if ($attachments = $message->files)
	@foreach ($attachments as $file)
		<a href="{{ $file['path'] }}" download>{{ $file['name'] }}</a>
		@if (isset($file['thumb']))
		<img src="{{ $file['thumb'] }}" alt="{{ $file['name'] }}" title="{{ $file['name'] }}" class="preview-attach-l">
		@endif
		<br>

	@endforeach
	@endif
</div>
</div>
