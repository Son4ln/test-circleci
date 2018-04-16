var currentCrluoPrivateChannel = '';
$.listenMessages = function(roomId) {
	window.Echo.join(roomId)
	.listen('MessageReceived', function(e) {
		createMessageElement(e).appendTo('#messages');
		$('#messages').scrollTop(1e5);
	});
}

$.listenCrluoMessages = function(roomId) {
	window.Echo.private(roomId)
		.listen('CrluoMessageReceived', function(e) {
			currentCrluoPrivateChannel = roomId;
			createMessageElement(e).appendTo('#crluo-messages');
			$('#crluo-messages').scrollTop(1e5);
		});
}

var files = [];
var thumbnails = [];
var thumbnailStore = [];
var room_id = $('#creativeroom_id').val();
function createMessageElement(message)
{
	var $div = $('<div></div>', {
		'class': 'flexable margin-15 ' + getMessageClass(message.message.user_id)
	});

	if (files.length > 0) {
		message.message.files = files;
	}

	$div.append($('<img>', {
		src: message.user.photo,
		'class': 'user-image'
	}));

	var $container = $('<div></div>', {
		'class': 'message-container'
	});
	var info = message.user.name ? message.user.name : '';
	if (info.length > 24) {
	info = info.substr(0, 21) + '...';
	}
	var $name = $('<h5></h5>').html(info);
	$name.append('&nbsp;&nbsp;&nbsp;&nbsp;');
	$name.append(message.message.created_at);

	$container.append($name);

	var content = message.message.message.replace(/\r?\n/g, '<br />');
	var content = content != null ?
		content.autoLink({rel: 'noopener', target: '_blank'}) : '';

	var $content = $('<span></span>', {
		'class': 'content'
	}).html(content);

	if (message.message.files) {
		for(var i = 0; i < message.message.files.length; i ++) {
			$content.append($('<a></a>', {
				href: message.message.files[i].path,
				download: message.message.files[i].name
			}).text(message.message.files[i].name));
		}
	}

	$container.append($content);

	$div.append($container);

	return $div;
}

function getMessageClass(id)
{
	if ($('#user_id').val() == id) {
		return '';
	}
	return '';
}

var upload_completed = true;
var last_message = 0;
var last_crluo_message = 0;
var not_loading = true;
$('#document').ready(function() {
	refreshLastId();
	refreshCrluoLastId();

	$('#messages').scrollTop(1e5);

	$('#messages').scroll(function() {
		if ($(this).scrollTop() < 300 && not_loading) {
			getResult('#messages');
		}
	});

	$('#crluo-messages').scroll(function() {
		if ($(this).scrollTop() < 300 && not_loading) {
			getResult('#crluo-messages');
		}
	});

	$('#crluo_messages').scroll(function() {
		if ($(this).scrollTop() < 300 && not_loading) {
			getCrluoResult('#crluo_messages', false);
		}
	});

	$('#sendmesform').submit(function(e) {
		e.preventDefault();
		var $target = "#messages";
		submitMessageForm($target);
	});
	$('#input_message').keydown(function (e) {
		var _this = this;
		if ( (e.metaKey || e.ctrlKey) && e.keyCode == 13 ) {
			e.preventDefault();
			var $target = "#messages";
			submitMessageForm($target);
		}
		var text = $(this).val();
		if(text.trim()  == ''){
			//_this.style.cssText = '';
		}else{
			setTimeout(function(){
				_this.style.cssText = 'height:auto; padding:0';
				_this.style.cssText = 'height:' + _this.scrollHeight + 'px';
			},0);
		}
		
	});
	
	var textarea = document.getElementById('input_message');

	textarea.addEventListener('keydown', autosize);
	var flagAdd = false;
	function autosize(){
	var el = this;
		setTimeout(function(){
			el.style.cssText = 'height:auto; padding:0';
			// for box-sizing other than "content-box" use:
			// el.style.cssText = '-moz-box-sizing:content-box';
			var h = el.scrollHeight +30;
			
			el.style.cssText = 'height:' + h + 'px';

			if(el.value == ''){
				flagAdd = false;
				el.style.cssText = '';
			}
			
		},0);
	}	
	
	$('#sendinfoform').submit(function(e) {
		e.preventDefault();
		var $target = "#crluo-messages";
		submitMessageForm($target);
		// createSelfMessage($target);
	});

	$('#admin_crluo_form').submit(function(e) {
		e.preventDefault();
		submitCrluoMessage('#crluo_messages');
	});

	$('a[href="#work-default"]').click(function() {
		setTimeout(function() {
			$('#crluo-messages').scrollTop(1e5);
			$('#crluo_messages').scrollTop(1e5);
		}, 10)
	});

	$('a[href="#work-message"]').click(function() {
		setTimeout(function() {
			$('#messages').scrollTop(1e5);
		}, 10)
	});

	$(document).on('submit', '#project form', function(e) {
		e.preventDefault();
		let url = $(this).attr('action');
		let form = new FormData($(this)[0]);
		$('.preloader').show();
		$.ajax({
			url: url,
			type: 'POST',
			data: form,
			processData: false,
			contentType: false,
			success: function(response) {
				$('#project').modal('hide');
			},
			complete() {
				$('.preloader').fadeOut();
			}
		});
	});

	$(document).on('click', '.tab-toggle', function(e) {
		var _element = $(e.target);
		if($(this).attr('type')==='button')
			$('#page-wrapper').addClass('bg-282828');
		else
			$('#page-wrapper').removeClass('bg-282828');

		$('.task-element').removeClass('l-highlight'); 
		if(_element.context.nodeName === 'BUTTON'){
			var fileId =  _element.attr('data-file');
			var time =  _element.attr('data-time');
			setTimeout(function (){
				$('.h-'+time+'.le-'+fileId).addClass('l-highlight');
			},100);

			$('.ui-preview-movie').removeClass('active');

			var _div = $("div[data-fileid|='"+fileId+"']");
			
			_div.trigger('click');
			if(typeof time != 'undefined'){
				var pvVideo = document.getElementById('pv-video');
				pvVideo.currentTime = time;
			}
		}
		$('.tab-toggle').removeClass('active');
		$(this).addClass('active');
		$('.tab-pane').hide();
		$($(this).data('target')).fadeIn();
		if ($(this).data('target') == '#chat') {
			$('#messages').scrollTop(1e6);
		}
	});
});

function exportDate(date) {
	return date.getFullYear() + '/' + addLeadingZero(date.getMonth() + 1) + '/' + addLeadingZero(date.getDate());
}

function addLeadingZero(number) {
	if (number < 10) {
		return '0' + number;
	}

	return number;
}

function createSelfMessage($id)
{
	var content = $id == '#messages' ? $('#input_message').val() : $('#crluo_message').val();
	if (!content && !upload_completed) {
		return;
	}
	let now = new Date();
	let jst = 540 + now.getTimezoneOffset();
	var message = {
		message: {
			'user_id': $('#user_id').val(),
			message: content,
			created_at: exportDate(new Date(now.valueOf() + jst * 60000))
		},
		user: {
			photo: $('.img-circle').prop('src'),
			name: $('#original_name').text()
		}
	}

	createMessageElement(message).appendTo($id);
	setTimeout(function() {
		$($id).scrollTop(1e6);
	}, 100);
}

var message_not_sending = true;
function submitMessageForm($target)
{
	var content = $target == '#messages' ? $('#input_message').val() : $('#crluo_message').val();
	content = content.autoLink({rel: 'noopener', target: '_blank'});
	if (!content && !upload_completed) return;

	if ($('#input_message').attr('disabled') == 'disabled') {
		return;
	}
	$('#input_message').attr('disabled', true);
	$('#admin-user-search-btn').addClass('disabled');
	$('#input_message').val('送信中です...');
	message_not_sending = false;
	$.ajax({
		url: '/messages/send',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			message: content,
			creativeroom_id: $('#creativeroom_id').val(),
			kind: $target == '#messages' ? 1 : 2,
			files: JSON.stringify(files),
		},
		success: function(response) {
			$($target).append(response);
			if (files.length > 0) {
				files = [];
				createdThumbnails = [];
				$.get('/files/projects/' + room_id, function(response) {
					$('#content-files_list').html(response);
				});
				$('#input_message').attr({'style': ''});
			}
			$('#input_message').attr('style','');
		},
		error: function(xhr, status) {
			var errorString = '';
			if (xhr.status == 422) {
				var errors = xhr.responseJSON;
				for (error in errors) {
					errorString += errors[error][0];
				}
				alert(errorString);
			} else {
				alert("メッセージが送信できませんでした!");
			}
		},
		complete: function() {
			$('textarea').val('');
			mUploader.reset();
			message_not_sending = true;
			$('#input_message').attr('disabled', false);
			$('#admin-user-search-btn').removeClass('disabled');
			$('#input_message').val('');
		}
	})
}

function submitCrluoMessage($target)
{
	var content = $('#crluo_message').val();
	content = content.autoLink({rel: 'noopener', target: '_blank'});
	if (!content) return;

	if (!message_not_sending) {
		alert('You type too fast!');
		return;
	}
	message_not_sending = false;
	$('.sending').removeClass('hidden');
	$.ajax({
		url: '/messages/send',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			message: content,
			creativeroom_id: $('#creativeroom_id').val(),
			kind: $target == '#messages' ? 1 : 2,
			files: JSON.stringify(files),
			recipient_id: $('#creativeroom_users').val()
		},
		success: function(response) {
			$($target).append(response);
		},
		error: function(xhr, status) {
			var errorString = '';
			if (xhr.status == 422) {
				var errors = xhr.responseJSON;
				for (error in errors) {
					errorString += errors[error][0];
				}
				alert(errorString);
			} else {
				alert("メッセージが送信できませんでした!");
			}
		},
		complete: function() {
			$('textarea').val('');
			message_not_sending = true;
			$('.sending').addClass('hidden');
		}
	})
}

function refreshLastId()
{
	last_message = $('#last_message').val();
	$('#last_message').remove();
}

function refreshCrluoLastId()
{
	last_crluo_message = $('#last_crluo_message').val();
	$('#last_crluo_message').remove();
}

function getResult($target)
{
	var last_id = $target == '#messages' ? last_message : last_crluo_message;
	if (!last_id) return;
	$('.loading-text').removeClass('hidden')
	not_loading = false;
	$.ajax({
		url: '/messages/paginate',
		type: 'POST',
		dataType: 'html',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			last_id: last_id,
			kind: $target == '#messages' ? 1 : 2,
			room_id: $('#creativeroom_id').val()
		},
		success: function(response) {
			$($target).prepend(response);
			$($target).scrollTop($($target).scrollTop() + 100);
			setTimeout(function() {
				if ($target == '#messages') {
					refreshLastId();
				} else {
					refreshCrluoLastId();
				}
			}, 200)
		},
		complete: function() {
			not_loading = true;
			$('.loading-text').addClass('hidden');
		}
	})
}

function getCrluoResult($target, $scroll)
{
	var last_id = last_crluo_message;
	if (!last_id && !$scroll) return;
	not_loading = false;
	$('.loading-text').removeClass('hidden');
	$.ajax({
		url: '/messages/crluo',
		type: 'POST',
		dataType: 'html',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			last_id: last_id,
			kind: 2,
			room_id: $('#creativeroom_id').val(),
			recipient_id: $('#creativeroom_users').val()
		},
		success: function(response) {
			if ($scroll) {
				$($target).html(response);
				$($target).scrollTop(1e5);
			} else {
				$($target).prepend(response);
				$($target).scrollTop($($target).scrollTop() + 100);
			}
			setTimeout(function() {
				refreshCrluoLastId();
				if ($scroll) {
					$($target).scrollTop(1e5);
				} else {
					$($target).scrollTop($($target).scrollTop() + 100);
				}
			}, 200);
		},
		complete: function() {
			not_loading = true;
			$('.loading-text').addClass('hidden');
		}
	})
}

$('#creativeroom_users').change(function() {
	last_crluo_message = 0;
	var $roomId = $('#creativeroom_id').val();
	if (currentCrluoPrivateChannel != '') {
		window.Echo.leave(currentCrluoPrivateChannel);
	}
	if ($(this).val() != 0) {
		currentCrluoPrivateChannel = 'room.' + $roomId + '.' + $(this).val();
		window.Echo.private(currentCrluoPrivateChannel)
			.listen('CrluoMessageReceived', function(e) {
				currentCrluoPrivateChannel = $roomId;
				createMessageElement(e).appendTo('#crluo_messages');
				$('#crluo_messages').scrollTop(1e5);
			});
	}

	getCrluoResult('#crluo_messages', true);
});

var mUploader = new qq.s3.FineUploader({
	element: document.getElementById('chat_uploader'),
	request: {
		//endpoint: 'https://' + bucketName + '.' + 's3' + '-' + region + '.amazonaws.com',
		endpoint:'https://'+bucketName+'.s3-accelerate.amazonaws.com',
		accessKey: accessKey,
	},
	signature: {
		endpoint: '/s3?room=' + $('#creativeroom_id').val(),
		customHeaders: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
	},
	validation: {
		sizeLimit: 5368709120
	},
	chunking:{
		partSize:5242880*4
	},
	uploadSuccess: {
		endpoint: '/s3/success'
	},
	extraButtons: [{
		element: document.getElementById("message_file_upload") ,
	}],
	objectProperties: {
		key: function(uuid) {
			var date = new Date();
			return 'files/' + $('#creativeroom_id').val() + '/' + mUploader.getName(uuid);
		},
		acl: 'public-read'
	},
	callbacks: {
		onComplete: function(id, name, responseJson) {
			var filePath = responseJson.tempLink.split('?')[0];
			var type = mUploader.getFile(id).type;
			if (!/^image/.test(type) && !/^video/.test(type)) {
				files[id] = {
					name: name,
					path: filePath,
				};
			} else if (isNotThumbnail(name)) {
				files[id] = {
					name: name,
					path: filePath,
					thumb: filePath.replace(name, 'thumbnail_' + name)
				};
			}
		},
		onSubmitted: function(id, name) {
			if (/^video/.test(mUploader.getFile(id).type) && isNotThumbnail(name)) {
				thumbnails.push('thumbnail_' + name);
				$('#video').get(0).src = window.URL.createObjectURL(mUploader.getFile(id));
				var video = document.getElementById('video');
				video.onloadeddata = function() {
					var canvas = document.getElementById('canvas');
					var size = calculateRelution(video.videoWidth, video.videoHeight, 200)
					canvas.width = size.width;
					canvas.height = size.height;
					canvas.getContext('2d').drawImage(video, 0, 0, size.width, size.height);
					mUploader.addFiles ({
						canvas: canvas,
						name: 'thumbnail_' + name,
						type: 'image/png'
					});
				}

			}
			if (/^image/.test(mUploader.getFile(id).type) && isNotThumbnail(name)) {
				thumbnails.push('thumbnail_' + name);
				var promise = mUploader.drawThumbnail(id, document.getElementById('canvas'), 200);
				promise.done(function(e) {
					mUploader.addFiles ({
						canvas: document.getElementById('canvas'),
						name: 'thumbnail_' + name,
						type: 'image/png'
					});
				});
			}
		},
		onValidate() {
			$('#fade-screen').show();
			$('#chat_uploader .qq-upload-list-selector').show();
		},
		onAllComplete: function() {
			upload_completed = true;
			$('#fade-screen').hide();
			$('#chat_uploader .qq-upload-list-selector').hide();
			if (files.length > 0) {
				submitMessageForm('#messages');
			}
		},
		onProgress: function(id, name, uploadedBytes, totalBytes) {
			upload_completed = false;
		}
	}
});
mUploader.addExtraDropzone(document.getElementById('custom_drop_zone'));

function calculateRelution(width, height, max) {
	if (width > max) {
		height = height * (max / width);
		width = max;
	}

	if (height > max) {
		width = width * (max / height)
		height = max;
	}

	return {
		width: width,
		height: height,
	}
}

function isNotThumbnail(name) {
	if (name.indexOf('thumbnail_') != -1) {
		return false;
	}

	if (thumbnails.indexOf(name) == -1) {
		return true;
	}

	return false;
}

function saveThumbnail(name, link) {
	if (name.indexOf('thumbnail_') == -1) {
		return false;
	}

	if (thumbnails.indexOf(name) == -1) {
		return false;
	}
	var newName = name.replace('thumbnail_', '');

	for (var i = 0; i < files.length; i++) {
		console.log(files[i].name);
		if (files[i].name.indexOf(newName) != -1) {
			files[i].thumb = link;
			break;
		}
	}
}

function getLastSegment(url) {
	return url.substr(url.lastIndexOf('/') + 1);
}

$('#messages').on('dragover', function(e) {
	e.stopPropagation();
	e.preventDefault();
	$('#custom_drop_zone').show();
});

$('#custom_drop_zone').on('dragleave', function(e) {
	e.stopPropagation();
	$('#custom_drop_zone').hide();
});

$('#custom_drop_zone').on('drop', function(e) {
	e.stopPropagation();
	$('#custom_drop_zone').hide();
});

$('.qq-upload-drop-area').on('drop', function(e) {
	e.stopPropagation();
	$('#custom_drop_zone').hide();
});

$(window).resize(function() {
	if ($(window).width() > 992) {
		$('#room-body').height(getChatboxWidth());
	}
});

if ($(window).width() > 992) {
	$('#room-body').height(getChatboxWidth());
}

function getChatboxWidth() {
	var width = $(window).height() - $('.navbar-header').height()
		- $('.room-tabs').height() - $('.room-title').height() - 35;

	return width;
}

$(document).on('click', '.dropdown', function(e) {
	e.stopPropagation();
});

$(document).on('click', '.ui-preview-movie li a', function() {
	$(this).parent('.video-menu').removeClass('open');
});

Date.prototype.stringTime = function() {
var mm = this.getMonth() + 1; // getMonth() is zero-based
var dd = this.getDate();

return [this.getFullYear(),
		(mm>9 ? '' : '0') + mm,
		(dd>9 ? '' : '0') + dd,
		(this.getHours() > 9 ? '' : '0') + this.getHours(),
		(this.getMinutes() > 9 ? '' : '0') + this.getMinutes(),
		(this.getSeconds() > 9 ? '' : '0') + this.getSeconds(),
		].join('');
};

Date.prototype.toSQLString = function () {
var mm = this.getMonth() + 1; // getMonth() is zero-based
var dd = this.getDate();

return [
	this.getFullYear(),
	(mm > 9 ? '' : '0') + mm,
	(dd > 9 ? '' : '0') + dd
	].join('-') + ' ' +
	[
	(this.getHours() > 9 ? '' : '0') + this.getHours(),
	(this.getMinutes() > 9 ? '' : '0') + this.getMinutes(),
	(this.getSeconds() > 9 ? '' : '0') + this.getSeconds(),
	].join(':');
};

(function() {
var autoLink,
	slice = [].slice;

autoLink = function() {
	var callback, k, linkAttributes, option, options, pattern, v;
	options = 1 <= arguments.length ? slice.call(arguments, 0) : [];
	pattern = /(^|[\s\n]|<[A-Za-z]*\/?>)((?:https?|ftp):\/\/[\-A-Z0-9+\u0026\u2019@#\/%?=()~_|!:,.;]*[\-A-Z0-9+\u0026@#\/%=~()_|])/gi;
	if (!(options.length > 0)) {
	return this.replace(pattern, "$1<a href='$2'>$2</a>");
	}
	option = options[0];
	callback = option["callback"];
	linkAttributes = ((function() {
	var results;
	results = [];
	for (k in option) {
		v = option[k];
		if (k !== 'callback') {
		results.push(" " + k + "='" + v + "'");
		}
	}
	return results;
	})()).join('');
	return this.replace(pattern, function(match, space, url) {
	var link;
	link = (typeof callback === "function" ? callback(url) : void 0) || ("<a href='" + url + "'" + linkAttributes + ">" + url + "</a>");
	return "" + space + link;
	});
};

String.prototype['autoLink'] = autoLink;

}).call(this);
