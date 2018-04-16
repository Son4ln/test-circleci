<table class="table table-striped table-hover">
<thead>
<tr>
	<th class="font-bold">@lang('proposals.list.project_status')</th>
	<th class="font-bold">@lang('proposals.list.project_name')</th>
	<th class="font-bold">@lang('proposals.list.proposal_amount')</th>
	<th class="font-bold">@lang('proposals.list.attachments')</th>
	{{-- <th></th> --}}
</tr>
</thead>
<tbody>
@foreach ($proposals as $proposal)
	<tr>
		<td class="font-bold">
			{{ @@config('const.project_status.'.$proposal->project_status,'') }}
		</td>
		<td class="font-bold">
			<a class="text-black" href="{{ url('projects/'.$proposal->project_id) }}">
			{{ $proposal->project_title }}
			</a>
		</td>
		<td class="font-bold"><span class="color-60bfb3" style="font-size: 18px;">{{ number_format($proposal->price) }}</span> 円</td>
		<td>
			@if (count($proposal->attachments))
			@foreach ($proposal->attachments as $file)
				<a href="{{ Storage::disk('s3')->url($file['url']) }}" download>
				{{ $file['name'] }}
				</a>,
			@endforeach
			@endif
		</td>
		{{-- <td>
			@if ($proposal->projectIsNotStarted())
			<a href="#modalWindow" data-toggle="modal">
				<button class="btn btn-warning btn-xs" data-edit="{{ $proposal->id }}">Edit</button>
			</a>
			@endif
		</td> --}}
	</tr>
@endforeach
</tbody>
</table>
