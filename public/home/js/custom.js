/* =================================
LOADER
=================================== */
// makes sure the whole site is loaded

jQuery(window).load(function() {
		// will first fade out the loading animation
	jQuery(".status").fadeOut();
		// will fade out the whole DIV that covers the website.
	jQuery(".preloader").delay(1000).fadeOut("slow");
})

/* =================================
===  RESPONSIVE VIDEO           ====
=================================== */

$(".video-container").fitVids();



/* =================================
===  MAILCHIMP                 ====
=================================== */

$('.mailchimp').ajaxChimp({
	callback: mailchimpCallback,
	url: "http://webdesign7.us6.list-manage.com/subscribe/post?u=9445a2e155b82208d73433060&amp;id=16dc80e353" //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".
});

function mailchimpCallback(resp) {
	if (resp.result === 'success') {
		$('.subscription-success').html('<i class="icon_check_alt2"></i><br/>' + resp.msg).fadeIn(1000);
		$('.subscription-error').fadeOut(500);

	} else if(resp.result === 'error') {
		$('.subscription-error').html('<i class="icon_close_alt2"></i><br/>' + resp.msg).fadeIn(1000);
	}
}

/* =================================
===  STICKY NAV                 ====
=================================== */

$(document).ready(function() {
$('.main-navigation').onePageNav({
	scrollThreshold: 0.2, // Adjust if Navigation highlights too early or too late
	filter: ':not(.external)',
	changeHash: true
});

});


/* COLLAPSE NAVIGATION ON MOBILE AFTER CLICKING ON LINK - ADDED ON V1.5*/

if (matchMedia('(max-width: 0)').matches) {
	$('.main-navigation a').on('click', function () {
		$(".navbar-toggle").click();
	});
}


/* NAVIGATION VISIBLE ON SCROLL */

$(document).ready(function () {
	mainNav();
});

$(window).scroll(function () {
	mainNav();
});

if (matchMedia('(min-width: 992px), (max-width: 767px)').matches) {
function mainNav() {
		var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
		if (top > 40) $('.sticky-navigation').stop().animate({"top": '0'});

		else $('.sticky-navigation').stop().animate({"top": '-60'});
	}
}

if (matchMedia('(min-width: 768px) and (max-width: 991px)').matches) {
function mainNav() {
		var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
		if (top > 40) $('.sticky-navigation').stop().animate({"top": '0'});

		else $('.sticky-navigation').stop().animate({"top": '-120'});
	}
}



/* =================================
===  DOWNLOAD BUTTON CLICK SCROLL ==
=================================== */
jQuery(function( $ ){
			$('#download-button').localScroll({
				duration:1000
			});
		});

/* =================================
===  VIDEO BACKGROUND           ====
=================================== */
if (matchMedia('(min-width: 640px)').matches) {

$(document).ready(function() {
	var videobackground = new $.backgroundVideo($('body'), {
	"align": "centerXY",
	"width": 1280,
	"height": 720,
	"path": "http://digital-store-video.s3.amazonaws.com/",
	"filename": "video",
	//"url":"http://digital-store-video.s3.amazonaws.com/video.mp4",
	"types": ["mp4","ogg","webm"],
	"src" : [
		"http://digital-store-video.s3.amazonaws.com/"
	]
	});
});

}


/* =================================
===  FULL SCREEN HEADER         ====
=================================== */
function alturaMaxima() {
var altura = $(window).height();
$(".full-screen").css('min-height',altura);

}

$(document).ready(function() {
alturaMaxima();
$(window).bind('resize', alturaMaxima);
});


/* =================================
===  SMOOTH SCROLL             ====
=================================== */
var scrollAnimationTime = 1200,
	scrollAnimation = 'easeInOutExpo';
$('a.scrollto').bind('click.smoothscroll', function (event) {
	event.preventDefault();
	var target = this.hash;
	$('html, body').stop().animate({
		'scrollTop': $(target).offset().top
	}, scrollAnimationTime, scrollAnimation, function () {
		window.location.hash = target;
	});
});


/* =================================
===  WOW ANIMATION             ====
=================================== */
wow = new WOW(
{
	mobile: false
});
wow.init();


/* =================================
===  OWL CROUSEL               ====
=================================== */
$(document).ready(function () {

	$("#feedbacks").owlCarousel({

		navigation: false, // Show next and prev buttons
		slideSpeed: 800,
		paginationSpeed: 400,
		autoPlay: 5000,
		singleItem: true
	});

	var owl = $("#screenshots");

	owl.owlCarousel({
		items: 4, //10 items above 1000px browser width
		itemsDesktop: [1000, 4], //5 items between 1000px and 901px
		itemsDesktopSmall: [900, 2], // betweem 900px and 601px
		itemsTablet: [600, 1], //2 items between 600 and 0
		itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
	});


});


/* =================================
===  Nivo Lightbox              ====
=================================== */
$(document).ready(function () {

	$('#screenshots a').nivoLightbox({
		effect: 'fadeScale',
	});

});


/* =================================
===  SUBSCRIPTION FORM          ====
=================================== */
// $("#subscribe").submit(function (e) {
//     e.preventDefault();
//     var email = $("#subscriber-email").val();
//     var dataString = 'email=' + email;
//
//     function isValidEmail(emailAddress) {
//         var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
//         return pattern.test(emailAddress);
//     };
//
//     if (isValidEmail(email)) {
//         $.ajax({
//             type: "POST",
//             url: "subscribe/subscribe.php",
//             data: dataString,
//             success: function () {
//                 $('.subscription-success').fadeIn(1000);
//                 $('.subscription-error').fadeOut(500);
//                 $('.hide-after').fadeOut(500);
//             }
//         });
//     } else {
//         $('.subscription-error').fadeIn(1000);
//     }
//
//     return false;
// });




/* =================================
===  CONTACT FORM          ====
=================================== */
//ラジオボタンがクリックされたらアクティブ
$('.js-checkRadio').click(function () {
	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
	} else {
		$(this).addClass('active');
	}
	return false;
});

//フォームの送信処理が実行された時にイベント通知
$("#modalForm").submit(function (e) {
	e.preventDefault();
	var radio =  $('.js-checkRadio:active input[type="radio"]');
	var company = $('#ConpanyName').val();
	var name = $("#Username").val();
	var email = $("#InputEmail").val();
	var tell = $('#PhoneNumber').val();
	var message = $("#InputTextarea").val();
	var dataStr = 'radio=' + radio + '&company=' + company + '&name=' + name + '&email=' + email + '&tell=' + tell + '&dataStr=' + dataStr;


	//メールアドレスのバリデーション
	function isValidEmail(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	};

	//メールアドレスが有効の場合ajaxでdataStrをphpへ送信
	if (isValidEmail(email) && (name.length > 1) && (message.length > 1) &&  (radio.is(checked))) {
		$.ajax({
			type: "POST",
			url: "sendmail.php",
			data: dataStr,
			success: function () {
				$('.success').fadeIn(1000);
				$('.error').fadeOut(500);
			}
		});
	} else {
		$('.error').fadeIn(1000);
		$('.success').fadeOut(500);
	}

	return false;
});




/* =================================
===  EXPAND COLLAPSE            ====
=================================== */
$('.expand-form').simpleexpand({
	'defaultTarget': '.expanded-contact-form'
});



/* =================================
===  STELLAR                    ====
=================================== */
$(window).stellar({
horizontalScrolling: false
});


/* =================================
===  Bootstrap Internet Explorer 10 in Windows 8 and Windows Phone 8 FIX
=================================== */
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
var msViewportStyle = document.createElement('style')
msViewportStyle.appendChild(
	document.createTextNode(
	'@-ms-viewport{width:auto!important}'
	)
)
document.querySelector('head').appendChild(msViewportStyle)
}

/* =================================
===  Modal checkbox             ====
=================================== */




$('.isopanel').isotope({
	filter: '*',
	animationOptions: {
		duration: 250,
		easing: 'linear',
		queue: false
	}
});

$('.filter-button-group button').click(function(){
var selector = $(this).attr('data-filter');
$('.isopanel').isotope({filter: selector});
return false;
});

/* modal dialog */
$('img[data-toggle="modal"]').click(function (){

	var video = $("<iframe id='ui-iframe' width='560' height='315' src='" + $(this).attr('data-procname') + "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>");
	$('.modal-title', '#modalPreviewWindow').html($(this).siblings('.ui-video-detail').find('.video-title').text());
	$('.video-detail', '#modalPreviewWindow').html($(this).siblings('.ui-video-detail').find('.video-detail:hidden').text());
	$('div.ui-modal-video', '#modalPreviewWindow').html(video);
});

$('#modalPreviewWindow').on('shown.bs.modal', function (e) {
	$('.modal-backdrop').css("opacity",0.9);
});

$('#modalPreviewWindow').on('hidden.bs.modal', function (e) {
	$('div.ui-modal-video', '#modalPreviewWindow').html('');
	$('div.video-detail', '#modalPreviewWindow').html('');
});

setTimeout(function(){
$('.ui-button-all').click();
}, 1000);