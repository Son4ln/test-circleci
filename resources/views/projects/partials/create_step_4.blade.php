<h2 class="bold margin-bottom40 step-title" id="request_job_4">
  @lang('projects.create.arrange.title')
</h2>
@php $items = config('const.project_requests') @endphp
<div class="bind_arrange_anything step4-content margin-bottom80">
  <ul class="row flexbox text-center letterspacing-1 margin-bottom40 marginx-xs-none">
    @for ($i = 0; $i <= 5; $i++)
      <li class="flexbox1 col-xs-6 col-md-4 col-lg-2">
        <label class="text-white btn-lg request-box" data-bg="block3-{{ $i+1 }}.jpg">
          {{ Form::checkbox('client_arrange[]', $i + 1, null, ['style' => 'display:none', 'id' => 'client_arrange_' . $i]) }}
          <span>{!! $items[$i + 1] !!}</span>
        </label>
      </li>
    @endfor
  </ul>

  <ul class="row flexbox text-center margin-bottom40">
    @for ($i = 6; $i < 11; $i++)
      <li class="flexbox1 col-xs-6 col-md-4 col-lg-2 @if($i == 6) margin-lg8 @endif">
        <label class="text-white btn-lg request-box" data-bg="block3-{{ $i+1 }}.jpg">
          {{ Form::checkbox('client_arrange[]', $i + 1, null, ['style' => 'display:none']) }}
          <span>{!! $items[$i + 1] !!}</span>
        </label>
      </li>
    @endfor
  </ul>
  <div class="row">
    <div class="col-md-12">
      <label>@lang('projects.another')</label>
      {{ Form::textarea('client_arrange_text', null, [
          'id'    => 'client_arrange_text',
          'class' => 'form-control',
          'rows'  => 3,
      ]) }}
    </div>
  </div>
  <div class="inline-block nextlink" style="margin-top:50px;">
    <div class="width100 text-center">
      <a href="#request_job_5" class="scrollarrow-blue80">
        <span class="nexttext">@lang('projects.next')</span>
      </a>
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
