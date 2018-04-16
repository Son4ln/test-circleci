<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="description"
	content="動画制作、映像制作のクラウドソーシングならCRLUO【クルオ】にお任せ下さい。動画マーケティングもお任せ！全国の動画・映像クリエイターに直接発注。低価格で調子つな動画制作を提供。">
<meta name="keywords" content="動画制作, 映像制作, クラウドソーシング">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SITE TITLE -->
<title>動画制作/映像制作マーケティングならCRLUO【クルオ】</title>

<!-- =========================
	FAV AND TOUCH ICONS
============================== -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}">
<link rel="mask-icon" href="{{ asset('images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">

<!-- =========================
	STYLESHEETS
============================== -->
<!-- BOOTSTRAP -->

{{ Html::style('home/css/bootstrap.min.css') }}
<!-- FONT ICONS -->
{{ Html::style('home/assets/elegant-icons/style.css') }} {{
Html::style('home/assets/app-icons/styles.css') }}
<!--[if lte IE 7]><script src="lte-ie7.js"></script><![endif]-->

<!-- WEB FONTS -->
<link
	href='https://fonts.googleapis.com/css?family=Roboto:100,300,100italic,400,300italic'
	rel='stylesheet' type='text/css'>

<!-- CAROUSEL AND LIGHTBOX -->
{{ Html::style('home/css/owl.theme.css') }} {{
Html::style('home/css/owl.carousel.css') }} {{
Html::style('home/css/nivo-lightbox.css') }} {{
Html::style('home/css/nivo_themes/default/default.css') }}

<!-- ANIMATIONS -->
{{ Html::style('home/css/animate.min.css') }}

<!-- CUSTOM STYLESHEETS -->
{{ Html::style('home/portfolio/css/styles.css') }}

<!-- COLORS -->
{{ Html::style('home/css/colors/blue-munsell.css') }}
<!-- RESPONSIVE FIXES -->
{{ Html::style('home/css/responsive.css') }}

<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
<![endif]-->

<!-- JQUERY -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<!-- Global site tag (gtag.js) - Google AdWords: 815676858 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-815676858"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'AW-815676858');
	</script>
</head>

<body>
	<!-- =========================
	PRE LOADER
	============================== -->
	<div class="preloader">
		<div class="status">&nbsp;</div>
	</div>

	<!-- =========================
	HEADER
	============================== -->
	<header class="header">

		<!-- COLOR OVER IMAGE -->
		<div class="color-overlay">
			<!-- To make header full screen. Use .full-screen class with color overlay. Example: <div class="color-overlay full-screen">  -->

			<!-- STICKY NAVIGATION -->
			<div
				class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
				@include('partials.home.nav.top_menu')</div>
			<!-- /END STICKY NAVIGATION -->


			<!-- CONTAINER -->
			<div class="container">
				<!-- ONLY LOGO ON HEADER -->
				<div class="only-logo">
					<div class="navbar">
						<div class="navbar-header">
							<h1 class="intro">ポートフォリオ</h1>
							<!-- crluo image -->
							<div class="section-description">
								CRLUOが制作した映像実績の一部です。<br> 商品紹介からミュージックビデオまで、幅広いクリエイションが可能です。
							</div>
						</div>
					</div>
				</div>
				<!-- /END ONLY LOGO ON HEADER -->

			</div>
			<!-- /END CONTAINER -->
		</div>
		<!-- /END COLOR OVERLAY -->
	</header>
	<!-- /END HEADER -->



	<!-- =========================
	case_study video.webm
============================== -->
	<section class="services" id="case_study">

		<div class="container">

			<!-- SECTION HEADER -->
			<div class="section-header wow fadeIn animated" data-wow-offset="10"
				data-wow-duration="1.5s">

				<!-- SECTION TITLE -->
				<h2 class="dark-text">
					CRLUOの<br class="resp_br">制作実績紹介
				</h2>

				<div class="colored-line"></div>
				<div class="section-description">制作実績の紹介をします。</div>
				<div class="colored-line"></div>

			</div>
			<!-- /END SECTION HEADER -->

			<div class="row">@yield('content')</div>
			<!-- /END ROW -->

			<div class="rows">
				<h3>●年間取引件数 2,000件●</h3>
				<p>
					<span>ー映像業界7年間の信頼と実績ー</span><br>実写～アニメーション、CGまで対応
				</p>
			</div>

		</div>
		<!-- /END CONTAINER -->

	</section>
	<!-- /END FEATURES SECTION -->


	<!-- Modal -->
	<div class="modal fade" id="modalPreviewWindow" tabindex="-1"
		role="dialog" aria-labelledby="modalPreviewLabel" aria-hidden="true"
		h=0 w=0>
		<div class="modal-dialog " style="width: 90%">
			<div class="modal-content"
				style="color: #f0f0f0; background-color: #000;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close" style="color: #fff;">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body text-center">
					<div class='ui-modal-video'></div>
				</div>
				<div class="modal-footer " style='text-align: left;'>
					<div class="video-detail"></div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
	<section class="download" id="download">

		<div class="color-overlay">

			<div class="container">
				<div class="row">
					<!-- DOWNLOAD BUTTONS AREA -->
					<div class="download-container">
						<h2 class=" wow fadeInLeft animated animated" data-wow-offset="10"
							data-wow-duration="1.5s"
							style="visibility: visible; animation-duration: 1.5s; animation-name: fadeInLeft;">Crluoに登録する</h2>
						<a href="https://app.crluo.com/register" target="_blank"><button
								type="submit" class="btn btn-default standard-button">新規登録</button></a>
					</div>
					<!-- END OF DOWNLOAD BUTTONS AREA -->
				</div>
				<!-- END ROW -->

			</div>
			<!-- /END CONTAINER -->
		</div>
		<!-- /END COLOR OVERLAY -->

	</section>


	<!-- =========================
	FOOTER
	============================== -->
	<footer>

		@include('partials.home.nav.footer')
		<!-- /END CONTAINER -->

	</footer>
	<!-- /END FOOTER -->

<style>
	video.preview {
	max-width:90%;
	height:auto;
	}
	.ui-portfolio-detail {
		color:#bbbbbb;
		text-align:left;
		padding: 5px;
		padding-left:20px;padding-right:20px;display:none;
	}
</style>

	<!-- =========================
	SCRIPTS
============================== -->

	{{ Html::script('home/js/bootstrap.min.js') }} {{
	Html::script('home/js/jquery.scrollTo.min.js') }} {{
	Html::script('home/js/jquery.scrollTo.min.js') }} {{
	Html::script('home/js/jquery.localScroll.min.js') }} {{
	Html::script('home/js/owl.carousel.min.js') }} {{
	Html::script('home/js/nivo-lightbox.min.js') }} {{
	Html::script('home/js/simple-expand.min.js') }} {{
	Html::script('home/js/wow.min.js') }} {{
	Html::script('home/js/jquery.stellar.min.js') }} {{
	Html::script('home/js/retina.min.js') }} {{
	Html::script('home/js/matchMedia.js') }} {{
	Html::script('home/js/jquery.backgroundvideo.min.js') }} {{
	Html::script('home/js/jquery.nav.js') }} {{
	Html::script('home/js/jquery.ajaxchimp.min.js') }} {{
	Html::script('home/js/jquery.fitvids.js') }} {{
	Html::script('home/js/custom.js') }}
</body>
</html>
