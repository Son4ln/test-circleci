@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title u-title-color">@lang('portfolios.list.title_update')</h4>
</div>
@endsection

@section('content')
	<div class="white-box">
		<form id="portfolios-filter" class="row" action="{{ url('/portfolios/filter') }}" class="box-body" style="padding-left: 26px">
			<div class="col-md-12">
				<div class="row">
				<h2 class="small margin-top0"><strong>@lang('portfolios.list.amount')</strong></h2>
				<div class="pull-left">
					<input class="styled-checkbox" name="amount[]" id="styled-checkbox-1" type="checkbox" value="1-30">
					<label for="styled-checkbox-1" class="padding-right-40">@lang('portfolios.list.condition.buget_30')</label>
				</div>
	
				<div  class="pull-left ">
					<input class="styled-checkbox" name="amount[]" id="styled-checkbox-2" type="checkbox" value="30-60">
					<label for="styled-checkbox-2" class="padding-right-40">@lang('portfolios.list.condition.budget_3060')</label>
				</div>
	
				<div  class="pull-left ">
					<input class="styled-checkbox" name="amount[]" id="styled-checkbox-3" type="checkbox" value="60-100">
					<label for="styled-checkbox-3" class="padding-right-40">@lang('portfolios.list.condition.budget_60100')</label>
				</div>
	
				<div  class="pull-left ">
					<input class="styled-checkbox" name="amount[]" id="styled-checkbox-4" type="checkbox" value="100-500">
					<label for="styled-checkbox-4" class="padding-right-40">@lang('portfolios.list.condition.budget100')</label>
				</div>
	
				<div  class="pull-left ">
					<input class="styled-checkbox" name="amount[]" id="styled-checkbox-5" type="checkbox" value="0-0">
					<label for="styled-checkbox-5" class="padding-right-40">@lang('portfolios.list.condition.public')</label>
				</div>
				</div>
			</div>
			<div class="col-md-12" style="margin-top: 15px">
				<div class="row">
					<h2 class="small margin-top0"><strong>@lang('portfolios.list.style')</strong></h2>
					<span>&nbsp;</span>
					@foreach(config('const.project_movie_style', []) as $index => $type)
					<div class="pull-left {{ $index != 1 ? '' : '' }}">
						{!! Form::checkbox('styles[]', $index, null, ['id' => 's_'.$index]) !!} 
						<label for="{{ 's_'.$index }}" class="padding-right-40">{{ $type }}</label>
					</div>
					@endforeach
				</div>
			</div>
			<div class="col-md-12" style="margin-top: 15px">
				<div class="row">
					<h2 class="small margin-top0"><strong>@lang('portfolios.list.type')</strong></h2>
					&nbsp;
					@foreach(config('const.project_movie_type', []) as $index => $type)
					@php $class = $index > 4 ? 'hidden cls' : '' @endphp
					<div class="pull-left ">
						{!! Form::checkbox('types[]', $index, null, ['id' => 'm'.$index,  ]) !!} 
					<label style="padding-right:40px" for="{{'m'.$index}}">{{ $type }}</label>
					</div>
					@endforeach
				</div>
				{{--<div class="col-md-12">
					<a href="#" style=" color:#60bfb3;margin-left: -18px;" id="collapse" class="ex">@lang('portfolios.list.expand')</a>
				</div>--}}
			</div>
			<div class="col-md-12"  style="margin-top: 30px">
				<div class="row">
					<strong>@lang('portfolios.list.sort')</strong>
					<select class="form-control" name="order" >
					<option value="0">---</option>
					<option value="asc">@lang('portfolios.list.asc')</option>
					<option value="desc">@lang('portfolios.list.desc')</option>
					</select>
				</div>
			</div>
		</form>
	
		<div class="l-portfolios" style="margin-top:50px;" id="portfolios-list">
			@include('portfolios.partials.list')
		</div>
		<div class="clearfix"></div>
	</div>
@endsection

@push('styles')
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/custom.css?v=<?= VERSION_CSS_JS ?>">
<style media="screen">

</style>
@endpush

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	$('#portfolios-filter').crluoFormInputSearch({dest: '#portfolios-list'});
	$('.slider').mouseup(function () {
	$('input[name="amount"]').val($('#slider').val()).trigger('change');
	})

	$('#collapse').click(function(e) {
	e.preventDefault()
	if ($(this).hasClass('ex')) {
		$(this).removeClass('ex').text('@lang('portfolios.list.collapse')')
		$('.cls').removeClass('hidden');
	} else {
		$(this).addClass('ex').text('@lang('portfolios.list.expand')');
		$('.cls').addClass('hidden');
	}
	});

	$(document).on( 'mouseenter', '.background-fff', function() {
		$(this).find('.portfolio-control').css({'z-index':1});
  	})
	  $(document).on( 'mouseleave', '.background-fff', function() {
		$('.portfolio-control').css({'z-index':0});
  	})
		
});
</script>
@endpush
