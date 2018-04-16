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
<h2 class="border-bottom-333 margin-bottom40" id="request_job_2">2. ご予算はお決まりですか？</h2>
<div class="margin-left5">
  <p>
    {{--  0:更新画面 通常,  1:更新画面 認定クリエイター,  0,1以外:新規画面  --}}
    {!! Form::hidden('is_certcreator') !!}
    {!! Form::text('price_min', null, ['id' => 'lower_limit']) !!}万円
    ～
    {!! Form::text('price_max', null, ['id' => 'upper_limit']) !!}万円
    <label>
      <input type="checkbox" id="budget_undecided" value="予算未定">予算未定
    </label>
  </p>
  <div style="float:left; width:20%; height:400px;">
    <div style="height:380px; margin:0;" id="upper_limit_of_scale"></div>
    <div style="height:20px; margin:0;" id="lower_limit_of_scale"></div>
  </div>
  <div id="slider-range" style="float:left; height:400px;"></div>
  <div style="float:left; width:30%; height:400px; text-align:center;">
    <div style="height:190px; margin:0;">中規模プロジェクト</div>
    <div style="height:190px; margin:0;">小規模プロジェクト</div>
    <div style="height:20px; margin:0;">作業依頼</div>
  </div>
  <div style="float:left; width:30%; height:400px; text-align:center;">
    <div><a href="#" id="sample35">サンプル動画 35万<br><img src="../images/1.gif" style="margin:50px;"></a></div>
    <div><a href="#" id="sample20">サンプル動画 20万<br><img src="../images/2.gif" style="margin:50px;"></a></div>
    <div><a href="#" id="sample5">サンプル動画 5万<br><img src="../images/3.gif" style="margin:50px;"></a></div>
  </div>
  <div style="clear:both;"></div>
  <div class="inline-block nextlink" style="margin-top:50px;">
    <div class="width100 text-center">
      <a href="#request_job_3" class="scrollarrow-blue80">
        <span class="nexttext">次へ</span>
      </a>
    </div>
  </div>
</div>
