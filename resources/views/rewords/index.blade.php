@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('rewords.list.title')</h4>
</div>
@endsection

@section('content')
<div class="white-box">
	<section class="box-body ui-reword table-responsive">
	<table class='table'>
		<thead>
		<tr>
			<th class="font-bold">@lang('rewords.list.date')</th>
			<th class="font-bold">@lang('rewords.list.project_name')</th>
			<th class="font-bold">@lang('rewords.list.amount')</th>
			<th class="font-bold"></th>
		</tr>
		</thead>
		<tbody>
		@foreach ($rewords as $reword)
			<tr>
			<td class="font-bold">{{date('Y/m/d ',strtotime($reword->created_at))}}</td>
			<td><a class="color-60bfb3 font-bold" href="{{ route('projects.show', ['id' => $reword->project_id]) }}">
				{{$reword->project->title}}
			</a></td>
			<td class="font-bold">{{number_format($reword->reword)}}円</td>
			<td>
				<a href="{{ route('rewords.edit', ['id' => $reword->id]) }}" target="_blank">
				<button class="btn background-60bfb3 reword-edit-btn font-bold">@lang('rewords.list.edit')</button>
				</a>
			</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class='ui-page-reword'>
		{!! $rewords->render() !!}
	</div>
	</section>
</div>
@endsection