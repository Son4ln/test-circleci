<!-- クルオアド仕事を依頼・あなたの依頼をまとめました-->
<h2 id="request_job_12" class="cop-p-border-bottom-333 margin-bottom40">
  @lang('prime_projects.create.sumary.title')
</h2>
<table id="preview_table" class="table table-bordered table-hover dataTable margin-bottom30">
  <tr>
    <th class="white-space-nowrap width30">@lang('prime_projects.create.sumary.project_name')</th>
    <td class="relative preview_project_name">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_7" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th class="white-space-nowrap width30">@lang('prime_projects.create.sumary.duedate')</th>
    <td class="relative preview_delivery_date">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_8" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.business')</th>
    <td class="relative preview_owner">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_1" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.purpose')</th>
    <td class="relative preview_purpose">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_2" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('projects.create.sumary.expiration')</th>
    <td class="relative preview_expiration_date">
      <span class="padding-right10"></span>
      <a href="#request_job_11" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.target')</th>
    <td class="relative preview_tell_about_movie_1">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_3" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.point')</th>
    <td class="relative preview_tell_about_movie_2">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_3" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.descibe')</th>
    <td class="relative preview_tell_about_movie_3">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_3" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.sec')</th>
    <td class="relative preview_movie_scale">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_4" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.image')</th>
    <td class="relative preview_close_to_image">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_5" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.scale')</th>
    <td class="relative preview_aspect_ratio">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_6" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.reference')</th>
    <td class="relative preview_reference_information">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_9" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
  <tr>
    <th>@lang('prime_projects.create.sumary.standard')</th>
    <td class="relative preview_criterion_of_creative">
      <span class="padding-right15 display-block"></span>
      <a href="#request_job_10" class="absolute-right">
        <span class="glyphicon glyphicon-pencil"></span>
      </a>
    </td>
  </tr>
</table>
<div class="bold margin-bottom10 relative">@lang('prime_projects.create.sumary.project_sumary')
  <a href="#request_job_3" class="" id="preview_tell_about_movie_detail_pencil">
    <span class="glyphicon glyphicon-pencil"></span>
  </a>
</div>
<div class="margin-bottom30 border-all-ccc padding1515015 preview_tell_about_movie_detail" style="word-wrap: break-word;">
  <span class="padding-right10" style="word-break: break-all;"></span>
</div>
<div class="text-center margin-bottom300">
  <input type="hidden" name="status" value="0">
  {!! Form::hidden('status', 0); !!}
  {{-- <button type="submit" class="btn btn-primary fontsize20 width30" disabled data-state="0">@lang('prime_projects.create.draft')</button> --}}
  <button type="submit" class="btn btn-primary fontsize20 width30" disabled data-state="10">@lang('prime_projects.create.public')</button>
  <p class="fontsize14 text-right">@lang('prime_projects.create.note')</p>
</div>
