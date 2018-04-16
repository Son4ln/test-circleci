<h2 id="request_job_1" class="bold step-title">
@lang('projects.create.style_title')
<!-- <span class="kome"></span> -->
</h2>
<p class="step-desc">@lang('projects.create.style_description')</p>
<div class="margin-bottom40">
{{-- Movie style --}}
<h3 id="request_job_1_1" class="mor-create-step-title text-white text-center bold margin-bottom40">@lang('projects.create.style')</h3>
<div class="bind_movie_style text-center margin-bottom40" id="style_container">
	<div class="row">
	@foreach(config('const.project_movie_style', []) as $index => $style)
		<?php $selected = in_array($index, old('real_or_anime', [])); ?>
		<div class="col-md-4 movie-box">
			<h4>
			<label class="gif-box color-60bfb3 {{ $selected ? 'on': '' }}" style="display: block;" id="{{ 'label-style-' . $index }}">
				{!! Form::checkbox('real_or_anime[]', $index, null, ['class' => 'hidden', 'id' => 'style-' . $index]) !!}
				<span>{{ $style }}</span>
			</label>
			</h4>
			<label for="{{ 'label-style-' . $index }}" class="label-style">
			<img src="{{ asset('images/moviestyle'. $index .'.gif') }}" class="width100 radius6 dotborder-all-blue" alt="実写イメージ"/>
			</label>
		</div>
	@endforeach
	</div>
</div>

{{-- Movie type --}}
<h3 id="request_job_1_2" class="mor-create-step-title text-white text-center margin-bottom40 bold">@lang('projects.create.type')</h3>
<div class="row bind_movie_type columns4 margin-bottom20" id="type_container">
	@php
		$itemIndex = 0;
	@endphp

	@foreach(config('const.project_movie_type', []) as $index => $type)
	<?php $selected = in_array($index, old('type_of_movie', [])); ?>
	<div class="col-md-3">
		<label class="movietype1-back color-60bfb3 {{ $selected ? 'on': '' }}">
		{!! Form::checkbox('type_of_movie[]', $index, null, ['class' => 'hidden', 'id' => 'type-' . $index, 'data-item-index' => $itemIndex]) !!}
		<center><div class="checkbox-txt-block"><i class="checkbox-icon pull-left checkbox-number-{{ $itemIndex + 1 }}"></i>{{ $type }}</div></center>
		</label>
	</div>
	@php
		$itemIndex ++;
	@endphp

	@endforeach

</div>

<div class="table-responsive margin-bottom80">
	<table class="table step1-table">
		<tr>
			<th>
				<div class="inner-movies-left">
					<div class="movies-left-icon"></div>
					<span class="inner-movies-left-title">広告</span>
				</div>
			</th>
			<td class="movie-note">CM/プロモーション/インフォマーシャル/リクルートなど</td>
		</tr>

		<tr>
			<th>
				<div class="inner-movies-left">
					<div class="movies-left-icon"></div>
					<span class="inner-movies-left-title">作品</span>
				</div>
			</th>
			<td class="movie-note">番組/映画/DVDコンテンツなど</td>
		</tr>

		<tr>
			<th>
				<div class="inner-movies-left">
					<div class="movies-left-icon"></div>
					<span class="inner-movies-left-title">インナー</span>
				</div>
			</th>
			<td class="movie-note">マニュアル/研修/社内向け動画など</td>
		</tr>

		<tr>
			<th>
				<div class="inner-movies-left">
					<div class="movies-left-icon"></div>
					<span class="inner-movies-left-title">記録</span>
				</div>
			</th>
			<td class="movie-note">パーティー/イベント/ウエディングなど</td>
		</tr>
	</table>
</div>
<!-- <div class="text-right">
	<a href="javascript:void(0);" id="movie_type_another" class="font-size-30">
	@lang('projects.create.another_type')<i class="fa fa-fw fa-chevron-circle-right"></i>
	</a>
</div> -->
<div class="inline-block nextlink">
	<div class="width100 text-center">
	<a href="#request_job_2" class="scrollarrow-blue80 ">
		<span class="nexttext" >@lang('projects.next')</span>
	</a>
	</div>
</div>
<script type="text/javascript">
	var noteOfMovies = document.querySelectorAll('.movie-note');
	var typeOfMovies = document.querySelectorAll('[name="type_of_movie[]"]');
	for (var i = 0; i < typeOfMovies.length; i++) {
		if (typeOfMovies[i].checked == true) {
			noteOfMovies[i].classList.add('background-60bfb3', 'text-white');
		}

		typeOfMovies[i].addEventListener('change', (e) => {
			var itemIndex = e.target.dataset.itemIndex;
			if (e.target.checked == true) {
				noteOfMovies[itemIndex].classList.add('background-60bfb3', 'text-white');
			} else {
				noteOfMovies[itemIndex].classList.remove('background-60bfb3', 'text-white');
			}
		});
	}
</script>
</div>
