@extends('layouts.ample')
@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h1 class="page-title">@lang('creative_rooms.list.title')</h1>
</div>
@endsection
@section('content')
    <input type="file" name="photoupload" id="photoupload" />
    <button onclick="addPhoto('test')">upload file</button>
@endsection

@push('scripts')
	<script src="/js/aws-sdk-2.205.0.min.js" type="text/javascript"></script>
	<script>
        
        AWS.config.update({
			accessKeyId : 'AKIAJGTJMXIDP7F25OTQ',
			secretAccessKey : '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'
		});
        var bucketname = 'crluo-dev';
        //var bucket = new AWS.S3({params: {Bucket: bucketname}, endpoint : 's3-accelerate.amazonaws.com'});
        var bucket = new AWS.S3({params: {Bucket: bucketname}, endpoint : 's3-accelerate.dualstack.amazonaws.com'});
        //var bucket = new AWS.S3({params: {Bucket: bucketname}});
        function addPhoto(albumName) {
            var startTime = Math.round((new Date()).getTime() / 1000);

            var files = document.getElementById('photoupload').files;
            if (!files.length) {
                return alert('Please choose a file to upload first.');
            }
            var file = files[0];
            var fileName = file.name;
            var albumPhotosKey = encodeURIComponent(albumName) + '//';

           var params = {Key: 'luc_test/'+file.name, ContentType: file.type, Body: file};
			bucket.upload(params,{queueSize: 25,partSize: 1024 * 1024 * 5 }).on('httpUploadProgress', function(evt) {
                    console.log( ((evt.loaded * 100) / evt.total) + '%' );
			}).send(function(err, data) {
				var endTime = Math.round((new Date()).getTime() / 1000);
				var totalTimeUploadFile = endTime - startTime;
				console.log('totalTimeUploadFile ', totalTimeUploadFile);
				
			});
            
        }
	</script>
@endpush