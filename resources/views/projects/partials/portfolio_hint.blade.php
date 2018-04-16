<div class="panel panel-info">
<center>
<div class="panel-heading p-hint-padding mor-create-step-title text-white text-center bold">
	@lang('projects.create.portfolio_hint')
</div>
</center>
<div class="panel-body">
	@foreach ($portfolios as $portfolio)
	<a href="{{ url('portfolios', ['id' => $portfolio->id]) }}" target="_blank" class="port-box"
		style="background-image: url('{{ $portfolio->thumb_path }}')">
		<div>
		{{ $portfolio->display_name }}
		</div>
	</a>
	@endforeach
	<center>
	<a href="{{ url('portfolios') }}" target="_blank">
	<button type="button" class="btn p-hind-btn bold">
		@lang('projects.create.portfolio_link')
	</button>
	</a>
	</center>
</div>
</div>
