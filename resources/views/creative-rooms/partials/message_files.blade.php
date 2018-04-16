<h4 class="text-uppercase">@lang('creative_rooms.show.download_file')</h4>
<ul class="l-chat-room" data-id="{{$id}}" id="message-file">
@foreach ($files as $file)
	<li>
	@if ($file->thumb_path)
		<div class="box-img">
			<img src="{{ $file->thumb_path }}" alt="{{ $file->title }}" title="{{ $file->title }}">
		</div>
	@endif
	<a target=_blank href="{{ $file->path }}" download="{{ $file->title }}">{{ $file->title }}</a> <br/>
	<a>{{$file->created_at}}</a> 
	
	@can ('delete', $file)
		<span class="ui-del-file" data-id="{{ $file->id }}"><i class="fa fa-times-circle-o"></i></span>
	@endcan
	<div class="clearfix"></div>
	</li>
@endforeach
</ul>

{{ $files->render() }}

<style>
ul.pagination li span {
	right: inherit;
	top: inherit;
	position: inherit;
}
#files_list .l-chat-room h4{
	display: none;
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('#files_list').crluoPagenationNonFormUpdate({
			dest: '#content-files_list',
			id: $('.l-chat-room').attr('data-id')
		});
	})
</script>
