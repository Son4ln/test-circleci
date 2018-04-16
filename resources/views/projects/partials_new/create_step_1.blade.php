<h2 class="border-bottom-333 margin-bottom40" id="request_job_1">
1. どんな動画を作りたいですか？
<span class="kome">※検討中であれば複数選択してください。</span>
</h2>
<div class="margin-left5">
{{-- Movie style --}}
<h3 id="request_job_1_1" class="border-all-blue">動画のスタイル</h3>
<div class="bind_movie_style columns33 flexbox text-center space-around margin-bottom40">

	@foreach(config('const.project_movie_style', []) as $index => $style)
	<?php $selected = in_array($style, old('real_or_anime', [])); ?>
	<div class="flexbox1">
		<h4>
		<label class="light-blue60-back btn-lg {{ $selected ? 'on': '' }}" style="display: block;">
			{!! Form::checkbox('real_or_anime[]', $style, $selected, ['class' => 'hidden']) !!}
			<span>{{ $style }}</span>
		</label>
		</h4>
		<img src="{{ asset('images/moviestyle'. $index .'.jpg') }}" class="width100 radius6 dotborder-all-blue" alt="実写イメージ"/>
	</div>
	@endforeach

</div>

{{-- Movie type --}}
<h3 id="request_job_1_2" class="border-all-blue margin-bottom20 mor-h3-color">動画のタイプ</h3>
<ul class="bind_movie_type flexbox columns4 margin-bottom20">

	@foreach(config('const.project_movie_type', []) as $index => $type)
	<?php $selected = in_array($type, old('type_of_movie', [])); ?>
	<li class="flexbox1 relative {{ $index >= 12 ? 'hidden' : '' }}">
		<label class="movietype1-back border-all-orange white btn-lg {{ $selected ? 'on': '' }}">
		{!! Form::checkbox('type_of_movie[]', $type, $selected, ['class' => 'hidden']) !!}
		<span class="bottom">{{ $type }}</span>
		</label>
	</li>
	@endforeach

</ul>
<div class="text-right">
	<a href="javascript:void(0);" id="movie_type_another">
	その他<i class="fa fa-fw fa-chevron-circle-right"></i>
	</a>
</div>
<div class="inline-block nextlink">
	<div class="width100 text-center">
	<a href="#request_job_2" class="scrollarrow-blue80">
		<span class="nexttext">次へ</span>
	</a>
	</div>
</div>
</div>
