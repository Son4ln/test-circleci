<?php
$method = Request::method();
?>
<div id="deliver_upload" class="block-inline uploader-not-display">
</div>
@foreach ($files as $file)
<span class="l-selected-download" href="javascript:;" data-id='{{ $file->id }}'  data-href="{{ $file->path }}">
	<div  class="delivery file" >
		<div class="delivery-cog">
		<div></div>
		</div>
		<i class="glyphicon glyphicon-trash ui-del-deliver" data-id='{{ $file->id }}'></i>
		<!-- <a class="delivery-content" download="{{ $file->title }}" href="{{ s3DownloadUrl($file) }}" title="{{ $file->title }}"> -->
		<a class="delivery-content file_ext_{{str_replace(array('video/','image/'),array('',''),$file->mime)}}" data-href="{{ s3DownloadUrl($file) }}"  href="javascript:;" title="{{ $file->title }}">
		<span class="file_icon file_ext_{{str_replace(array('video/','image/'),array('',''),$file->mime)}}"></span><span class="file_title">{{ $file->title }}</span>
		</a>
	</div>
</span>
@endforeach

<script type="text/javascript">
$(document).ready(function() {
$('#deliver_upload').dropFile({
	source: '#video',
	type: 3,
	replace: '.ui-deliver-list',
	thumbnail: true,
	validation: true,
	allows: ['mp4', 'webM', 'png', 'jpeg', 'jpg', 'mov'],
	prefix: 'files/' + $('#creativeroom_id').val() + '/',
	zip: true
});
});
</script>
@if($method === 'POST')
<style>
	.ui-deliver-list div:nth-child(2) span{
		color:#585858 !important;
	}
</style>
@endif


	