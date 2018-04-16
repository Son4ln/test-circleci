$(document).ready(function() {
    var signatureEndPoint = '/s3'
    var successEndPoint = '/s3/success'

    var bucketName = 'crluo-dev'
    var region = 'ap-northeast-1'
    var accessKey = 'AKIAJMPCJ6L42LGSDT3Q'
    var secretKey = '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'
    var lastSubmitID;
    var currentType;

    let uploader = new qq.s3.FineUploader({
        element: document.getElementById('temp'),
        autoUpload: false,
        request: {
            //endpoint: 'https://' + bucketName + '.' + 's3' + '-' + region + '.amazonaws.com',
            endpoint:'https://'+bucketName+'.s3-accelerate.amazonaws.com',
            accessKey: accessKey,
            secretKey: secretKey,
        },
        validation: {
            allowedExtensions: ['png', 'jpg', 'mp4', 'webM']
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
        chunking:{
            partSize:5242880*4
        },
        objectProperties: {
            key: function(uuid) {
                return options && options.prefix
                    ? options.prefix + uploader.getName(uuid)
                    : uploader.getName(uuid)
            },
            acl: 'public-read'
        },
        callbacks: {
            onSubmitted: function(id, name) {
                let file = uploader.getFile(id)
                lastSubmitID = id
                if (/^video/.test(file.type)) {
                    $('#preview').removeClass('hidden')
                    $('#preview').get(0).src = window.URL.createObjectURL(file)
                    uploader.addFiles ({
                        canvas: makeCanvas(video.get(0)),
                        name: name + '.png',
                        quality: '60',
                        type: 'image/png'
                    });
                }
            }
        }
    })

    $(document).on('change', '#file_selection', function(e) {
        uploader.reset()
        if (this.files) {
            uploader.addFiles(this.files[0])
        }
    })

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

})
