<tr>
<th class="border-none l-project-td-left text-center">@lang('projects.show.video_style')</th>
<td class="border-none l-project-td-right">
	<ul>
	@if (is_array($project->real_or_anime))
		@foreach($project->real_or_anime as $style)
		<li>{{ config("const.project_movie_style.$style", '') }}</li>
		@endforeach
	@endif
	</ul>
</td>
</tr>
<tr>
<th class="border-none l-project-td-left text-center">@lang('projects.show.video_type')</th>
<td class="border-none">
	<ul>
	@if (is_array($project->type_of_movie))
		@foreach($project->type_of_movie as $type)
		<li>{{ config("const.project_movie_type.$type", '') }}</li>
		@endforeach
	@endif
	</ul>
</td>
</tr>
<tr >
<th class="border-none l-project-td-left text-center">@lang('projects.show.picture')</th>
<td class="border-none l-project-td-right">
	@if ($project->is_place_pref_undecided)
	<span>---</span>
	@else
	{{$project->place_pref}}
	@endif
</td>
</tr>
<tr>
<th class="border-none l-project-td-left text-center">@lang('projects.show.budget')</th>
<td class="border-none">
	@if ($project->is_price_undecided)
	<span>---</span>
	@else
	{{$project->price_min}}万円 ～ {{$project->price_max}}万円
	@endif
</td>
</tr>
<tr>
<th  class="border-none l-project-td-left text-center">@lang('projects.show.delivered_at')</th>
<td  class="border-none l-project-td-right">{{$project->duedate_at ? $project->duedate_at->format('Y/m/d') :  trans('projects.show.delivered_at_null')	}}</td>
</tr>
<tr>
<th  class="border-none l-project-td-left text-center">@lang('projects.show.expired_at')</th>
<td  class="border-none">{{$project->expired_at ? $project->expired_at->format('Y/m/d') : '---'}}</td>
</tr>
<tr>
<th  class="border-none l-project-td-left text-center">@lang('projects.show.part_of_work')</th>
<td  class="border-none l-project-td-right">
	@if (is_array($project->part_of_work))
	@foreach($project->part_of_work as $type)
		<li>{!! config("const.project_requests.{$type}", '') !!}</li>
	@endforeach
	@endif
	@if ($project->request_other)
	<pre>{{ $project->request_other }}</pre>
	@endif
</td>
</tr>
<tr>
<th  class="border-none l-project-td-left text-center">@lang('projects.show.arrange')</th>
<td  class="border-none">
	@if (is_array($project->client_arrange))
	@foreach($project->client_arrange as $type)
		<li>{!! config("const.project_requests.{$type}", '') !!}</li>
	@endforeach
	@endif
	@if ($project->client_arrange_text)
	<pre>{{ $project->client_arrange_text }}</pre>
	@endif
</td>
</tr>

<tr >
<th  class="border-none l-project-td-left text-center">@lang('projects.show.about')</th>
<td  class="border-none l-project-td-right">
	<div class="well">
	{!! nl2br($project->point) !!}
	</div>
	<div class="well">
	{!! nl2br($project->describe) !!}
	</div>
</td>
</tr>
<tr>
<th  class="border-none l-project-td-left text-center">@lang('projects.show.attachments')</th>
<td  class="border-none">
	@if ($project->attachments)
	@foreach ($project->attachments as $file)
		<a href="{{ Storage::disk('s3')->url($file['path']) }}" download>
		{{ $file['name'] }}
		</a> <br>
	@endforeach
	@endif
</td>
</tr>
