<style media="screen">
  .compare-control {
    margin: 15px 0 30px 0;
  }
  .time-control {
    display: inline;
  }
</style>
<div class="panel-body compare-list"
     style='overflow-x:auto; overflow-y:hidden; width:100%; white-space:nowrap;'>
     @include('widget.messages.list_no_upload', ['files' => $previewFiles])
</div>
<div class="video-container">
  <div class="col-md-6 clear-padding compare-video has-content">
      <video src="" id="video-1"></video>
  </div>
  <div class="col-md-6 clear-padding compare-video has-content">
      <video src="" id="video-2"></video>
  </div>
  {{--<div class="clearfix"></div>--}}
  <div class="col-md-12 compare-controls">
      <div class="compare-progress">
          <div class="compare-progress-bar" style="width: 0"></div>
      </div>
      <div class="compare-control">
          <div class="pull-right compare-control">
            <div class="text-muted time-control">
                <span class="current-time">00:00:00</span>/<span class="duration">00:00:00</span>
            </div>
            <span class="video-control restart"><i class="fa fa-undo"></i></span>
            <span class="video-control backward"><i class="fa fa-backward"></i></span>
            <span class="video-control play"><i class="fa fa-play"></i></span>
            <span class="video-control forward"><i class="fa fa-forward"></i></span>
            <span class="video-control volume"><i class="fa fa-volume-up"></i></span>
          </div>
      </div>
  </div>
  <div class="clearfix">
  </div>
</div>
