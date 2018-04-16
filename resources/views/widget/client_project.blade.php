<div class="white-box">

<div class="luc-project col-modify">
	@foreach ($projects as $project)


		@php
		if ($project->image) {
            $project_display_image = Storage::disk('s3')->url($project->image);
        } else {
            $project_display_image = !empty($project->user_background) ? Storage::disk('s3')->url(ltrim($project->user_background, "/")) : null ;
        }

		@endphp


		<div style="padding-left: 15px;padding-right: 15px;" class="col-lg-3 col-md-4 col-sm-6 col-xs-12">

				<div class="l-box-shadow " >
						<div class="box-contain-image">
						<a class=" user-thumb-project" href="{{ url('projects/'.$project->id) }}" data-procname="{{$project->id}}">

							<img class='user-thumb-project' src='{{ $project_display_image }}' onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"><img>
							<div class="item-status">

								<h4 class="wrap">
								<div class="label {{ $project->status_label }} l-label-update {{$project->status}}">
									{{ config('const.project_status.' . $project->status) }}
								</div>
								</h4>
							</div>
						</a>
						</div>

						<div class="panel-body" style="min-height: 136px">
							<label class="title-modify"><strong>{{str_replace('"','',$project->title)}}</strong></label>
							<div>{{$project->detail}}</div>

							<form method='post' action='/work' id='proj{{$project->id}}' style="margin: 10px 0">
								<input type='hidden' name='project_id' value='{{$project->id}}'>
								<input type='hidden' name='_token' value='{{{ csrf_token() }}}'>
								@can ('update', $project)
								<a class="" href="{{ url('projects/'.$project->id.'/edit') }}" style="font-size: 15px;"><div class="l-update-icon"></div>@lang('projects.creator_list.edit')</a>
								@endcan
							</form>
							<div class="p-client-date">
								<small class="" style="padding-bottom: 5px;">依頼日</small>
								<small class="" style="padding-left: 10px;">{{date('Y/m/d ',strtotime($project->updated_at))}}</small>
							</div>

						</div>
						<div class="clearfix">
						</div>
					</div>


		</div>
	@endforeach
	
	<div class="clearfix"></div>
</div>
<div style="width: 100%">
{{ $projects->render() }}
</div>
<div class="p-client-footer">
	
	<center>
		<a href="{{ url('projects/create') }}">
			<button class="btn btn-info">@lang('projects.list.create_project_link')</button>
		</a>
	</center>
	<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>

<script src="/js/jquery.isotope.js" type="text/javascript"></script>
<script>
	var $container = $('.isopanel');
	/* $container.isotope({
		filter: '*',
		animationOptions: {
			duration: 250,
			easing: 'linear',
			queue: false
		}
	}); */

$('span.ui-edit').click(function (){

		$('div.modal-body', '#modalWindow').html("");
		$('.modal-title', '#modalWindow').html("プロジェクト登録");
		$('div.modal-body', '#modalWindow').load('/ajax/project/add', {'_token':'{{{ csrf_token() }}}', 'id': name}, function(response, status, xhr) {
		if (status == "error") {
			$('div.modal-body', '#modalWindow').html(xhr.responseText);
		}
		});
	});
	// $('div.user-thumb-project').click(function (){
		// $('div.modal-body', '#modalWindow').html("");
		// $('.modal-title', '#modalWindow').html("プロジェクト");
		// $('div.modal-body', '#modalWindow').load('/projects/' + $(this).attr('data-procname'), function(response, status, xhr) {
		//   if (status == "error") {
		//     $('div.modal-body', '#modalWindow').html(xhr.responseText);
		// }
		// });
	// });
	$('a.ui-edit-project').click(function (){
		$('div.modal-body', '#modalWindow').html("");
		$('.modal-title', '#modalWindow').html("プロジェクト編集");
		$('div.modal-body', '#modalWindow').load('/ajax/project/get', {'_token':'{{{ csrf_token() }}}', 'id': $(this).attr('data-procname')}, function(response, status, xhr) {
		if (status == "error") {
			$('div.modal-body', '#modalWindow').html(xhr.responseText);
		}
		});
	});

</script>
