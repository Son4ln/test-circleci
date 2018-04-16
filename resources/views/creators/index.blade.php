@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title u-title-color">@lang('creators.search.title')</h4>
</div>
@endsection

@section('content')
<div class="white-box">
	<form class="box-body" action="/creators/filter" id="creator-filter" method="POST" style="margin: 0 15px 0 15px">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-12">
			<div class="margin-right30 width30">
				<div class="form-group">
				<h2 class="small margin-top0"><strong>@lang('creators.search.base')</strong></h2>
				<select name='base' class='form-control'>
					@foreach (array_replace(array('' => '-'), Config::get('const.base')) as $key => $val)
					<option value="{{$key}}" {{  Request::input('base') == $key ? 'selected' : '' }}>{{$val}}</option>
					@endforeach
				</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="margin-right20" style="line-height: 1.6">
				<div>
				<h2 class="small margin-top0"><strong>@lang('creators.search.style')</strong></h2>
				@php
					$skills = Config::get('const.skill');
					$skills = array_chunk($skills,5);
					$i = 0;
				@endphp
					@foreach ($skills as $key => $value)
						<div class="col-lg-3 col-sm-4 col-xs-6 col-md-3 search-modify">
							@foreach($value as $k => $v)
							@php
								$i++;
							@endphp
								<div>
								<input type='checkbox' name='skill[]' id="s{{$i}}" value='{{$k}}'>
								<label for="s{{$i}}" class="checkbox-inline" >{{ $v }}</label>
								</div>
							@endforeach
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	@if (auth()->user()->isAdmin())
		<div class="row">
			<div class="col-md-12">
				<div class="margin-right20 width30">
				<div class="form-group">
					<h2 class="small margin-top0"><strong>@lang('creators.search.name')</strong></h2>
					<input type="text" name="name" class="form-control input-modify"><br>
					
				</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<button type="button" id="search" class="btn btn-primary">@lang('creators.search.search')</button>
			</div>
		</div>
	@endif
	</form>

	<div class="columns32  space-between" id="creators-list" style="margin-top:50px;">
		@include('widget.creators.list', ['pagination_ajax' => false])
	</div>
	<div class="clearfix"></div>
</div>
@endsection


@push('styles')
<link rel="stylesheet" href="/css/style.css">
@endpush

@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
	$('#creator-filter').crluoFormInputSearch({dest: '#creators-list'});
	$('span.ui-send-message[data-toggle="modal"]').click(function (e) {
		$('.modal-title', '#modalWindow').html($(this).attr('data-title'));
		$('div.modal-body', '#modalWindow').load($(this).attr('data-procname'));
	});
	});
</script>
@endpush
