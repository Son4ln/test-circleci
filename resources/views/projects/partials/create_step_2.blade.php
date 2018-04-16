<style>
.link-on {
	color: #00f;
}

.link-disabled {
	color: #f00; /* わかりやすく色を赤に。 */
	pointer-events: none; /* aタグのリンクを無効にする */
	cursor: default; /* マウスオーバー時のカーソルをdefaultに固定 */
	text-decoration: none; /* 下線等を消す。 */
}
</style>
<h2 class="bold step-title" id="request_job_2">@lang('projects.create.budget_title')</h2>
<div class="margin-bottom40 step-desc">@lang('projects.create.budget_alert')</div>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin-bottom40 range-box">
<p id="price" class="margin-bottom40">
	{{--  0:更新画面 通常,  1:更新画面 認定クリエイター,  0,1以外:新規画面  --}}
	{!! Form::hidden('is_certcreator') !!}
	{!! Form::number('price_min', null, ['id' => 'lower_limit', 'data-filter' => 'hankaku']) !!}万円
	～
	{!! Form::number('price_max', null, ['id' => 'upper_limit', 'data-filter' => 'hankaku']) !!}万円
	{{ Form::checkbox('is_price_undecided', 1, null, ['id' => 'budget_undecided', 'class' => 'step2-checkbox']) }}
	<label for="budget_undecided" class="step2-checkbox-label">@lang('projects.create.budget_determined')</label>
</p>
<div style="float:left; width:45%; height:400px;">
	<div style="height:170px; margin:0;" id="upper_limit_of_scale"></div>
	<div style="height: 220px;">
		<div style="text-align: center;">
			<div class="range-desc">@lang('projects.create.small_project')
				<div class="box-tail right-tail"></div>
			</div>
		</div>
	</div>
	<div style="height:20px; margin:0;" id="lower_limit_of_scale"></div>
</div>
<div id="slider-range" style="float:left; height:400px;"></div>
<div style="float:left; width:45%; height:400px; text-align:center;">
	<div style="height:375px; margin:0; float: right;">
		<div class="range-desc">@lang('projects.create.medium_scale')
			<div class="box-tail left-tail"></div>
		</div>
	</div>
	<div style="height:20px; margin:0; float: right;">
		<div class="range-desc">@lang('projects.create.request_project')
			<div class="box-tail left-tail"></div>
		</div>
	</div>
</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" id="portfolio-list">

</div>
{{--
<div style="float:left; width:30%; height:400px; text-align:center;">
	<div><a href="#" id="sample35">サンプル動画 35万<br><img src="../images/1.gif" style="margin:50px;"></a></div>
	<div><a href="#" id="sample20">サンプル動画 20万<br><img src="../images/2.gif" style="margin:50px;"></a></div>
	<div><a href="#" id="sample5">サンプル動画 5万<br><img src="../images/3.gif" style="margin:50px;"></a></div>
</div>
--}}
<div style="clear:both;"></div>
<div class="inline-block nextlink" style="margin-top:50px;">
	<div class="width100 text-center">
	<a href="#request_job_3" class="scrollarrow-blue80">
		<span class="nexttext">@lang('projects.next')</span>
	</a>
	</div>
</div>
</div>
