 var signatureEndPoint = '/s3';
var successEndPoint = '/s3/success';

var thumbnailScaleRatio = 0.5;
var globalFileName = 'thumbnail.png';
var types = [];
types[1] = "file";
types[2] = "preview";
types[3] = "deliver";

var lastSubmitID;
var currentType;
var startTime = 0;
var endTime = 0;
var resultTime = 0;
var fileNameSuccess = '';
$.fn.dropFile = function(options) {
    return $(this).each(function() {
        var self = $(this);

        let allowedExtensions  = [];
        if (options.allows) {
            allowedExtensions = options.allows;
        }
        var validation = {
            allowedExtensions: allowedExtensions,
            sizeLimit: 5368709120
        };

        if (options.zip == true) {
            validation.allowedExtensions.push('zip');
        }

        if (!options.validation) {
            validation = {};
        }

        var uploader = new qq.s3.FineUploader({
            element: document.getElementById(self.prop('id')),
            autoUpload: false,
            request: {
                //endpoint: 'https://' + bucketName + '.' + 's3' + '-' + region + '.amazonaws.com',
                endpoint:'https://'+bucketName+'.s3-accelerate.amazonaws.com',
                //endpoint:'crluo-dev.s3.dualstack.ap-northeast-1.amazonaws.com',
                accessKey: accessKey,
                // secretKey: secretKey,
            },
            chunking:{
                partSize:5242880*4
            },
            autoUpload: false,
            signature: {
                endpoint: signatureEndPoint + '?room=' + $('#creativeroom_id').val(),
                customHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            uploadSuccess: {
                endpoint: successEndPoint,
                params : {
                    fileName : function(){
                        return fileNameSuccess;
                    }
                }
            },
            objectProperties: {

                key: function(uuid) {
                   
                    var path =  options && options.prefix
                    ? options.prefix + uploader.getName(uuid)
                    : uploader.getName(uuid);
        
                    var fileName = '' ;
                    fileName = path.split('/').slice(-1)[0] ;
                    var now = Date.now();

                    var name = fileName;
                    var nameArr = name.split('.');
                    var temp = '';
                    for(var i =0;i<nameArr.length-1;i++){
                        temp += '.'+nameArr[i]+'.';
                    }

                    var temp1 = temp.replace('.','')+'_'+userId+'_'+now;
                    temp1 += '.'+nameArr.slice(-1)[0];
                    
                    var newName = temp1;   
                    path = path.replace(fileName,newName);
                   
                    return path;
                    /* return options && options.prefix
                        ? options.prefix + uploader.getName(uuid)
                        : uploader.getName(uuid); */
                },
                acl: 'public-read',
            },
            validation: validation,
            messages: {
                sizeError: messages.size_limit
            },
            callbacks: {
                onError: function(id, name, errorReason, xhr) {
                    if (id == null) {
                        return;
                    }
                    if (messages) {
                        $('#error .alert').text(messages.upload_limit);
                    }
                    $('#error').modal('show');
                },
                onComplete: function(id, name, responseJson) {
                    var file = uploader.getFile(id);
                   // name = fileNameSuccess;
                    $('input[name="kind"]', '#file_upload').val(options.type);
                    if (file.type.indexOf('zip') != -1 || /\.mov$/i.test(file.name)) {
                        $('input[name="title"]', '#file_upload').val(name);
                        $('input[name="mime"]', '#file_upload').val(file.type);
                        $('input[name="path"]', '#file_upload').val(responseJson.tempLink);
                        return;
                    }
                    if (id == 0 && /^image/.test(file.type)) {
                        $('input[name="title"]', '#file_upload').val(name);
                        $('input[name="mime"]', '#file_upload').val(file.type);
                        $('input[name="path"]', '#file_upload').val(responseJson.tempLink);
                        $('input[name="thumb_path"]', '#file_upload').val(responseJson.tempLink);
                        return;
                    }
                    if (isVideo(file) || options.allowAll) {
                        $('input[name="title"]', '#file_upload').val(name);
                        $('input[name="mime"]', '#file_upload').val(file.type);
                        $('input[name="path"]', '#file_upload').val(responseJson.tempLink);
                    } else {
                        $('input[name="thumb_path"]', '#file_upload').val(responseJson.tempLink);
                    }
                },
                onSubmitted: function(id) {
                    if(startTime == 0){
                        
                        startTime = Math.round((new Date()).getTime() / 1000);
                    }
                    $('#progress_screen').fadeIn();
                    $('#progress_text').html('Validating your request..! ' + '<i class="fa fa-refresh fa-spin fa-fw"></i>');
                    $('.progress-bar', '#progress_screen').css({width: 0});
                    var file = uploader.getFile(id);
                    if (!options.thumbnail || file.type.indexOf('zip') != -1 || /\.mov$/i.test(file.name)) {
                        uploader.uploadStoredFiles();
                        return;
                    }

                    if (/^image/.test(file.type)) {
                        uploader.uploadStoredFiles();
                        return;
                    }
                    if (isVideo(file)) {
                        globalFileName = uploader.getName(id) + '.png';
                        // TODO Upload files when canvas was created
                        var fileUrl = window.URL.createObjectURL(file);
                        $(options.source).attr("src", fileUrl);
                        video.on('seeked', function() {
                            uploader.addFiles ({
                                canvas: makeCanvas(video.get(0)),
                                name: globalFileName,
                                quality: '60',
                                type: 'image/png'
                            });
                            video.off('seeked');
                            video.attr("src", '');
                        })
                    }
                },
                onAllComplete: function(succeeded, failed) {
                    endTime = Math.round((new Date()).getTime() / 1000);
                    resultTime = endTime - startTime ;
                    console.log( 'resultTime', resultTime );
                    startTime = 0;
                    $('#progress_text').html('Upload completed with: ' + succeeded.length + ' success, ' + failed.length + ' failed! <br> Please waiting for reload page!');
                    submitFile(types[options.type], options.replace);
                    uploader.clearStoredFiles();
                },
                onProgress: function(id, name, uploadedBytes, totalBytes) {
                    var currentProgress = Math.round((uploadedBytes * 100) / totalBytes);
                    $('.progress-bar', '#progress_screen')
                        .css({width: currentProgress + '%'});
                    $('#progress_text').text('Uploading... ' + name + ' - ' + currentProgress + '%');
                }
            }
        });

        var video = $(options.source);

        // TODO Forward to video half video
        video.on('canplay', function() {
            if (this.duration) {
                this.currentTime = this.duration / 2;
            }
        });
    });
};

function isVideo(file)
{
    return /^video/.test(file.type);
}

var mainFileNotChange = true;

// Portfolio fine uploader upload
$(document).ready(function() {
    var element = document.getElementById('temp');

    var config = {
        element: document.getElementById('temp'),
        autoUpload: false,
        request: {
            endpoint: 'https://' + bucketName + '.' + 's3' + '-' + region + '.amazonaws.com',
            accessKey: accessKey,
            // secretKey: secretKey,
        },
        validation: {
            allowedExtensions: ['png', 'jpg', 'mp4', 'webM'],
            sizeLimit: 5368709120
        },
        messages: {
            sizeError: messages.size_limit
        },
        // autoUpload: false,
        signature: {
            endpoint: signatureEndPoint,
            customHeaders: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        uploadSuccess: {
            endpoint: successEndPoint
        },
        objectProperties: {
            key: function(uuid) {
                return 'portfolios/' + $('input[name="user_id"]').val() + '/' +puploader.getName(uuid);
            },
            acl: 'public-read'
        },
        callbacks: {
            onSubmitted: function(id, name) {
                var file = puploader.getFile(id);
                lastSubmitID = id;
                if (/^video/.test(file.type)) {
                    $('#preview').removeClass('hidden');
                    $('#preview').get(0).src = window.URL.createObjectURL(file);
                    globalFileName = name + '.png';
                }
                if (id == 0 && /^image/.test(puploader.getFile(id).type)) {
                    var promise = puploader.drawThumbnail(id, document.getElementById('canvas'), 200);
                    promise.done(function(e) {
                        puploader.addFiles ({
                            canvas: document.getElementById('canvas'),
                            name: 'thumnail_' + name,
                            type: 'image/png'
                        });
                    });
                }
            },
            onComplete: function(id, name, responseJson) {
                if (mainFileNotChange) {
                    $('input[name="thumb_path"]').val(responseJson.tempLink);
                    return;
                }
                if (id == 0) {
                    $('input[name="url"]').val(responseJson.tempLink);
                    $('input[name="mime"]').val(puploader.getFile(id).type);
                } else {
                    $('input[name="thumb_path"]').val(responseJson.tempLink);
                }
            },
            onProgress: function(id, name, uploadedBytes, totalBytes) {
                var currentProgress = Math.round((uploadedBytes * 100) / totalBytes);
                $('.progress-bar', '#progress_screen')
                    .css({width: currentProgress + '%'});
                $('#progress_text').text('Uploading... ' + name + ' - ' + currentProgress + '%');
            },
            onAllComplete: function() {
                $('#portfolioform').submit();
                $('#progress_text').text('Please wait...!');
            }
        }
    };
    if(document.getElementById('l-flag-mov') != null){
        config.validation.allowedExtensions.push('mov');
        //config.validation.allowedExtensions.push('wmv');
    }
    if (element) {
        var puploader = new qq.s3.FineUploader(config);
    }

    $('#file_limit button').click(function() {
        $(this).parent().fadeOut();
    });

    $(document).on('change', '#file_selection', function(e) {
        puploader.reset();
       
        $('input[name="validation"]').val('');
        if (this.files && /^video/.test(this.files[0].type)) {
            $('input[name="validation"]').val('yes');
            $('input[name="validation"]').siblings('.parsley-errors-list').remove();
            
            puploader.addFiles(this.files[0]);
            
            var video = $('#preview');
            // TODO Forward to video half video
            video.one('canplay', function() {
                if (this.duration) {
                    this.currentTime = 0.5;
                }
            });

            video.on('seeked', function() {
                var canvas = makeCanvas(video.get(0));
                puploader.addFiles ({
                    canvas: canvas,
                    name: globalFileName,
                    quality: '60',
                    type: 'image/png'
                });
                $('#thumbnail-preview').attr('src', canvas.toDataURL());
                $('.control').removeClass('hidden');
                // $('#progress_screen').fadeIn()
                // $('#progress_text').html('Validating your request..! ' + '<i class="fa fa-refresh fa-spin fa-fw"></i>')
                // $('.progress-bar', '#progress_screen').css({width: 0})
                video.off('seeked');
                video.get(0).pause();
            })
            mainFileNotChange = false;
        }

        if (this.files && /^image/.test(this.files[0].type)) {
            $('input[name="validation"]').val('yes');
            $('input[name="validation"]').siblings('.parsley-errors-list').remove();
            puploader.addFiles(this.files[0]);
            $('#thumbnail-preview').get(0).src = window.URL.createObjectURL(this.files[0]);
            $('#preview').addClass('hidden');
            $('.control').addClass('hidden');
            $('input[name="thumb_path"]').val('');
            mainFileNotChange = false;
        }

        $('#file_selection').val('');
    })

    $(document).on('click', '#recreate', function() {
        $('#preview').crossOrigin = '*';
        if (lastSubmitID) {
            puploader.cancel(lastSubmitID);
        }
        $('#hidden_file').val('');
        var canvas = makeCanvas($('#preview').get(0));
        $('#thumbnail-preview').attr('src', canvas.toDataURL());
        puploader.addFiles ({
            canvas: canvas,
            name: globalFileName,
            quality: '60',
            type: 'image/png'
        });
    });

    $(document).on('change', '#hidden_file', function() {
        if (this.files && /^image/.test(this.files[0].type)) {
            var file = this.files[0];
            $('#thumbnail-preview').attr('src', window.URL.createObjectURL(file))
            if (lastSubmitID) {
                puploader.cancel(lastSubmitID);
            }
            if (mainFileNotChange) {
                puploader.addFiles(file);
                return;
            }
            puploader.addFiles ({
                blob: file,
                name: globalFileName,
                type: 'image/png'
            });
        }
    });

    $(document).on('submit', '#portfolioform', function(e) {
        if (puploader.getUploads({status: qq.status.SUBMITTED}).length > 0) {
            e.preventDefault();
            puploader.uploadStoredFiles();
            $('#progress_screen').fadeIn();
            $('#progress_text').html('Validating your request..! ' + '<i class="fa fa-refresh fa-spin fa-fw"></i>');
            $('.progress-bar', '#progress_screen').css({width: 0});
        }
    });
});

if ($('#change_thumbnail').length > 0) {
    let $img = new Image();
    $img.crossOrigin = "anonymous";
    $img.src = $('#change_thumbnail').val();
    $img.onload = function() {
        puploader.addFiles ({
            canvas: convertImgToCanvas($img),
            name: getLastSegment($('#change_thumbnail').val()),
            type: 'image/png'
        });
        setTimeout(function() {
            puploader.cancel(0);
        }, 500);
    }
}

function getLastSegment(url)
{
    let array = url.split('/');

    return array[array.length - 1];
}

function convertImgToCanvas(element){
    var myCanvasElement = document.getElementById('canvas');
    myCanvasElement.height = element.height;
    myCanvasElement.width = element.width;
    // don't forget to add it to the DOM!!
    var context = myCanvasElement.getContext('2d');
    context.drawImage(element, 0, 0);
    // remove the image for the snippet
    return myCanvasElement;
}

/**
 * Make canvas image from video
 *
 * @param element video
 * @return canvas
 */
function makeCanvas(video)
{
    var filename = video.src;
    var w = video.videoWidth * thumbnailScaleRatio;//video.videoWidth * scaleFactor;
    var h = video.videoHeight * thumbnailScaleRatio;//video.videoHeight * scaleFactor;
    var canvas = document.createElement('canvas');
    canvas.width = w;
    canvas.height = h;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, w, h);

    return canvas;
}

function submitFile(type, replace)
{
    var url = '/files/upload/' + type;
    var form = $('#file_upload');
    $.ajax({
        type: 'POST',
        url: url,
        data: form.serialize(),
        success: function(response) {
            $(replace).html(response);
        },
        complete: function() {
            $('#progress_screen').fadeOut();
            if (type == 'preview') {
                var url = '/files/preview/' + $('#creativeroom_id').val();
                $.get(url, function(response) {
                    $('.compare-list').html(response);
                });
            }
        }
    });
}
