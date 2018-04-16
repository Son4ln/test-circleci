<h2 class="bold margin-bottom40 step-title" id="request_job_11">
  @lang('projects.create.project_expiration_update_l')
</h2>
<div class="step11-content margin-bottom40" style="/* min-height:500px; */">
  <div class="row bind_expiration_date">
    <div class="step11-form col-md-12">
      <span class="text-danger" id="expired_at_error" data-message="@lang('projects.create.expiration_error')"></span>
      <div class="input-group date margin-bottom10">
        <div class="input-group-addon text-white">
          <i class="fa fa-calendar"></i>
        </div>
        @if ($project->expired_at)
          {{ Form::text('expired_at', date('Y/m/d', strtotime($project->expired_at)), [
            'class' => 'form-control pull-right',
            'id'    => 'expiration_date'
          ]) }}
        @else
          <input name="expired_at" id="expiration_date" class="form-control pull-right" type="text" value="">
        @endif

      </div>
      @php
      if ($project->title) {
        $project->is_expiration_undecided = $project->expired_at ? null : 1;
      }
      @endphp
      <h4>
        <label class="label-btn btn-lg text-white">
          {{ Form::checkbox('is_expiration_undecided', 1, null, [
            'style' => 'display:none'
          ]) }} @lang('projects.create.undecided')</span>
        </label>
      </h4>
    </div>
  </div>
</div>
<div class="inline-block nextlink">
    <div class="width100 text-center">
      <a href="#request_job_12" class="scrollarrow-blue80">
        <span class="nexttext">@lang('projects.next')</span>
      </a>
    </div>
  </div>
