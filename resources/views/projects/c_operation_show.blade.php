@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('projects.show.title')</h4>
</div>
@endsection

@section('content')
<div class="row ">
	<div class="col-sm-8">
	@can ('viewMessage', $project)
		@if ($project->getMessage())
		<div class="alert alert-warning alert-dismissable">
			<button class="close" data-dismiss="alert" aria-label="close">&times;</button>
			{{ $project->getMessage() }}
		</div>
		@endif
	@endcan
	<div class="panel panel-success">
		<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25">
		@lang('projects.show.client_info')
		</div>
		<div class="panel-body">
		<table class="table info_pr">
			<tr class="tb_2">
			<td class="pr_tb_tit">@lang('projects.show.company_name')</td>
			<td>{{ $project->user->company }}</td>
			</tr>
			<tr>
			<td class="pr_tb_tit">@lang('projects.show.department')</td>
			<td>{{ $project->user->department }}</td>
			</tr>
			<tr class="tb_2">
			<td class="pr_tb_tit">@lang('projects.show.client_name')</td>
			<td>{{ $project->user->name }}</td>
			</tr>
			<tr>
			<td class="pr_tb_tit">@lang('projects.show.home_page')</td>
			@php
				$url = $project->user->homepage;
				if (!filter_var($project->user->homepage, FILTER_VALIDATE_URL)) {
					$url = 'http://'.$project->user->homepage;
				}
			@endphp
			<td><a href="{{$url}}"  target="_blank" class="l-hyper-link">{{$project->user->homepage}}</a></td>
			</tr>
		</table>
		</div>
	</div>
	<section class="panel panel-success">
		<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25">
		@lang('projects.show.project_title')
		</div>
		<div class="box-header bx_header_tx2" style="padding-left: 25px">
		<h3>{{ $project->title }}</h3>
		<h4>
			@lang('projects.show.prime')
		</h4>
		</div>
		<div class="box-body table-responsive no-padding" style="padding: 25px;">
		<table class="table info_pr" id="project-detail">
			@include('projects.components.prime_project')
		</table>

		</div>
		<div class="box-footer" style="padding-top: 10px;padding-bottom: 30px;padding-left: 26px;">
		@can ('cancel', $project)
			<a class="btn l-btn-new post-link" style="color:#ffffff"
			data-confirm="{{ trans('このプロジェクトをキャンセルしますか？') }}"
			href="{{ route('projects.destroy', $project->id) }}">@lang('projects.show.project_cancel')</a>
		@endcan
		</div>
	</section>
	</div>
	<div class="col-sm-4">

	{{-- Show proposal form --}}
	@can ('propose', $project) 
		@include('projects.components.proposal_create')
	@endcan 

{{--@if ($project->isStarted() && $project->isOwn())--}}
	@include('projects.components.selected_proposals', ['proposals' => $project->selectedProposals])
{{--@endif--}}

	{{-- Show modal for confirm project --}}
	@component('projects.components.proposal_dialog', [
		'id'  => 'confirm_delivery',
		'yes' => __('projects.modal.yes'),
		'no'  => __('projects.modal.no')
	])
		<p class="text-center">@lang('projects.modal.confirm_text')</p>
	@endcomponent

	@if ($project->isStatus('checking') && $project->isOwn())
		<div class="panel panel-default">
		<div class="panel-body text-center">
			{!! __('projects.show.checking_text') !!}
		</div>
		</div>
	@endif

@can ('creatorOperationAcceptance', $project)
	<div class="panel panel-default">
	<div class="panel-body">
		<a href="{{ route('operation.acceptance', ['id' => @@$project->operationCreatorProposal()->id]) }}">
		<button class="l-btn-new btn">@lang('projects.show.c_operation_creator_acceptance')</button>
		</a>
	</div>
	</div>
@endcan

	{{-- Show form for change status --}}
	@if (Auth::user()->hasRole('admin'))
		<form class="panel panel-default" method="POST" action="{{ url('/projects/status', ['id' => $project->id]) }}">
		{{ csrf_field() }}
		<div class="panel-body">
			<div class="form-group">
			@php
		$statuses = config('const.project_status');
		unset($statuses[50], $statuses[60], $statuses[0]);
	@endphp
			{{ Form::select('status', $statuses, $project->status, ['class' => 'form-control']) }}
			</div>
			<div class="form-group">
			<button class="btn btn-primary btn-l-pp-save" style="width: 100%">@lang('projects.show.status_update')</button>
			</div>
		</div>
		</form>
	@endif
	</div>
</div>

{{-- Show proposal list --}}
@if ($project->isPublic() && !$project->isOwn())
	<div class="panel panel-default">
	<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" >
	<h3 style="font-size: 13px;color:#ffffff;line-height: 0">@lang('projects.show.proposal_list')</h3>
	</div>

	<div class="panel-body table-responsive" id="proposal-list">
		@include('widget.proposals.table')
	</div>
	</div>
	@component('projects.components.proposal_dialog', [
		'id'  => 'proposal_confirm',
		'yes' => __('projects.modal.yes'),
		'no'  => __('projects.modal.no')
	])
	<div style="margin-top: 20px"></div>
	<p class="text-center" >@lang('projects.modal.proposal_confirm_text')</p>
@endcomponent
@endif

@if (($project->isPublic() || $project->isStatus('started')) && $project->isOwn())
	@include('projects.components.prime_proposals', ['proposals' => $project->proposals])
@endif
<input type="hidden" id="project_id" value="{{ $project->id }}">
@endsection

@php
function url2anker($text){
	return mb_ereg_replace('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', '<a href="\1" target="_blank">\1</a>', $text);
}
@endphp

@push('styles')
<style>
	#payment-form {
	font-size: 0.8em
	}

	#project-detail th:not(colspan) {
	width: 25%
	}
</style>
@endpush

@push('scripts')
	<script type="text/javascript">
$(document).ready(function() {
	$('.create-proposal').click(function() {
	$('.modal-header', '#modalWindow').text($(this).data('title'));
	$('.modal-body', '#modalWindow').load('/proposals/create');
	});

	$(document).on('click', '.send-message', function() {
	$('.modal-header', '#modalWindow').text('メッセージ送信')
	$('.modal-body', '#modalWindow').load('/proposal-messages/create', {
		user_id: $(this).data('user'),
		proposal_id: $(this).data('proposal')
	});
	});

	$(document).on('click', '.accept', function() {
	$('input[name="proposal_id"]', '#accept-form').val($(this).data('proposal'));
	$('input[name="user_id"]', '#accept-form').val($(this).data('user'));
	});

	$(document).on('click', '#agree', function() {
	$('#accept-form').submit();
	});

	$('[data-filter="hankaku"]').keydown(function(e) {
	var allowKeys = [8, 46, 37, 39, 35, 36, 229, 13, 9];
	if (allowKeys.indexOf(e.keyCode) > -1) {
		return;
	}
	if (e.keyCode < 48 || e.keyCode > 57) {
		e.preventDefault();
	}
	});

	$('[data-filter="hankaku"]').focusout(function() {
	$(this).val(toHankaku($(this).val()));
	});

	var toHankaku = (function (String, fromCharCode) {
	function toHankaku (string) {
		return String(string).replace(/\u2019/g, '\u0027').replace(/\u201D/g, '\u0022').replace(/\u3000/g, '\u0020').replace(/\uFFE5/g, '\u00A5').replace(/[\uFF01\uFF03-\uFF06\uFF08\uFF09\uFF0C-\uFF19\uFF1C-\uFF1F\uFF21-\uFF3B\uFF3D\uFF3F\uFF41-\uFF5B\uFF5D\uFF5E]/g, alphaNum);
	}

	function alphaNum (token) {
		return fromCharCode(token.charCodeAt(0) - 65248);
	}

	return toHankaku;
	})(String, String.fromCharCode);

	$('#form_delivery').submit(function(e) {
	e.preventDefault();
	$('#amount').val(toHankaku($('#amount').val()));
	$('#confirm_delivery').modal('show');
	})

	$('#agree', '#confirm_delivery').click(function() {
	$('#form_delivery').unbind('submit').submit();
	});
});
</script>
@endpush
<style>
	.modal-footer .btn-default{
		color: #ffffff !important;
		font-size: 15px !important;
	}
</style>