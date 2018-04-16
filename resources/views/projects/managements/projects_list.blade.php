<style media="screen">
.label-pink {
	background-color: #ff69b4 !important;
}
</style>
<table class="table table-bordered">
<tr>
	<th>@lang('project_states.list.table.title')</th>
	<th>@lang('project_states.list.table.name')</th>
	<th>@lang('project_states.list.table.budget')</th>
	<th>@lang('project_states.list.table.state')</th>
	<th></th>
</tr>
@foreach ($projects as $project)
	@php $proposal = $project->offeredProposal() @endphp
	<tr>
	<td>{{ mb_strimwidth( $project->title, 0, 30, "...") }}</td>
	<td>
		<a href="{{ route('users.show', ['id' => $project->user->id]) }}">
		{{ $project->user->name }}
		</a>
		@if ($proposal)
		/<br><a href="{{ route('users.show', ['id' => $proposal->user->id]) }}">
			{{ $proposal->user->name }}
		</a>
		@endif

	</td>
	<td>{{ $project->price_min }} 万円 - {{ $project->price_max }} 万円</td>
	<td>
		<div class="label {{ $project->status_label }}">
		{{ config('const.project_status.' . $project->status) }}
		</div>
	</td>
	<td>
		<a href="{{ url('projects', ['id' => $project->id]) }}" target="_blank">
		<button class="btn btn-sm btn-warning">@lang('project_states.list.show')</button>
		</a>
		<a href="{{ route('admin.projects.edit', ['id' => $project->id]) }}">
		<button class="btn btn-sm btn-warning">@lang('project_states.list.edit')</button>
		</a>
		@if ($project->status == $project->statuses['pending'] || $project->status == $project->statuses['delivered'])
		@if ($proposal)
			<a href="{{ route('download.invoice', ['id' => $project->id]) }}">
			<button class="btn btn-warning btn-sm">@lang('project_states.list.download')</button>
			</a>
		@endif
		@endif
		@if ($project->status == $project->statuses['pending'])
		<a href="{{ route('projects.finish', ['id' => $project->id]) }}">
			<button class="btn btn-warning">@lang('project_states.list.accept')</button>
		</a>
		@endif
		<a href="{{ route('project-states.edit', ['id' => $project->id]) }}">
		<button class="btn btn-sm btn-warning">@lang('project_states.list.change_state')</button>
		</a>
	</td>
	</tr>
@endforeach
</table>
{{ $projects->appends(request()->query())->render() }}
@if ($projects->count() == 0)
<h3 class="text-muted mor-h3-color">@lang('project_states.list.no_item')</h3>
@endif
