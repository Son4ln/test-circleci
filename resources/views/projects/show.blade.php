@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title u-title-color">@lang('projects.show.title')</h4>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12" >
	 @can ('viewMessage', $project)
		@if ($project->getMessage())
		<div class="alert alert-warning alert-dismissable background-229393">
			<button class="close" data-dismiss="alert" aria-label="close">&times;</button>
			{{ $project->getMessage() }}
		</div>
		@endif
	 @endcan
	<div class="panel panel-success" >
		<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-size: 13px;">
		@lang('projects.show.client_info')
		</div>
		<div class="panel-body">
		<table class="table table-striped">
			<tr>
			<td class="border-none l-project-td-left text-center">@lang('projects.show.company_name')</td>
			<td class="border-none l-project-td-right text-center">{{ $project->user->company }}</td>
			</tr>
			<tr>
			<td class="border-none l-project-td-left text-center">@lang('projects.show.department')</td>
			<td class="border-none">{{ $project->user->department }}</td>
			</tr>
			<tr>
			<td class="border-none l-project-td-left text-center">@lang('projects.show.client_name')</td>
			<td class="border-none l-project-td-right">{{ $project->user->name }}</td>
			</tr>
			<tr>
			<td class="border-none l-project-td-left text-center">@lang('projects.show.home_page')</td>
			@php
				$url = $project->user->homepage;
				if (!filter_var($project->user->homepage, FILTER_VALIDATE_URL)) {
					$url = 'http://'.$project->user->homepage;
				}
			@endphp
			<td class="border-none"><a href="{{$url}}"  target="_blank" class="l-hyper-link">{{$project->user->homepage}}</a></td>
			</tr>
		</table>
		</div>
	</div>
	<section class="panel panel-success" style="background: #ffffff">
			<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="border-radius: 0 !important;font-weight:bold ">
		@lang('projects.show.project_title')
		</div>
		
		<div class="panel-body box-body table-responsive no-padding">
			<p style="color:#60bfb3;font-weight: bold;padding: 15px 0;font-size: 20px;">{{ $project->title }}</p>
		<table class="table table-striped" id="project-detail">
			@include('projects.components.normal_project')
		</table>

		</div>
		<div class="box-footer" style="padding-top: 21px;padding-bottom: 30px;padding-left: 17px;">
		@can ('cancel', $project)
			<a class="btn l-btn-new background-f34840 post-link"  style="color:#ffffff"
			data-confirm="{{ trans('このプロジェクトをキャンセルしますか？') }}"
			href="{{ route('projects.destroy', $project->id) }}">@lang('projects.show.project_cancel')</a>
		@endcan
		</div>
	</section>
	</div>
	
	<div class="row">
	<div class="col-sm-12" style="padding-left: 30px;padding-right: 30px">

	{{-- Show payment form --}}
	@if ($unPaid)
		<div class="panel panel-success" style="background: #ffffff">
		<div class="box-body">
			<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-weight: 13px;font-weight: bold">
			@lang('projects.show.credit_title', ['budget' => $project->fees / 10000])
			</div>
			<div class="panel-body">
				@empty($isSubscribed)
				@component('payments.partials.credit_card', [
				'action' => route('projects.pay'),
				'method' => 'POST',
				'submit' => __('projects.show.payment_submit'),
				'allowCoupon' => false,
				])
				<input type="hidden" name="projectId" value="{{ $project->id }}">
				@endcomponent
				@endempty
			</div>
		</div>
		</div>
	@endif
	{{-- Show proposal form --}}
	@can ('propose', $project) 
		@include('projects.components.proposal_create')
	@endcan

	{{-- Show creator info --}}
	@if ($project->isStarted()
	&& $offeredProposal
	&& ($offeredProposal->user_id == auth()->id() || $project->isOwn()))
		@component('projects.components.panel', [
		'title' => __('projects.show.creator_title'),
		'center' => false,
		])

		<table class=" table" style="color:#212529 !important">
			<tr >
				<td style="border: 0 !important;color:#212529 !important;font-weight: bold">@lang('projects.show.creator_name')</td>
				<td style="border: 0 !important;color:#212529 !important;font-weight: bold">@lang('projects.show.proposal_amount')</td>
				<td style="border: 0 !important;color:#212529 !important;font-weight: bold">@lang('projects.show.sumary')</td>

			</tr>
			<tr>
				<td style="color:#212529 !important;font-weight: bold">{{ $offeredProposal->user_name }}さん</td>
				<td style="color:#212529 !important;font-weight: bold">{{ number_format($offeredProposal->price) }}円</td>
				<td style="color:#212529 !important;font-weight: bold">{{ $offeredProposal->text}}</td>
			</tr>
		</table>

		<div class="form-group ">
			<a href="{{ url('messages?user_id='.$offeredProposal->user_id) }}">
			<button  class="btn l-btn-new">@lang('projects.show.creator_message')</button>

			</a>


			<a href="{{ route('creative-rooms.show', ['id' => $offeredProposal->room_id]) }}">
				<button style="border: 1px solid #60bfb3;border-radius: 0 !important;background: #ffffff;color:#60bfb3;font-weight: bold;padding-left:20px;padding-right: 20px;" class="btn btn-default ">@lang('projects.show.creator_room')</button>
				</a>

		</div>

		@endcomponent
	@endif

	{{-- Show form for finish project --}}
	@if ($project->isOwn() && $project->isStatus('checking') && $offeredProposal)
		<div class="panel " >
		<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-weight: 13px;font-weight: bold">

			@lang('projects.show.project_finish_title')
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" id="form_delivery" action="{{ url('projects/finish') }}">
			{{ csrf_field() }}
			<input type="hidden" name="project_id" value="{{ $project->id }}">
			<input type="hidden" name="proposal_id" value="{{ $offeredProposal->id }}">
			<div class="form-group">
				<label style="padding-left: 15px;">
						@lang('projects.show.project_budget')
				</label>
				<div class="panel-body">
				<label class="text-info"><span style="color:#60bfb3">{{ number_format($offeredProposal->price2) }}</span><span style="color:#454545">円 （税別）</span></label>

				</div>
			</div>
			<div class="form-group panel-body">
				<div class="">
				<label>@lang('projects.show.invoice_to')</label>
				</div>
				<div class="col-xs-12">
				{{ Form::text('invoice_to', null, [
		'class' => 'form-control',
		'placeholder' => $project->user->name
		]) }}
				</div>
				@if ($errors->has('invoice_to'))
				<span style="color: red">{{ $errors->first('invoice_to') }}</span>
				@endif
			</div>
			<div class="form-group">
				<div class="col-xs-12">
				<button style="" class="btn l-btn-new">@lang('projects.show.project_finish_submit')</button>
				</div>
			</div>
			</form>
		</div>
		</div>
	@endif

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
		<div class="panel-body" style="">
			{!! __('projects.show.checking_text') !!}
		</div>
		</div>
	@endif

	{{-- Show form for creator --}}
	@can ('creatorAcceptance', $project)
		@include('projects.components.creator_acceptance')
	@endcan

	{{-- Show download button --}}
	@can('download', $project)
		<div class="panel panel-default">
		<div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-weight: 13px;font-weight: bold">
			@lang('projects.show.invoice')
		</div>
		<div class="panel-body">
			<a href="{{ route('download.invoice', ['id' => $project->id]) }}">
			<button class="btn l-btn-new">@lang('projects.show.download')</button>
			</a>
		</div>
		</div>
	@endcan

	{{-- Show form for change status --}}
	@if (Auth::user()->hasRole('admin'))
		<form class="panel panel-default" method="POST" action="{{ url('/projects/status', ['id' => $project->id]) }}">
		{{ csrf_field() }}
		<div class="panel-body">
			<div class="form-group ">
			@php
				$statuses = config('const.project_status');
				unset($statuses[0]);
			@endphp
			{{ Form::select('status', $statuses, $project->status, ['class' => 'form-control', 'style' => 'margin-top:25px']) }}
			</div>
			<div class="form-group ">
			<button class="btn l-btn-new btn-block">@lang('projects.show.status_update')</button>
			</div>
		</div>
		</form>
	@endif
	</div>
	</div>


{{-- Show proposal list --}}
	@if (@@$project->isPublic())
		<div style="padding-left: 17px;padding-right: 17px;">
			<div class="panel panel-default">
			<div class="panel-heading clearfix" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;">
				<div  class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25" style="font-weight: 13px;font-weight: bold">
					@lang('projects.show.proposal_list')</h4>
				</div>
			</div>
			<div class="panel-body table-responsive" id="proposal-list">
				@include('widget.proposals.table')
			</div>
			
			@component('projects.components.proposal_dialog', [
				'id'  => 'proposal_confirm',
				'yes' => __('projects.modal.yes'),
				'no'  => __('projects.modal.no')
			])
				<div style="margin-top: 20px"></div>
				<p class="text-center" style="color:#ffffff;font-size: 15px">@lang('projects.modal.proposal_confirm_text')</p>
			@endcomponent
		</div>
	@endif
<div style="padding-left: 15px;padding-right: 15px;">
<div class="panel panel-default">
	<div class="panel-body" style="padding-bottom: 15px;padding-top:15px">
		<center>
			<a href="{{ route('payments.index') }}" class="text-center color-666 " style="padding-top: 12px;padding-bottom: 12px;color:#60bfb3;font-weight: bold">
				@lang('projects.url_payment_text')
			</a>
		</center>
	</div>
</div>
</div>

<input type="hidden" id="project_id" value="{{ $project->id }}">
@endsection

</div>
@php
function url2anker($text){
	return mb_ereg_replace('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', '<a href="\1" target="_blank">\1</a>', $text);
}
$upload_max_size = ini_get('upload_max_filesize');
$upload_max_sizeKb = (int)str_replace('M','',$upload_max_size)*1000000;
@endphp
</div>
@push('styles')
<style>
	#payment-form {
	font-size: 0.8em
	}

	#project-detail th:not(colspan) {
	width: 25%
	}
	.alert-success{
	background-color: #05348b;
		border-color: #05348b;
	}
	button.close{
	display: none;
	}
	
	.alert-warning{
	background: #229393;
	border: #229393;
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

	var maximumMb  = '<?php echo $upload_max_size ?>';
	var maximumKb = '<?= $upload_max_sizeKb ?>';

	$('#create-proposal input[name="attachments[]"]').change(function(){
		if(this.files.length > 0){
			if(this.files[0].size && this.files[0].size > parseInt( maximumKb ) ){
				$(this).parent().find('p').remove();
				$("#l-upload-fix").prop("disabled", true);
				$("#l-upload-fix").prop("disabled", true);
				alert(maximumMb+'B以下のファイルを選択してください');
				$(this).parent().append('<p style="color:red">'+maximumMb+'B以下のファイルを選択してください</p>');
			}else{
				$("#l-upload-fix").prop("disabled", false);
				$(this).parent().find('p').remove();
			}
		}else{
			$(this).parent().find('p').remove();
		}
	});
});
</script>
@endpush

<style type="text/css">
table{
	-webkit-box-shadow: 4px 7px 5px 0px rgba(180,180,181,1);
	-moz-box-shadow: 4px 7px 5px 0px rgba(180,180,181,1);
	box-shadow: 4px 7px 5px 0px rgba(180,180,181,1);
}
.modal-footer .btn-default{
	color: #ffffff !important;
	font-size: 15px !important;
}
</style>