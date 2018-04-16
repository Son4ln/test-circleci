@extends('layouts.home')

@section('content')
	<div class="row">
		@if( !empty($portfolios->items()) )
			@foreach($portfolios as $portfolio)
			
				<div  class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">
					<a href="{{ url('/portfolios/' . $portfolio->id) }}">
						<div class="service-icon" style="background:url('{{ $portfolio->thumb_path }}');background-size: cover;height: 200px" >
							@if (strpos($portfolio->mime, 'video') !== false)
								<span class="button-blue">
								<img src="{{ asset('images/video_play_button.png') }}" alt="Play video">
								</span>
							@else
								<span class="button-red">
								<img src="{{ asset('images/image_show_button.png') }}" alt="Show image">
								</span>
							@endif
						</div>
					</a>
				</div>
					
			@endforeach
		@else
		
		
		@endif
	</div>
	@if( $portfolios->lastPage() > 1 )
		<div class="row">
			<div class="pull-left" style="padding-left: 15px">
				{{$portfolios->render()}}
			</div>
			
		</div>
	@endif


@endsection


