<h2 class="bold margin-bottom40 step-title" id="request_job_3">
@lang('projects.create.ask.title')
</h2>
@php
	$items = config('const.project_requests');
	$classCss = [1=>'line-height-25',2=>'line-height-25',3=>'line-height-25'];
@endphp
<div class="bind_request_what step3-content margin-bottom80">
<ul class="row columns5 flexbox text-center letterspacing-1 margin-bottom40 marginx-xs-none">
	@for ($i = 0; $i <= 5; $i++)
	<li class="col-xs-6 col-md-4 col-lg-2">
		<label class="text-white btn-lg request-box relative" data-bg="block3-{{ $i+1 }}.jpg">
		{{ Form::checkbox('part_of_work[]', $i + 1, null, ['style' => 'display:none', 'id' => 'part_of_work_' . $i]) }}
		<span class="{{@$classCss[$i]}}">{!! $items[$i + 1] !!}</span>
		</label>
	</li>
	@endfor
</ul>

<ul class="row columns33 flexbox text-center margin-bottom40">
	@for ($i = 6; $i < 11; $i++)
	<li class="col-xs-6 col-md-4 col-lg-2 @if($i == 6) margin-lg8 @endif">
		<label class="text-white btn-lg request-box relative" data-bg="block3-{{ $i+1 }}.jpg">
		{{ Form::checkbox('part_of_work[]', $i + 1, null, ['style' => 'display:none']) }}
		<span>{!! $items[$i + 1] !!}</span>
		</label>
	</li>
	@endfor
</ul>
<div class="row">
	<div class="col-md-12">
		<label>@lang('projects.another')</label>
		{{ Form::textarea('request_other', null, [
			'class' => 'form-control',
			'rows'  => 3,
			'id' => 'request_other'
		]) }}
	</div>
</div>

<script type="text/javascript">
	var requestBox = document.querySelectorAll('.request-box');
	for (var item of requestBox) {
		var dataBg = item.dataset.bg;
		item.style.backgroundImage = `url('/images/${dataBg}')`;
	}
</script>
</div>
