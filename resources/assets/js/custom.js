$(document).on('click', '.ui-preview-movie', function() {
    var self = $(this);
    self.addClass('bounce animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('bounce animated');
    });
});

$(document).on('mouseover', '.ui-preview-movie', function() {
    var self = $(this);
    self.find('div.video-menu').removeClass('hide');
});

$(document).on('mouseout', '.ui-preview-movie', function() {
    var self = $(this);
    self.find('div.video-menu').addClass('hide');
});

$('#compare').on('click', function() {
    $('#video-1').attr('src', $('#movie-1').data('src'));
    $('#video-2').attr('src', $('#movie-2').data('src'));

    var videoName1 = $("div[data-procname|='"+$('#movie-1').data('src')+"']").data('original-title');
    var videoName2 = $("div[data-procname|='"+$('#movie-2').data('src')+"']").data('original-title');
    $('.l-video-name-1').text(videoName1);
    $('.l-video-name-2').text(videoName2);

    if ($('#movie-1').data('src') != undefined && $('#movie-2').data('src') != undefined) {
        $('#compare-modal').modal('show');
    } else {
        alert(messages.not_enough);
    }
});

$('#compare-modal').on('hidden.bs.modal', function () {
    $('#video-1').attr('src', "");
    $('#video-2').attr('src', "");
});

$(window).on('load', function () {
    var globalCaptions = [];
    var duration = '';

    $(window).on('resize', function() {
        $('#pv-draw').height($('#pv-video').height());
        $('#pv-caption').width($('#pv-video').width());
        $('#pv-draw').width($('#pv-video').width());
        $('#pv-caption').css('left', $('#pv-video').position().left);
        $('#pv-draw').css('left', $('#pv-video').position().left);
    });

    $('span.ui-del-message').click(function () {
        ret = $.crluo.ajax_sync('/ajax/work/message',
        {
            'del_id': $(this).attr('data-id'),
            'creativeroom_id': $('#creativeroom_id').val()
        });
        $('.ui-project-message').html(ret.data);
    });

    /*************************
    ======== INFO FORM =======
    *************************/
    $('span.ui-del-info').click(function () {
        ret = $.crluo.ajax_sync('/ajax/work/info', {
            'del_id': $(this).attr('data-id'),
            'creativeroom_id': $('#creativeroom_id').val()
        });
        $('.ui-project-info').html(ret.data);
    });

    /***********************************
    ========  Project file  ============
    ************************************/
    $("#droppable").crluoFileDrop({
        url: '/files/upload/file',
        creativeroom_id: $('#creativeroom_id').val(),
        dest: '.ui-project-file',
        progress: '.ui-loader-progress'
    });

    $('.ui-preview-list[data-remote]').crluoVideoList({
        creativeroom_id: $('#creativeroom_id').val(),
        progress: '.ui-loader-progress'
    });

    $('[data-toggle="tooltip"]', '.ui-project-preview').tooltip()

    $('#modalUrlWindow').on('hidden.bs.modal', function (e) {
        $('#modalUrlText').html('');
    });

    $(document).on('click', 'a.ui-share-movie', function (e) {
        e.preventDefault();
        id = $(this).attr('data-id');
        data = {
            'id': id,
            creativeroom_id: $('#creativeroom_id').val()
        };
        $.ajax({
            url: '/guest/url/' + id,
            data: data,
            type: "post",
            dataType: "html",
            success: function (data) {
                $('#modalUrlText', '#modalUrlWindow').text(data);
            },
            error: function (xhr, status) {
                $('#modalUrlText').text(xhr.responseText);
            }
        });
    });

    

    var listTimeLineComment = [];
    $(document).on('click', 'div.ui-preview-movie', function () {
        
        $('#pv-video').remove();
        var video = document.createElement("video");
        video.id = 'pv-video';
        video.src = $(this).attr('data-procname');
        // video.poster = $(this).attr('src');
        video.controls = false;
        video.autoplay = true;
        video.loop = false;
        video.muted = false;
        video.setAttribute('data-fileid', $(this).attr('data-fileid'));
        $(video).insertBefore('#pv-caption');
        var title = $(this).attr('data-original-title') ? $(this).attr('data-original-title') : $(this).attr('title');
        $('.ui-prev-title').text(title);
        fileid = $(this).attr('data-fileid');
        get_captions();
        reset_player_ui();
        init_player();
        hightLightComment();
    });

    $(document).on('click', 'a.ui-delete-movie', function (e) {
        e.preventDefault();
        var $div = $('.preloader').fadeIn();
        id = $(this).attr('data-id');
        $data = {'del_id': id, 'creativeroom_id': $('#creativeroom_id').val()};
        $.ajax({
            url: '/ajax/work/preview',
            data: $data,
            type: "post",
            dataType: "html",
            success: function (data) {
                $('.ui-project-preview').html(data);
                $div.fadeOut();
            },
            error: function (xhr, status) {
                // console.log(xhr);
                $('.preloader').html(xhr.responseText);
            },
        });
    });

    
    function hightLightComment(){

        var _videoL = document.getElementById('pv-video');
        _videoL.addEventListener('timeupdate',function(){
            var _currentTime = parseInt( _videoL.currentTime );
          //  console.log(_currentTime);
            var rs = jQuery.inArray(_currentTime, listTimeLineComment);
            if(rs !== -1){
                var classEle = '.h-'+_currentTime;
                $('.tasks').find('div:not('+classEle+')').removeClass('l-highlight');
                setTimeout(function(){
                    if( ! $('.h-'+_currentTime).hasClass('l-highlight') ){
                        $('.h-'+_currentTime).addClass('l-highlight');
                    }
                },100);
            }
        });


        _videoL.addEventListener('playing',function(){
            var _currentTime = parseInt( _videoL.currentTime );
              if(jQuery.inArray(_currentTime, listTimeLineComment) !== -1){
                    setTimeout(function(){
                        $('.h-'+_currentTime).addClass('l-highlight');
                    },100);
              }
        });

        _videoL.addEventListener('seeked',function(){
           $('.task-element').removeClass('l-highlight');
           /*var currentTime = parseInt( _videoL.currentTime );
           for(var i = currentTime ; i > 0; i--){
                
                if(jQuery.inArray(i, listTimeLineComment) !== -1){
                    setTimeout(function(){
                        $('.h-'+i).addClass('l-highlight');
                    },100);
                    break;
                }
           }*/
        });

    }
   
    var captions = []; // empty array to hold the individual captions
    var ns = 'http://www.w3.org/2000/svg';
    var mousex;
    var mousey;
    var fileid;

    function get_captions() {
        var drawWidth = $('#pv-draw').width();
        var drawHeight = $('#pv-draw').height();
        if ($(window).width() < 1400) {
            drawWidth = 900;
            drawHeight = 480;
        }
        captions = []; // empty the captions array
        $('#pv-list').empty();
        $('#progress span').remove()
        $.getJSON("/files/captions", {file_id: fileid}, function (json) {
            var progressBarWidth = $('#progress').width();
            globalCaptions = [];
            $.each(json, function (key, value) {
                var _v = parseInt(value.start);
                if(jQuery.inArray(parseInt(value.start), listTimeLineComment) == -1){
                    listTimeLineComment.push(_v);
                }
                // List the captions
                captions.push(value);
                globalCaptions.push(Math.round(value.start));
                //console.log(value)
                $('#pv-list').append(createCaptionElement(value));

                if (value.kind == 2) {
                    var el = document.createElementNS(ns, 'rect');
                    $.each(value.title, function (key, value) {
                        if ((key == 'x' || key == 'width') && value.indexOf('%') == -1) {
                            el.setAttribute(key, (value / drawWidth * 100) + '%');
                        } else if ((key == 'y' || key == 'height') && value.indexOf('%') == -1) {
                            el.setAttribute(key, (value / drawHeight * 100) + '%');
                        } else {
                            el.setAttribute(key, value);
                        }
                    })
                    el.style.display = 'none';
                    $('#pv-draw').append(el);
                }

                // Mark in timeline
                var t = setInterval(function () {
                    if ($('#pv-video')[0].readyState > 0) {
                        var classWidth  = '';
                        if(value.text.length > 60){
                            value.text = value.text.substr(0, 60)+'...';
                            classWidth = 'l-width-350';
                        }else{
                            if(value.text.length > 20){
                                classWidth = 'l-width-350';
                            }
                        }
                        var markerPosition = (value.start / $('#pv-video')[0].duration) * 100;
                        var marker = document.createElement('span');
                        marker.setAttribute('class', 'marker');
                        marker.setAttribute('data-high-light', _v);
                        marker.style.left = Math.round(markerPosition) + '%';
                        marker.setAttribute('data-begin', value.title['data-begin']);
                        marker.setAttribute('data-end', value.title['data-end']);
                        var capt = document.createElement('div');
                        capt.setAttribute('class', 'bubble '+classWidth);
                        capt.innerText = value.text;
                        marker.append(capt);
                        $('#progress').append(marker);
                        clearInterval(t);
                    }
                }, 500);
            });
        });
    }

    $(document).on('click', '.delete-preview', function () {
        var self = this;
        var pid = $(this).attr('data-id');
        $.ajax({
            method: 'DELETE',
            url: '/previews/' + pid,
            success() {
                get_captions();
                self.parent().parent().remove();
            },
            error() {
                console.log('error');
            }
        });
    });

    function reset_player_ui() {
        dragging = false;
        $('#pv-draw').css('cursor', 'auto');
        $('#pv-draw').unbind('mousemove');
        $('button', '#pv-controller-controll').removeClass('ui-selected').addClass('ui-unselected');
    };

    function init_player() {
        reset_player_ui();
        $('#pv-draw').children().remove();
        $('input', '#pv-text').val('');
        $('#pv-text').hide();
        var total_time;

        $('#pv-video').on('loadedmetadata', function () {
            duration = new Date();
            duration.setHours(0, 0, $('#pv-video')[0].duration, 0);
            total_time = duration.toLocaleTimeString().replace(/ JST/, '');
        });

        $('#pv-video').on('play', function () {
            $('.ui-player-play').children().addClass('glyphicon-pause').removeClass('glyphicon-play');
            $('.ui-player-play').removeClass('ui-unselected').addClass('ui-selected');
        });
        $('#pv-video').on('pause', function () {
            $('.ui-player-play').children().addClass('glyphicon-play').removeClass('glyphicon-pause');
        });

        $('#pv-video').on('timeupdate', function (event) {
            $('#pv-caption').height($('#pv-video').height());
            $('#pv-draw').height($('#pv-video').height());
            $('#pv-caption').width($('#pv-video').width());
            $('#pv-draw').width($('#pv-video').width());
            $('#pv-caption').css('left', $('#pv-video').position().left);
            $('#pv-draw').css('left', $('#pv-video').position().left);
            var cntText = 0;
            var now = $(this)[0].currentTime;

            $.each($('#progress').children('span'), function (key, value) {
                if (now > value.getAttribute('data-begin') && now < value.getAttribute('data-end')) {
                    $(value).find('div').addClass('active');
                }
                if (now > value.getAttribute('data-end') || now < value.getAttribute('data-begin')) {
                    $(value).find('div').removeClass('active');
                }
            })

            $.each($('#pv-draw').children(), function (key, value) {
                if (now > value.getAttribute('data-begin') && now < value.getAttribute('data-end')) {
                    value.style.display = 'block';
                }
                if (now > value.getAttribute('data-end') || now < value.getAttribute('data-begin')) {
                    value.style.display = 'none';
                }
            })

            $('[data-end="' + Math.round(now) + '"]').removeClass('active');
            var now_time = new Date();
            now_time.setHours(0, 0, now, 0);
            // total_time =  duration.getHours() + ":" + duration.getMinutes() + ":" + duration.getSeconds() + "." + duration.getMilliseconds();
            $(".ui-prev-time").text(now_time.toLocaleTimeString().replace(/ JST/, '') + ' / ' + total_time);
            $("#pv-pgss").css({'width': (now / $(this)[0].duration) * 100 + '%'});
            var cap = "";
            var videoy = $('#pv-video').height() - 20;
        });
    }

    $("#pv-pgss").parent().click(function (e) {

        var _this = $(e.target).parent();
        var dataHighlight = _this.attr('data-high-light');
        $('.task-element').removeClass('l-highlight');
        setTimeout(function(){
            $('.h-'+dataHighlight).addClass('l-highlight');
        },100);
        
        $('#pv-video')[0].currentTime = (e.offsetX / $(this).width()) * $('#pv-video')[0].duration;
    });

    $('.ui-player-rect').click(function () {
        var dragging = false;
        var lastEle;

        $('#pv-draw').height($('#pv-video').height());
        reset_player_ui();
        $('.ui-player-rect').removeClass('ui-unselected').addClass('ui-selected');

        $('#pv-video').each(function () {
            $(this)[0].pause();
        });

        $('#pv-draw').css('cursor', 'crosshair');

        $('#pv-draw').one('mousedown', function (e) {
            var startx;
            var starty;
            var drawWidth = $('#pv-draw').width();
            var drawHeight = $('#pv-draw').height();
            var width = 0;
            var height = 0;
            $('#pv-draw').bind('mousemove', function (e) {
                if (!dragging) return;
                //console.log('dragging x:' + e.clientX + ' y:' +e.clientY)
                var x = e.offsetX;
                var y = e.offsetY;
                if (x - startx < 0) {
                    lastEle.setAttribute('x', x);
                    width = ((startx - x) / drawWidth) * 100;
                    lastEle.setAttribute('width', width + '%');
                } else {
                    width = ((x - startx) / drawWidth) * 100;
                    lastEle.setAttribute('width', width + '%');
                }
                if (y - starty < 0) {
                    lastEle.setAttribute('y', y);
                    height = ((starty - y) / drawHeight) * 100;
                    lastEle.setAttribute('height', height + '%');
                } else {
                    height = ((y - starty) / drawHeight) * 100;
                    lastEle.setAttribute('height', height + '%');
                }
            });
            dragging = true;
            startx = e.offsetX;
            starty = e.offsetY;
            lastEle = document.createElementNS(ns, "rect");
            lastEle.setAttribute('x', ((startx / drawWidth) * 100) + '%');
            lastEle.setAttribute('y', ((starty / drawHeight) * 100) + '%');
            $('#pv-draw').append(lastEle);
        });

        $('#pv-draw').one('mouseup', function (e) {
            reset_player_ui();
            mousex = e.offsetX;
            mousey = e.offsetY;
            $('.ui-player-text').click();
            $('#captionType').val('rect');
        });
    });

    $('.ui-player-text').click(function (e) {
        //$('#pv-draw').height($('#pv-video').height());
        $('#captionType').val('text');
        $('#pv-video').each(function () {
            $(this)[0].pause();
        });
        reset_player_ui();
        $('.ui-player-text').removeClass('ui-unselected').addClass('ui-selected');
        if (e.offsetX > 0) {
            //$('.ui-player-text').offset().top();
            // console.log($('#pv-draw').height())
            // console.log($('#pv-text').height())
            mousex = e.offsetX;
            mousey = $('#pv-draw').height() - 200;
        }
        // console.log(mousey)

        $('#pv-text').css({'left': mousex + 50, 'top': mousey});
        $('#pv-text').show();

        if ($('.ui-prev-input').width() + mousex + 50 > $('#pv-text').width()) {
            $('#pv-text').css('left', mousex - $('.ui-prev-input').width() - 50);
        }

    });

    $('.ui-player-play').click(function () {
        reset_player_ui();
        if ($('#pv-video')[0].paused) {
            $('#pv-video')[0].play();
        } else {
            $('#pv-video')[0].pause();
        }
    });

    $('.ui-player-mute').click(function () {
        reset_player_ui();
        $('#pv-video')[0].muted = $('#pv-video')[0].muted ? false : true;
        $('span', '.ui-player-mute').toggleClass('glyphicon-volume-off').toggleClass('glyphicon-volume-up');

    });

    //Add captions
    $('button', '#pv-text').click(function () {
        if ($(this).attr('data-kind') == 'cancel' || ($('input', '#pv-text').val() == '' && $('#pv-draw').children().length == 0)) {
            $('#pv-draw').children().remove();
        } else {
            var start = $('#pv-video')[0].currentTime;
            var end = start + parseFloat($('select', '#pv-text').val());
            var param = {};
            param.attr = {};
            if ($('#captionType').val() == 'rect') {
                let svgs = $('#pv-draw').children();
                let lastSVG = svgs[svgs.length - 1];
                // console.log($(lastSVG))
                $.each($(lastSVG)[0].attributes, function (key, value) {
                    param.attr[value.name] = value.value;              //captions.push(value);
                });
                param.kind = 2
            }
            param.attr['data-begin'] = start;
            param.attr['data-end'] = end;
            param.attr['text'] = $('input', '#pv-text').val();
            param.file_id = $('#pv-video').attr('data-fileid');
            param.creativeroom_id = $('#creativeroom_id').val();
            param._token = $('meta[name="csrf-token"]').attr('content');
            // console.log(param)
            $('.preloader').show();
            $.ajax({
                url: "/previews",
                data: param,
                type: "post",
                dataType: "html",
                success: function (data) {
                    get_captions();
                    $('#messages').append(data);
                },
                error: function (xhr, status) {
                    // console.log(xhr);
                },
                complete: function (xhr, status) {
                    $('.preloader').fadeOut();
                }
            });
        }
        $('#pv-text').hide();
        $('input', '#pv-text').val('');
        reset_player_ui();
    });

    reset_player_ui();

    /******************************
    ========== Deliver ===========
    ******************************/

    $('button.ui-accept-checked').click(function () {
        var $div = $('.preloader').fadeIn();
        id = $(this).attr('data-id');
        data = {'creativeroom_id': $('#creativeroom_id').val()};
        $.ajax({
            url: '/ajax/work/checked',
            data: data,
            type: "post",
            dataType: "html",

            success: function (data) {
                $('.ui-project-deliver').html(data);
                $div.fadeOut();
            },
            error: function (xhr, status) {
                // console.log(xhr);
                $('.preloader').html(xhr.responseText);
            },
        });
    });

    $('button.ui-accept-deliver').click(function () {
        var $div = $('.preloader').fadeIn();
        id = $(this).attr('data-id');
        $data = {'creativeroom_id': $('#creativeroom_id').val()};
        $.ajax({
            url: '/ajax/work/accept',
            data: $data,
            type: "post",
            dataType: "html",

            success: function (data) {
                $('.ui-project-deliver').html(data);
                $div.fadeOut();
            },
            error: function (xhr, status) {
                // console.log(xhr);
                $('.preloader').html(xhr.responseText);
            },
        });
    });

    $('#restart').on('click', function () {
        $('#pv-video')[0].currentTime = 0;
    })

    $('#prev').on('click', function () {
        $('#pv-video')[0].currentTime -= 5;
    })

    $('#next').on('click', function () {
        $('#pv-video')[0].currentTime += 5;
    })

    $(document).on('click', '.task-element:not(.l-see-all)', function(e) {
        var _e = $(e.target);
        if(_e.context.nodeName != 'A'){
            $('#pv-video')[0].currentTime = $(this).data('start');
        }
    });

    /**************************************************
    ==================== Compare ======================
    **************************************************/
    // $('#togglePreview').click(function () {
    //     if ($('#section-1').hasClass('hidden')) {
    //         $('#togglePreview').text('２つのプレビューファイルを比較する')
    //         $('#section-1').removeClass('hidden')
    //         $('#section-2').addClass('hidden')
    //     } else {
    //         $('#togglePreview').text('プレビューモード')
    //         $('#section-1').addClass('hidden')
    //         $('#section-2').removeClass('hidden')
    //     }
    // })
    $('.preview-control').click(function() {
        $('.preview-control').removeClass('btn-warning').addClass('btn-default');
        $(this).addClass('btn-warning').removeClass('btn-default');
        $('.pane').addClass('hidden');
        var target = $(this).data('href');
        $(target).removeClass('hidden');
    });

    /*****************************
    ======= CONTROL HANDLE =======
    *****************************/

    $('.video-control.play').click(function () {
        if ($('#video-1')[0].readyState == 4 && $('#video-2')[0].readyState == 4) {
            if ($('#video-1')[0].paused) {
                $('#video-1')[0].play();
                $('#video-2')[0].play();
                $('#video-2')[0].currentTime = $('#video-1')[0].currentTime;
            } else {
                $('#video-1')[0].pause();
                $('#video-2')[0].pause();
            }
        }
    });

    $('#video-1').on('canplay', function() {
        if ($('#video-2')[0].readyState == 1) {
            $('#video-1').get(0).play();
            $('#video-2').get(0).play();
        }
    });

    $('#video-1').on('loadedmetadata', function() {
        var syncDuration = $(this).get(0).duration;
        $('.duration').text(extractTimeString(syncDuration));
    });

    $('#video-2').on('canplay', function() {
        if ($('#video-1')[0].readyState == 1) {
            $('#video-1').get(0).play();
            $('#video-2').get(0).play();
        }
    });

    $('#video-1').on('play', function () {
        $('.video-control.play').html('<i class="fa fa-pause"></i>');
    });

    $('#video-1').on('pause', function () {
        $('.video-control.play').html('<i class="fa fa-play"></i>');
    });

    $('.video-control.restart').click(function () {
        if ($('#video-1')[0].readyState == 4 && $('#video-2')[0].readyState == 4) {
            $('#video-1')[0].currentTime = 0;
            $('#video-2')[0].currentTime = 0;
            $('#video-1')[0].play();
            $('#video-2')[0].play();
        }
    });

    $('.video-control.forward').click(function () {
        if ($('#video-1')[0].readyState == 4 && $('#video-2')[0].readyState == 4) {
            $('#video-1')[0].currentTime += 5;
            $('#video-2')[0].currentTime += 5;
        }
    });

    $('.video-control.backward').click(function () {
        if ($('#video-1')[0].readyState == 4 && $('#video-2')[0].readyState == 4) {
            $('#video-1')[0].currentTime -= 5;
            $('#video-2')[0].currentTime -= 5;
        }
    });

    $('.video-control.backward').click(function () {
        if ($('#video-1')[0].readyState == 4 && $('#video-2')[0].readyState == 4) {
            $('#video-1')[0].currentTime -= 5;
            $('#video-2')[0].currentTime -= 5;
        }
    });

    $('.video-control.volume').click(function () {
        if ($('#video-1')[0].readyState == 4 && $('#video-2')[0].readyState == 4) {
            $('#video-1').prop('muted', !$('#video-1')[0].muted);
            $('#video-2').prop('muted', true);
        }
    });

    $('#video-1').on('volumechange', function () {
        if ($('#video-1')[0].muted == true) {
            $('.video-control.volume').html('<i class="fa fa-volume-off"></i>');
        } else {
            $('.video-control.volume').html('<i class="fa fa-volume-up"></i>');
        }
    })

    $('#video-1').on('timeupdate', function () {
        let now = $('#video-1')[0].currentTime;
        $(".compare-progress-bar").css({'width': (now / $(this)[0].duration) * 100 + '%'});

        $(".current-time").text(extractTimeString(now));
    });

    $(".compare-progress").click(function (e) {
        $('#video-1')[0].currentTime = (e.offsetX / $(this).width()) * $('#video-1')[0].duration;
        $('#video-2')[0].currentTime = (e.offsetX / $(this).width()) * $('#video-1')[0].duration;
    });

    /*****************************
    ==== DRAG AND DROP HANDLE ====
    *****************************/
    var videoUrlTransfer = '';

    $(document).on('dragstart', '.movie-drag', function() {
        videoUrlTransfer = $(this).data('procname');
    });

    $(document).on('dragend', '.movie-drag', function() {
        videoUrlTransfer = '';
    });

    $('.compare .storage').on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (videoUrlTransfer != '') {
            $(this).addClass('btn-warning').removeClass('btn-default');
        }
    });

    $('.compare .storage').on('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('btn-warning').addClass('btn-default');
    });
    $('.compare .storage').on('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (videoUrlTransfer != '') {
            $(this).addClass('btn-success').removeClass('btn-default btn-warning');
            $(this).data('src', videoUrlTransfer);
        }
        videoUrlTransfer = '';
    });
    $(document).on('click', '.ui-del-file, .ui-del-deliver', function(e) {
        e.stopPropagation();
        var element = $(this);
        if (!confirm(messages.confirm_delete)) {
            return;
        }
        $('.preloader').fadeIn();
        $.ajax({
            url: '/files/' + element.data('id'),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: "DELETE"
            },
            success: function() {
                element.parents('.delivery').remove();
            },
            complete: function() {
                $('.preloader').fadeOut();
            }
        });
    });

    $('div.ui-preview-movie').click(function(){
        $('div.ui-preview-movie').removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click', '.ui-del-preview', function(e) {
        e.stopPropagation()
        var thisElement = $(this)
        if (!confirm(messages.confirm_delete)) {
            return;
        }
        $('.tooltip').hide();
        $('.preloader').fadeIn()
        $.ajax({
            url: '/files/' + thisElement.data('id'),
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                thisElement.parents('.ui-preview-movie').remove()
                var url = '/files/preview/' + $('#creativeroom_id').val()
                $.get(url, function(response) {
                    $('.compare-list').html(response)
                });
            },
            complete: function() {
                $('.preloader').fadeOut()
            }
        });
    });

    $(document).on('submit', '#room-config', function(e) {
        e.preventDefault();
        var self = $(this);
        var ret = $.crluo.ajax_sync(self.prop('action'), self.serialize());
        $('#config').html(ret.data);
    });

    $(document).on('click', '.status-bar', function() {
        let self = $(this);
        let $id = $(this).data('id');
        let $state = $(this).hasClass('bar-success') ? 0 : 1;
        $('.preloader').show();
        $.ajax({
            url: '/tasks/update',
            data: {
                _token: $('meta[name="csrf-token"]').val(),
                id: $id,
                state: $state
            },
            type: "post",
            dataType: "html",
            success: function (data) {
                if (self.hasClass('bar-success')) {
                    self.removeClass('bar-success').addClass('bar-danger');
                } else {
                    self.removeClass('bar-danger').addClass('bar-success');
                }
            },
            error: function (xhr, status) {
                alert('Error Occur!');
            },
            complete: function() {
                $('.preloader').fadeOut();
            }
        });
    });

    $(document).on('click', 'a.l-see-all',function(){
        var fullText = $(this).attr('data-full-text');
        var parent = $(this).parent();
        parent.empty();
        parent.text(fullText);
        $(this).remove();
    });

});

function getStatusClass($status) {
    if ($status == 1) {
        return 'bar-success';
    } else {
        return 'bar-danger';
    }
}

function createCaptionElement($data)
{
    console.log( $data );
    var highLight = 'h-'+parseInt($data['start']);
    var $el = $('<div></div>', {
        class: 'task-element '+highLight+' le-'+$('.ui-preview-movie.active').attr('data-fileid'),
        'data-start': $data['start']
    });
    var $state = $('<div></div>', {
        class: "status-bar " + getStatusClass($data['status']),
        'data-id': $data['id']
    });

    let $image = $('<div></div>', {
        class: 'caption-image'
    }).append($('<img>', {src: $data['photo'], class: 'img-circle', width: 40}));

    let $content = $('<div></div>', {
        class: 'caption-content'
    }).append($('<h5></h5>').text($data['name']).append('<span class="l-s-time">'+$data['start_format']+'</span>'));

    //limit text 50 characters to タスク一覧
    var _50Characters = $data['title']['text'];
    
    if(_50Characters.length > 50){
        _50Characters = _50Characters.substr(0,49)+'<a data-full-text="'+$data['title']['text']+'" href="javascript:;" class="l-see-all" > >> </a>';
    }else{
        _50Characters = $data['text'];
    }
    _50Characters  = '<p>'+_50Characters+'</p>';
   // $content.append($data['text']);
    $content.append(_50Characters);
    $el.append($state);
    $el.append($image);
    $el.append($content);

    return $el;
}

$('[data-filter="hankaku"]').keydown(function(e) {
  var allowKeys = [8, 46, 37, 39, 35, 36, 229, 13, 9];
  if (allowKeys.indexOf(e.keyCode) > -1) {
    return;
  }
  if (e.keyCode < 48 || e.keyCode > 57) {
    e.preventDefault();
  }
});

$('[data-filter="hankaku"]').focusout(function() {
  $(this).val(toHankaku($(this).val()));
});

var toHankaku = (function (String, fromCharCode) {
  function toHankaku (string) {
    return String(string).replace(/\u2019/g, '\u0027').replace(/\u201D/g, '\u0022').replace(/\u3000/g, '\u0020').replace(/\uFFE5/g, '\u00A5').replace(/[\uFF01\uFF03-\uFF06\uFF08\uFF09\uFF0C-\uFF19\uFF1C-\uFF1F\uFF21-\uFF3B\uFF3D\uFF3F\uFF41-\uFF5B\uFF5D\uFF5E]/g, alphaNum);
  }

  function alphaNum (token) {
    return fromCharCode(token.charCodeAt(0) - 65248);
  }

  return toHankaku;
})(String, String.fromCharCode);

function extractTimeString(seconds)
{
    seconds = Math.round(seconds);
    var hours = Math.floor(seconds / (60 * 60));

    var divisor_for_minutes = seconds % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);

    var divisor_for_seconds = divisor_for_minutes % 60;
    var secs = Math.ceil(divisor_for_seconds);

    return addLeadingZero(hours) + ':' + addLeadingZero(minutes) + ':' + addLeadingZero(secs);
}

function addLeadingZero(number)
{
    return number < 10 ? "0"+number : number;
}
