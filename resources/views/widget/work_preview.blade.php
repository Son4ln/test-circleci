<div class='panel panel-default'>
  <div class='panel-heading'>
    @lang('creative_rooms.show.preview_title')
    <div class="btn btn-group pull-right" style="margin-top: -13px">
      <button type="button" class="btn btn-warning preview-control" data-href="#section-1">
        @lang('admin.rooms.show.preview_mode')
      </button>
      <button type="button" class="btn btn-default preview-control" data-href="#section-2">
        @lang('admin.rooms.show.compare_mode')
      </button>
    </div>
  </div>

  <div id="section-1" class="pane">
    <div class="panel-body ui-preview-list" data-remote="{{ url('/files/upload/preview') }}"
    style='overflow-x:auto; overflow-y:hidden; width:100%; white-space:nowrap;'>
    @include('widget.messages.preview_list', ['files' => $previewFiles])
  </div>
  <div class="panel-footer" id="panel-video">
    <div class="row">
      <div id="pv-container" class="col-md-8">
        <video id='pv-video' width='100%' autobuffer autoplay></video>
        <svg id='pv-caption' xmlns="http://www.w3.org/2000/svg"></svg>
        <svg id='pv-draw' xmlns="http://www.w3.org/2000/svg"></svg>
        <div style="position: relative; z-index: 2003">
          <div id="progress"
          class="progress ui-progress-time"
          role=button
          style="overflow: visible">
          <div id="pv-pgss" class="progress-bar progress-bar-info" ></div>
        </div>
        <div id='pv-controller-controll'>
          <button class='btn ui-player-rect' data-toggle="tooltip" data-placement="top" title="線で囲みコメントを入力"><span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span></button>
          <button class='btn ui-player-text' data-toggle="tooltip" data-placement="top" title="コメントを入力"><span class='' aria-hidden="true"><strong>T</strong></span></button>
          <div class='pull-right'>
            <span class='ui-prev-time'></span>
            <button class='btn' id="restart"><span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span></button>
            <button class='btn' id="prev"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
            <button class='btn ui-player-play'><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
            <button class='btn' id="next"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></button>
            <button class='btn ui-player-mute'><span class="glyphicon glyphicon-volume-off"></span></button>
          </div>
        </div>
        <div>
          <span class=''>　</span>
          <span class='ui-prev-title'></span>
          <br>
          <br>
        </div>
        <!--center>コメントリスト</center-->
      </div>
      <div id='pv-text'>
        <div class='ui-prev-input'>
          <div class='form-group' >
            <label>@lang('creative_rooms.show.time')</label>
            <select class=''>
              <option value=3>3</option>
              <option value=5 selected="true">5</option>
              <option value=10>10</option>
            </select>
          </div>
          <div class='form-group' >
            <label>@lang('creative_rooms.show.comment')</label>
            <input type='text' class='form-control'>
          </div>
          <div class='form-group' >
            <button class='btn btn-default' data-kind='cancel'>@lang('creative_rooms.show.cancel')</button>
            <button class='btn btn-success' data-kind='decide'>@lang('creative_rooms.show.ok')</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <table id='pv-list' class='table'>
      </table>
    </div>
  </div>
</div>
</div>

<div class="hidden clearfix pane" id="section-2">
  @include('widget.messages.compare')
</div>
<div class="modal fade" id="modalUrlWindow" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel" aria-hidden="false">
  <div class="modal-dialog"  style="">
    <div class="modal-content" style="">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=""><span aria-hidden="true" style="">&times;</span></button>
        <h4 class="modal-title">共有用URL <small> ※ 有効期限 24h</small></h4>
      </div>
      <div class="modal-body">
        <textarea id="modalUrlText" rows=5 style="width:100%"></textarea>
      </div>
      <div class="modal-footer">
        <div class="portfolio-detail "> </div>
      </div>
    </div>
  </div>
</div>
</div>
<input type="hidden" id="captionType" value="rect">
