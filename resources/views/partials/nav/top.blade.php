<!-- Search input and Toggle icon -->
<ul class="nav navbar-top-links navbar-left">
@if (auth()->check())
	<li class="menu-change mytooltip hidden-sp"><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-angle-left"></i></a><span class="tooltip-content2">メニューを閉じる</span><span class="tooltip-content2 cont tootip-dis">メニューを開く</span></li>

	<li class="menu-change mytooltip hidden-pc"><a href="#" class="open-close1 waves-effect waves-light"><i class="ti-angle-left"></i></a><span class="tooltip-content2">メニューを閉じる</span><span class="tooltip-content2 cont tootip-dis">メニューを開く</span></li>

	<li class="dropdown messages-menu">
	<a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-message"></i>
		<div class="notify {{ $unreadMessage ? '' : 'hidden' }}"><span class="heartbit"></span><span class="point"></span></div>
	</a>
	<ul class="dropdown-menu mailbox animated slideInUp">
		<li class="text-center">
		<i class="fa fa-refresh fa-spin"></i>
		<span class="sr-only">Loading...</span>
		</li>
	</ul>
	<!-- /.dropdown-messages -->
	</li>
	<!-- .Task dropdown -->
	<li class="dropdown notification-menu">
	<a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"> <i class="mdi mdi-bell"></i>
		<div class="notify {{ $unreadNof ? '' : 'hidden' }}"><span class="heartbit"></span><span class="point"></span></div>
	</a>
	<ul class="dropdown-menu dropdown-tasks animated slideInUp">
		<li class="text-center">
		<i class="fa fa-refresh fa-spin"></i>
		<span class="sr-only">Loading...</span>
		</li>
	</ul>
	</li>
	<!-- .Megamenu -->
	{{-- <li class="mega-dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">ヘルプ</span> <i class="icon-options-vertical"></i></a>
	<ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
		<li class="col-sm-3">
		<ul>
			<li class="dropdown-header">使い方</li>
			<li><a href="javascript:void(0)">Link of page</a> </li>
		</ul>
		</li>
		<li class="col-sm-3">
		<ul>
			<li class="dropdown-header">ヘルプ</li>
			<li><a href="javascript:void(0)">Link of page</a> </li>
		</ul>
		</li>
		<li class="col-sm-3">
		<ul>
			<li class="dropdown-header">お問い合わせ</li>
			<li><a href="javascript:void(0)">Link of page</a> </li>
		</ul>
		</li>
		<li class="col-sm-3">
		<ul>
			<li class="dropdown-header">予備</li>
			<li> <a href="javascript:void(0)">Link of page</a> </li>
		</ul>
		</li> --}}
	</ul>
	</li>
@endif
<!-- /.Megamenu -->
</ul>
<!-- This is the message dropdown -->
<ul class="nav navbar-top-links navbar-right pull-right">
<!-- /.Task dropdown -->
<!-- /.dropdown -->
<!--
<li>
<form role="search" class="app-search hidden-sm hidden-xs m-r-10">
<input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
</li>
-->
@if (auth()->check())
	<li class="dropdown">
	<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
		<img src="{{ @@auth()->user()->photoThumbnailUrl  }}" alt="user-img" width="36" class="img-circle"
			onerror="this.src='/images/user.png'">
		<b class="hidden-xs" id="original_name">{{ auth()->user()->name }}</b><span class="caret"></span>
	</a>
	<ul class="dropdown-menu dropdown-user animated flipInY">
		<li>
		<div class="dw-user-box">
			<div class="u-img"><img src="{{ @@auth()->user()->photoThumbnailUrl }}" alt="User Image"
				onerror="this.src='/images/user.png'"></div>
			<div class="u-text">
			<h4>{{ auth()->user()->name }}</h4>
	    <small>{{ auth()->user()->facebook_name }}</small>
			<p class="text-muted">{{ auth()->user()->email }}</p>
			<a href="{{ url('profile') }}" class="btn btn-rounded btn-danger btn-sm mor-update-color">
				@lang('navigation.profile.title')
			</a>
			</div>
		</div>
		</li>
		<li role="separator" class="divider"></li>
		@if (auth()->user()->isClient() && auth()->user()->isCreator())
		<li>
			<a href="{{ url('switch') }}">
			<i class="ti-user"></i>
			@if (request()->cookie('mode') == 'creator')
				{{ __('navigation.profile.client_mode') }}
			@else
				{{ __('navigation.profile.creator_mode') }}
			@endif
			</a>
		</li>
		@endif
		<li><a href="{{ url('messages') }}"><i class="ti-email"></i> {{ __('navigation.profile.messages') }}</a></li>
		<li><a href="{{ url('payments') }}"><i class="ti-money"></i> {{ __('navigation.profile.payments') }}</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="{{ url('profile/account') }}"><i class="ti-settings"></i> {{ __('navigation.profile.account') }}</a></li>
		<li role="separator" class="divider"></li>
		<li>
		<a href="{{ route('logout') }}"
			onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
			<i class="fa fa-power-off"></i> {{ __('navigation.profile.log_out') }}
		</a>
		</li>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		{{ csrf_field() }}
		</form>
	</ul>
	<!-- /.dropdown-user -->
	</li>
@else
	<li><a href="{{ url('/login') }}">@lang('ui.login')</a></li>
	<li><a href="{{ url('/register') }}">@lang('ui.register')</a></li>
@endif
<!-- /.dropdown -->
</ul>
<script type="text/javascript">

	$( ".open-close" ).click(function() {
		if($('.open-close i').hasClass('ti-angle-right')){
			$('.open-close i').removeClass('ti-angle-right').addClass('ti-angle-left');
		}
		else {
			$('.open-close i').removeClass('ti-angle-left').addClass('ti-angle-right');
		}
	});

	$( ".open-close" ).click(function() {
		if($('.menu-change span.cont').hasClass('tootip-bl')){
			$('.menu-change span.cont').removeClass('tootip-bl').addClass('tootip-dis');
		}
		else {
			$('.menu-change span.cont').removeClass('tootip-dis').addClass('tootip-bl');
		}
	});
	$(document).ready(function(){
		$('.open-close1').on('click', function () {
		  $(".side_none").toggleClass('side_block').focus();
		  $(".side_none").toggleClass('fadeInLeft').focus();
		});
		$('.open-close2').on('click', function () {
			$(".side_none").removeClass("side_block");
			$(".side_none").removeClass('fadeInLeft');
		});
		$('.side_none').on({
		  blur: function () {
		    $(this).data('timer', setTimeout(function () {
		      $(this).removeClass('side_block');
		      $(this).removeClass('fadeInLeft');
		    }.bind(this), 0));
		  },
		  focusin: function () {
		    clearTimeout($(this).data('timer'));
		  }
		});
	});
</script>
