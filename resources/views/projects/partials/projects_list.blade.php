<div class="isopanel">
  @foreach ($projects as $project)
    <!-- Three columns of text below the carousel -->
    <div class="panel panel-default user-panel-project">
      <a class="panel-heading user-thumb-project" href="{{ url('projects/'.$project->id) }}"
        data-procname="{{$project->id}}"
        >
        <img class='user-thumb-project' src='{{ $project->display_image }}'
        onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"/>
        <div style='position:absolute;top:0;left:10px'>
          <h4 class="wrap">
            <div class="label {{ $project->status_label }}">
              {{ config('const.project_status.' . $project->status) }}
            </div>
          </h4>
        </div>
      </a>
      <div class="panel-body">
        <label>{{str_replace('"','',$project->title)}}</label><br>
        <div>{{$project->detail}}</div>
        <div>
          <br>
          {{--          <button class="btn  ghost_gray"  onclick='$("#proj{{$project->id}}").submit()'><span class='glyphicon glyphicon-blackboard'></span>Project</button> --}}
        </div>
      </div>
      <div class='panel-footer'>
        <form method='post' action='/work' id='proj{{$project->id}}'>
          <input type='hidden' name='project_id' value='{{$project->id}}'>
          <input type='hidden' name='_token' value='{{{ csrf_token() }}}'>
          @can ('update', $project)
            <a class="glyphicon glyphicon-pencil" href="{{ url('projects/'.$project->id.'/edit') }}">@lang('projects.creator_list.edit')</a>
          @endcan
          <small class='pull-right'>{{date('Y/m/d ',strtotime($project->updated_at))}}</small>
          <div class="clearfix"></div>
        </form>
      </div>
    </div>
  @endforeach
  <div style="width: 100%">
    {{ $projects->render() }}
  </div>
</div>

<script src="/js/jquery.isotope.js" type="text/javascript"></script>
<script>
$(document).ready(function () {

  var $container = $('.isopanel');
  $container.isotope({
    filter: '*',
    animationOptions: {
      duration: 250,
      easing: 'linear',
      queue: false
    }
  });

  $('span.ui-edit').click(function () {

    $('div.modal-body', '#modalWindow').html("");
    $('.modal-title', '#modalWindow').html("プロジェクト登録");
    $('div.modal-body', '#modalWindow').load('/ajax/project/add', {
      '_token': '{{{ csrf_token() }}}',
      'id': name
    }, function (response, status, xhr) {
      if (status == "error") {
        $('div.modal-body', '#modalWindow').html(xhr.responseText);
      }
    });
  });
  // $('div.user-thumb-project').click(function (){
  // $('div.modal-body', '#modalWindow').html("");
  // $('.modal-title', '#modalWindow').html("プロジェクト");
  // $('div.modal-body', '#modalWindow').load('/projects/' + $(this).attr('data-procname'), function(response, status, xhr) {
  //   if (status == "error") {
  //     $('div.modal-body', '#modalWindow').html(xhr.responseText);
  // }
  // });
  // });
  $('a.ui-edit-project').click(function () {
    $('div.modal-body', '#modalWindow').html("");
    $('.modal-title', '#modalWindow').html("プロジェクト編集");
    $('div.modal-body', '#modalWindow').load('/ajax/project/get', {
      '_token': '{{{ csrf_token() }}}',
      'id': $(this).attr('data-procname')
    }, function (response, status, xhr) {
      if (status == "error") {
        $('div.modal-body', '#modalWindow').html(xhr.responseText);
      }
    });
  });

})
</script>
