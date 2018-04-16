@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title u-title-color">@lang('projects.creator_list.title')</h4>
</div>
@endsection

@section('content')

<div class="white-box">
	@if($projects->count() === 0)
	<div class="box-body">
		@lang('projects.creator_list.no_item')
	</div>
	@else
	<div class="">
		@foreach ($projects as $project)
			@php
			//Build project_display_image
			if($project->image){
				$project_display_image = Storage::disk('s3')->url($project->image);
			}else{
				if (!empty($project->user_background)) {
		            $project_display_image = Storage::disk('s3')->url(ltrim($project->user_background, "/"));
		        }else{
		        	$project_display_image = null;
		    	}
			}
			//End build project_display_image
			@endphp

		<!-- Three columns of text below the carousel -->

		<div class="col-md-4 " >
			<div class="project-index">
				<a style="background:url({{ !empty($project_display_image) ? $project_display_image : 'images/avatar_blank.jpg' }}) no-repeat;height: 252px;   background-position: center center;	display: block;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;" class="panel-heading user-thumb-project" href="{{ url('projects/'.$project->id) }}"
				data-procname="{{$project->id}}">
				<div style='position:absolute;top:189px;left:40px'>
					<h4 class="wrap" >
					@if ($project->status == $project->statuses['public'])
						<div class="label new-label">@lang('projects.creator_list.recruiting')</div>
					@else
						<div class="label new-label">@lang('projects.creator_list.ended')</div>
					@endif
					</h4>
				</div>
				</a>
				<div class="panel-body">
				<label style="margin-top:10px;font-weight:bold">{{str_limit(str_replace('"','',$project->title),40,'...')}}</label><br>
				<div style="margin-top:10px;color:#909090">
					@lang('projects.list.budget') :
					@if ($project->is_price_undecided)
					<span>---</span>
					@else
					{{$project->price_min}}万円 ～ {{$project->price_max}}万円
					@endif
				</div>
				<div style="margin-top:10px;color:#909090">
					@lang('projects.list.duedate_at') :
					{{$project->duedate_at ? $project->duedate_at->format('Y/m/d') :  trans('projects.list.delivered_at_null')	}}
				</div>
				<div style="margin-top:10px;color:#909090">@lang('projects.list.expired_at') :{{$project->expired_at ? $project->expired_at->format('Y/m/d') : '---'}}</div>
				<div >
					<br>

					{{--          <button class="btn  ghost_gray"  onclick='$("#proj{{$project->id}}").submit()'><span class='glyphicon glyphicon-blackboard'></span>Project</button> --}}
				</div>

				</div>

			</div>
		</div>

		@endforeach
		<div style="width: 100%">
		{{ $projects->render() }}
		</div>
	</div>
	@endif
	<div class="clearfix"></div>
</div>

@endsection

@push('scripts')
<script src="/js/jquery.isotope.js" type="text/javascript"></script>
<script>
$(document).ready(function () {

	var $container = $('.isopanel');
	$container.isotope({
	filter: '*',
	animationOptions: {
		duration: 250,
		easing: 'linear',
		queue: false
	}
	});
});
</script>
@endpush
<style type="text/css">
	.panel-heading{
		border: 0 !important;
	}
</style>
