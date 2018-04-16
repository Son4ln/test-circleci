<div class="navbar-default sidebar side_none animated" role="navigation" id="menu" tabindex="-1">
<div class="sidebar-nav slimscrollsidebar">
	<div class="sidebar-head">
	<h3 class="mor-h3-color"><a href="#menu" class="open-close2"><i class="ti-close"></i></a> <span class="hidden-pc">{{ __('navigation.title') }}</span></h3>
	</div>
	<ul class="nav" id="side-menu">
	<li><a href="{{ route('creative-rooms.index') }}" class="waves-effect"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="">{{ __('navigation.c_base.title') }}</span></a></li>

	<li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="">{{ __('navigation.c_project_board.title') }}<span class="fa arrow"></span></span></a>
		<ul class="nav nav-second-level">
		@if (auth()->user()->isClient() && $mode == 'client')
			{{-- <li><a href="javascript:void(0)"><i data-icon=")" class="linea-icon linea-basic fa-fw"></i><span class="">What's C-Project Board</span></a></li> --}}
			<li><a href="{{ route('projects.create') }}"><i class="ti-pencil fa-fw"></i><span class=""> {{ __('navigation.c_project_board.project_create') }}</span></a></li>
			<li><a href="{{ route('projects.client') }}"><i class="ti-comments fa-fw"></i><span class=""> {{ __('navigation.c_project_board.client_projects_list') }}</span></a></li>
			<li><a href="{{ route('creators.index') }}"><i class="ti-user fa-fw"></i><span class=""> {{ __('navigation.c_project_board.creators_search') }}</span></a></li>
			<li><a href="{{ route('portfolios.index') }}"><i class="ti-camera fa-fw"></i><span class=""> {{ __('navigation.c_project_board.portfolios_search') }}</span></a></li>
			<li><a href="{{ route('payments.index') }}"><i class="ti-layers fa-fw"></i><span class=""> {{ __('navigation.c_project_board.payment_list') }}</span></a></li>
		@endif
		@if (auth()->user()->isCreator() && $mode == 'creator')
			{{-- <li><a href="javascript:void(0)"><i data-icon=")" class="linea-icon linea-basic fa-fw"></i><span class="">What's C-Project Board</span></a></li> --}}
			<li><a href="{{ route('projects.index') }}"><i class="ti-menu-alt fa-fw"></i><span class=""> {{ __('navigation.c_project_board.projects_search') }}</span></a></li>
			<li><a href="{{ route('proposals.index') }}"><i class="ti-layout-list-post fa-fw"></i><span class=""> {{ __('navigation.c_project_board.proposals_list') }}</span></a></li>
			<li><a href="{{ route('rewords.index') }}"><i class="fa fa-usd fa-fw"></i><span class=""> {{ __('navigation.c_project_board.rewords_list') }}</span></a></li>
			<li><a href="{{ route('portfolios.create') }}"><i class="ti-camera fa-fw"></i><span class=""> {{ __('navigation.c_project_board.portfolios_create') }}</span></a></li>
			<li><a href="{{ route('portfolios.me') }}"><i class="ti-harddrives fa-fw"></i><span class=""> {{ __('navigation.c_project_board.portfolios_list') }}</span></a></li>
		@endif
		@if (!auth()->user()->isClient())
			<li><a href="{{ url('upgrade/client') }}"><i class="ti-pencil fa-fw"></i><span class=""> {{ __('navigation.c_project_board.client_register') }}</span></a></li>
		@endif
		@if (!auth()->user()->isCreator())
			<li><a href="{{ url('upgrade/creator') }}"><i class="ti-pencil fa-fw"></i><span class=""> {{ __('navigation.c_project_board.creator_register') }}</span></a></li>
		@endif
		</ul>
	</li>
	@php
		$checkAuth = auth()->user()->isAdmin();
	@endphp
	@if (auth()->user()->isClient() && $mode == 'client' && !$checkAuth)
	<li> <a href="{{ url('coperation') }}" class="waves-effect"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="">{{ __('navigation.c_operation.title') }}<!--<span class="fa arrow"></span>--></span></a>
		{{--
		<ul class="nav nav-second-level">
		<!-- <li><a href="{{ url('prime-projects/desc') }}"><i class="ti-image fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> プライムを始める</span></a></li> -->
		<li><a href="{{ route('pricing') }}"><i class="ti-shortcode fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.stripe') }}</span></a></li>
		<li><a href="{{ url('prime-projects/create') }}"><i class="ti-pencil fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.project_create') }}</span></a></li>
		<li><a href="{{ url('prime-projects') }}"><i class="ti-receipt fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.projects_list') }}</span></a></li>
		@if (!auth()->user()->facebook_id)
			<li><a href="{{ url('prime-projects/facebook-cert') }}"><i class="ti-facebook fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.facebook_connect') }}</span></a></li>
		@endif
		<li><a href="{{ url('prime-projects/facebook-report') }}"><i class="fa fa-facebook-square fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.facebook_report') }}</span></a></li>
		<li><a href="{{ url('prime-projects/facebook-alert') }}"><i class="icon-social-facebook fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.facebook_alert') }}</span></a></li>
		</ul>
		--}}
	</li>
	@endif
	
	@if ($checkAuth)
	<li> <a href="{{ url('coperation') }}" class="waves-effect"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="">{{ __('navigation.c_operation.title') }}<span class="fa arrow"></span></span></a>
		
		<ul class="nav nav-second-level">
		<!-- <li><a href="{{ url('prime-projects/desc') }}"><i class="ti-image fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> プライムを始める</span></a></li> -->
		<li><a href="{{ route('pricing') }}"><i class="ti-shortcode fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.stripe') }}</span></a></li>
		<li><a href="{{ url('prime-projects/create') }}"><i class="ti-pencil fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.project_create') }}</span></a></li>
		<li><a href="{{ url('prime-projects') }}"><i class="ti-receipt fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.projects_list') }}</span></a></li>
		@if (!auth()->user()->facebook_id)
			<li><a href="{{ url('prime-projects/facebook-cert') }}"><i class="ti-facebook fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.facebook_connect') }}</span></a></li>
		@endif
		<li><a href="{{ url('prime-projects/facebook-report') }}"><i class="fa fa-facebook-square fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.facebook_report') }}</span></a></li>
		<li><a href="{{ url('prime-projects/facebook-alert') }}"><i class="icon-social-facebook fa-fw" class="linea-icon linea-basic fa-fw"></i><span class=""> {{ __('navigation.c_operation.facebook_alert') }}</span></a></li>
		</ul>
	</li>
	@endif
	@if (auth()->user()->isAdmin())
		<li> <a href="javascript:void(0)" class="waves-effect"><i data-icon="/" class="linea-icon linea-basic fa-fw"></i><span class="">{{ __('navigation.admin_menu.title') }}<span class="fa arrow"></span></span></a>
		<ul class="nav nav-second-level">
			<li><a href="{{ route('notifications.index') }}"><i data-icon=")" class="ti-bell fa-fw"></i><span class=""> {{ __('navigation.admin_menu.notifications') }}</span></a></li>
			<li><a href="{{ route('admin') }}"><i class="ti-user fa-fw"></i><span class=""> {{ __('navigation.admin_menu.users') }}</span></a></li>
			<li><a href="{{ route('project-states.index') }}"><i class="ti-mobile fa-fw"></i><span class=""> {{ __('navigation.admin_menu.projects') }}</span></a></li>
			<li><a href="{{ route('admin.rooms') }}"><i class="ti-layers-alt fa-fw"></i><span class=""> {{ __('navigation.admin_menu.rooms_menu') }}</span></a></li>
			<li><a href="{{ route('admin.messages') }}"><i class="ti-comments fa-fw"></i><span class="">{{ __('navigation.admin_menu.messages') }}</span></a></li>
			<li><a href="{{ route('broadcast.index') }}"><i class="ti-email fa-fw"></i><span class=""> {{ __('navigation.admin_menu.mails') }}</span></a></li>
	<li><a href="{{ route('admin.c_operation.index') }}"><i class="ti-shortcode fa-fw"></i> <span class="">@lang('navigation.admin_menu.stripe')</span></a></li>
<!--
			<li><a href="{{ route('roles.index') }}"><i class="ti-wand fa-fw"></i><span class=""> 権限変更</span></a></li>
			<li><a href="{{ route('permissions.index') }}"><i class="ti-ruler fa-fw"></i><span class=""> 権限定義</span></a></li>
			<li><a href="{{ url('projects/admin') }}"><i class="ti-desktop fa-fw"></i><span class=""> 仕事の管理</span></a></li>
			<li><a href="{{ route('approval') }}"><i class="ti-hand-drag fa-fw"></i><span class=""> プロジェクト承認</span></a></li>
-->
		</ul>
		</li>
	@endif
	</ul>
</div>
</div>
