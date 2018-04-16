@if (!Request::ajax())
<style media="screen">
    .font14 {
        font-size: 14px;
    }
    .font14 span {
        cursor: pointer;
    }
</style>
<div class="alert alert-info alert-dismissable">
  <i class="fa fa-info"></i>
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  @lang('creative_rooms.show.messages_file_alert')
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>@lang('creative_rooms.show.project_file')
  </div>
  <div class="panel-footer">
    <div id="files_upload"  class="uploader-not-display">
    </div>
    <!--div class="progress">
      <div class="progress-bar ui-progress-file" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
      </div>
    </div-->
  </div>

  <div class="panel-body" id="files_list">
@endif
@foreach ($files as $file)
    <div class="media">
        <div class="media-body">
            <div class="media-header font14">
                <a target=_blank href="{{$file->path}}" download='{{$file->title}}'>
                    <span style="color:#3c8dbc;">{{$file->title}}</span>
                </a>
              @can('delete', $file)
                <span roll='button' class="glyphicon glyphicon-remove-sign ui-del-file  pull-right" data-id='{{$file->id}}'></span>
              @endcan
            </div>
        </div>
    </div>
@endforeach

@if (!Request::ajax())
    <div class='ui-page-file'>
      {!! $files->render() !!}
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('#files_upload').dropFile({
    type: 1,
    replace: '#files_list',
    validation: false,
    thumbnail: false,
    allowAll: true,
    prefix: 'files/' + $('#creativeroom_id').val() + '/'
  })
})
</script>
@endif
