<div class="row">

  <div class="col-md-12">

    <h2 class="oshirase-page-header"><img src="../images/index_tit_icon1.png" alt=""> @lang('dashboards.deloying_projects')</h2>        
    @if(isset( $making ))

      <!-- Info box -->
      <div class="panel panel-default user-panel-project" >
        <a class="panel-heading user-thumb-project"
        href="{{ url('projects', ['id' => $making->id]) }}">
          @php
          if ($making->image) {
              $making_display_image = Storage::disk('s3')->url($making->image);
          } else {
              $making_display_image = isset( $making->user->background_url ) ? $making->user->background_url : '';
          }

          @endphp
          <img class='user-thumb-project' src="{{ $making_display_image }}" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"><img>
        </a>
      <div class="panel-body">
        <h5><strong>{{str_replace('"','',$making->title)}}</strong></h5>

        <p class="wrap"></p>
        <br>
        <div class="project-box-button">
	        <a href="{{ url('creative-rooms', ['id' => $making->room_id]) }}">
	          <button class="btn  ghost_gray"><img src='/images/creative.png' height=25px><img> @lang('partials.project_item.rooms')</button>
	        </a>
	    </div>

      </div>
      <div class='panel-footer' style='padding:5px 10px 5px 10px'>
        <p><img src="/images/deco_bg_t.png"/></p>
        @lang('partials.project_item.delivery'){{date(' n/d ',strtotime($making->duedate_at))}}｜@lang('partials.project_item.budget') {{number_format($making->price_min)}}@lang('partials.project_item.currency')-{{number_format($making->price_max)}}@lang('partials.project_item.currency')
      </div>
      <!--div class="project-box-button">
          <a href="{{ url('creative-rooms', ['id' => $making->room_id]) }}">
            <button class="btn  ghost_gray">@lang('partials.project_item.rooms')</button>
          </a>
      </div-->
    </div>
  @endif

</div><!-- /.col -->
<div class="col-md-12">

  <h2 class="oshirase-page-header"><img src="../images/index_tit_icon1.png" alt=""> @lang('dashboards.submiting_projects')</h2>

  <!-- Info box -->
  <div class="box ">
    <div class="box-body">
      <div class="table-responsive">
        <!-- .table - Uses sparkline charts-->

        <table class="table table-striped">
          @if( isset($proposals) )
          @foreach($proposals as $proposal)
            <tr>
              <td>
                <a class="ui-list-entry" href="{{ url('projects/'.$proposal->project_id) }}">
                  {{$proposal->project_title}}
                </a>
              </td>
              <td class="ccc">@lang('partials.project_item.duedate') {{date('m/d ',strtotime($proposal->created_at))}}</td>
            </tr>
          @endforeach
          @endif

        </table><!-- /.table -->
      </div>
    </div><!-- /.box-body -->
    <div class="project-box-footer ccc">
      <a href='/proposals'>@lang('dashboards.projects_history')</a>
    </div><!-- /.box-footer-->
  </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
