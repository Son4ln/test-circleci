
@php
function checkDownload(){
    $rs = false;
    if(auth()->user()->isAdmin() || auth()->user()->isCreator() || auth()->user()->isCertCreator() || auth()->user()->isAdClient() || auth()->user()->isActivatedCreator() || auth()->user()->isNotActivatedCreator()){
		$rs = true;
    }
	return $rs;
}
@endphp
@if (count($errors) > 0)
<div class="alert alert-danger">
	<strong>エラー</strong><br>
	@foreach ($errors->all() as $error)
	{{ $error }}<br>
	@endforeach
</div>
@endif
@php
$rs = checkDownload();
@endphp
<div id="preview_upload" class="block-inline  uploader-not-display"></div>

@foreach ($files as $file)
<div class="btn btn-black ui-preview-movie movie-drag"
data-fileid='{{ $file->id }}' data-procname="{{ $file->path }}"
data-toggle="tooltip" data-placement="top" title="{{ $file->title }}"
role="button" draggable="true">
	<div>
	<img src="{{ $file->thumb_path }}"
	onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='">
	<span> {{ date('Y/m/d h:i', strtotime($file->created_at)) }} </span>
	</div>
	<div class="dropdown video-menu hide">
	<button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">
		<i class="fa fa-ellipsis-v"></i>
	</button>
	
	<ul class="dropdown-menu">
		@if( (!auth()->user()->isClient() || auth()->user()->isAdmin() ) && $rs)
		<li><a href="{{ s3UrlDownloadGenerator($file->path) }}" download="{{ $file->title }}">ダウンロード</a></li>
		@endif
		@can ('delete', $file)
		<li><a href="javascript:void(0)" class="ui-del-preview" data-id="{{ $file->id }}">動画削除</a></li>
		@endcan
	</ul>
	</div>
</div>

@endforeach

<script>
$(document).ready(function() {
	$( ".video-menu" ).each(function( index,_elelment ) {
		var e = $(_elelment);
		if(e.find('ul.dropdown-menu li').length==0){
			e.remove();
		}
	});

$('#preview_upload').dropFile({
	source: '#video',
	type: 2,
	replace: '.ui-preview-list',
	thumbnail: true,
	allows: ['mp4', 'mov'],
	validation: true,
	prefix: 'previews/' + $('#creativeroom_id').val() + '/',
});
$('#preview_upload_1').dropFile({
	source: '#video',
	type: 2,
	replace: '.ui-preview-list',
	thumbnail: true,
	allows: ['mp4', 'mov'],
	validation: true,
	prefix: 'previews/' + $('#creativeroom_id').val() + '/',
});
$('#preview_upload_2').dropFile({
	source: '#video',
	type: 2,
	replace: '.ui-preview-list',
	thumbnail: true,
	allows: ['mp4', 'mov'],
	validation: true,
	prefix: 'previews/' + $('#creativeroom_id').val() + '/',
});
});
</script>


