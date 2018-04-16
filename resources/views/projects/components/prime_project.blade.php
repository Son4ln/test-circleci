<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.business')</th>
<td>
	{{ config('const.business_type.' . $project->business_type) }} <br>
	{{ $project->business_name }} <br>
	{!! url2anker($project->business_url) !!}
</td>
</tr>
<tr>
<th class="pr_tb_tit">@lang('projects.show.prime_purpose')</th>
<td>{{ config('const.project_purpose.' . $project->purpose)[0] }}</td>
</tr>
<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.target')</th>
<td>{{ $project->target_product }}</td>
</tr>
<tr>
<th class="pr_tb_tit">@lang('projects.show.describe')</th>
<td>
	<div class="well">
	{!! nl2br($project->point) !!}
	</div>
	<div class="well">
	{!! nl2br($project->describe) !!}
	</div>
</td>
</tr>
<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.keywords')</th>
<td>
	{{ $project->keyword1 }},
	{{ $project->keyword2 }},
	{{ $project->keyword3 }}
</td>
</tr>
<tr>
<th class="pr_tb_tit">@lang('projects.show.moviesec')</th>
<td>{{ $project->moviesec_min }}秒 ~ {{ $project->moviesec_max }}秒</td>
</tr>
<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.similar_video')</th>
<td><img src="https://s3-ap-northeast-1.amazonaws.com/crluo/assets/images/movie{{ $project->similar_video }}.gif" width="300" height="200"></td>
</tr>
<tr>
<th class="pr_tb_tit">@lang('projects.show.scale')</th>
<td>{{ config('const.project_aspect.' . $project->aspect) }}</td>
</tr>
<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.expired_at')</th>
<td>{{$project->expired_at ? $project->expired_at->format('Y/m/d') : '---'}}</td>
</tr>
<tr>
<th class="pr_tb_tit">@lang('projects.show.delivered_at')</th>
<td>{{ $project->duedate_at ? $project->duedate_at->format('Y/m/d') :  trans('projects.show.delivered_at_null')}}   </td>
</tr>
<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.reference')</th>
<td>
	@if (is_array($project->info_files))
	@foreach ($project->info_files as $file)
		<a href="{{ $file['path'] }}" download="{{ $file['name'] }}">{{ $file['name'] }}</a> <br>
	@endforeach
	@endif

	@if ($project->reference_url)
	ＵＲＬ：{!! url2anker($project->reference_url) !!}
	@endif
</td>
</tr>
<tr>
<th class="pr_tb_tit">@lang('projects.show.standard')</th>
<td>
	@if (is_array($project->standard_files))
	@foreach ($project->standard_files as $file)
		<a href="{{ $file['path'] }}" download="{{ $file['name'] }}">{{ $file['name'] }}</a> <br>
	@endforeach
	@endif

	@if ($project->standard_url)
	ＵＲＬ：{!! url2anker( $project->standard_url) !!}
	@endif
</td>
</tr>
<tr class="tb_2">
<th class="pr_tb_tit">@lang('projects.show.material')</th>
<td>
	@if (is_array($project->attachments))
	@foreach ($project->attachments as $file)
		<a href="{{ $file['path'] }}" download>{{ $file['name'] }}</a> <br>
	@endforeach
	@endif
</td>
</tr>
