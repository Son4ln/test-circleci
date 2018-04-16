@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('prime_projects.list.title')</h4>
</div>
@endsection

@section('content')
<section class="white-box">
	<a href="{{ route('prime-projects.create') }}">
		<button class="btn btn-primary background-05348b btn-list-koushin-border">@lang('prime_projects.list.create')</button>
	</a>
<hr>
@if($projects->count() === 0)
	<div class="box-body">
	@lang('projects.creator_list.no_item')
	</div>
@else
	<div class="isopanel">
	@foreach ($projects as $project)
		<!-- Three columns of text below the carousel -->
		<div class="panel panel-default user-panel-project" >
		<a class="panel-heading user-thumb-project" href="{{ url('projects/'.$project->id) }}" data-procname="{{$project->id}}">
			<img class='user-thumb-project' src='{{ $project->display_image }}' onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"><img>
			<div style='position:absolute;top:0;left:10px'>
			<h4 class="wrap">
				<div class="label {{ $project->status_label }}">
					{{ config('const.project_status.' . $project->status) }}
				</div>
			</h4>
			</div>
		</a>
		<div class="panel-body">
			<label>{{str_replace('"','',$project->title)}}</label><br>
			<div>{{$project->detail}}</div>
			<div>
			<br>
			</div>
		</div>
		<div class='panel-footer'>
			<form method='post' action='/work' id='proj{{$project->id}}'>
			<input type='hidden' name='project_id' value='{{$project->id}}'>
			<input type='hidden' name='_token' value='{{{ csrf_token() }}}'>
			@can ('update', $project)
				<a class="glyphicon glyphicon-pencil" href="{{ route('prime-projects.edit', ['id' => $project->id]) }}">@lang('projects.creator_list.edit')</a>
			@endcan
			<small class='pull-right'>{{date('Y/m/d ',strtotime($project->updated_at))}}</small>
			<div class="clearfix"></div>
			</form>
		</div>
		</div>
	@endforeach
	<div style="width: 100%">
		{{ $projects->render() }}
	</div>
	</div>
@endif
</section>
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
