<h2 class="oshirase-page-header"><img src="../images/index_tit_icon1.png" alt="">  @lang('dashboards.new_projects')</h2>
<div class="row" style="margin-top: 20px;">
  @if(isset( $projects ))
  @foreach ($projects as $project)
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="panel panel-default item-project">
          <a class="panel-heading user-thumb-project"
          href="{{ url('projects', ['id' => $project->id]) }}">
            <img class='user-thumb-project' src="{{ $project->display_image }}" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"><img>
          </a>
        <div class="panel-body">
          <h5><strong>{{str_replace('"','',$project->title)}}</strong></h5>
          <p class="wrap"></p>
          <br><br>
          <small>{{$project->nickname}}</small>
        </div>
        <div class='panel-footer' style='padding:5px 10px 5px 10px'>
          <!--締切{{date(' n/d ',strtotime($project->duedate_at))}}｜ -->
          @lang('partials.project_item.proposals_count') {{number_format($project->proposals()->count())}}@lang('partials.project_item.unit')｜<span style="color:#cc2222;">@lang('partials.project_item.budget') {{number_format($project->price_min)}}@lang('partials.project_item.currency')-{{number_format($project->price_max)}}@lang('partials.project_item.currency')</span>
        </div>
      </div>
  </div><!-- /.col -->

  @endforeach
  @endif

</div>
