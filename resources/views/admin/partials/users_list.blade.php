@if (!Request::ajax())
  <div class="white-box">
    <br>
    <form id='adminuserform' class='form-horizontal' method='post' action='{{ route('admin') }}'>
      <div class="form-group">
        <div class="col-md-3">
          <label class="control-label">@lang('users.list.user_type')</label>
         <select name='kind' class='form-control input-sm'>
            @foreach (['0' => '-'] + Config::get('const.kind') as $key => $val)
              <option value="{{$key}}" {{  Request::input('kind') == $key ? 'selected' : '' }}>{{$val}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="control-label">@lang('users.list.enabled')</label>
          <select name='enabled' class='form-control input-sm'>
            @foreach (['' => '-'] + Config::get('const.enabled') as $key => $val)
              <option value="{{$key}}" {{  Request::input('enabled') === $key ? 'selected' : '' }}>{{$val}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="control-label">@lang('users.list.name')</label>
          <input type="text" style="width:100%;" name='name' value="{{Request::input('name')}}">
        </div>
        <div class="col-md-3">
          <button  style="margin-top: 20px;margin-left: 20px;" id='admin-user-search-btn' class='btn btn-lg btn-warning' data-loading-text="検索中">@lang('users.list.search')</button>
        </div>
      </div>
    </form>
  </div>
  <div id="admin-user-list" class="white-box">
  @endif
  @if (isset($users))
    {!! $users->render() !!}
    <table class="table table-condensed admin-user-list-table">
      <thead>
        <tr>
          <th>@lang('users.list.table.id')</th>
          <th>@lang('users.list.table.role')</th>
          <th>@lang('users.list.table.name')</th>
          <th>@lang('users.list.table.mail')</th>
          <th>@lang('users.list.table.date')</th>
          <th>@lang('users.list.table.action')</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td style="line-height: 3em;">
              {{--<a href="#modalWindow" role="button" data-toggle="modal" data-procname="/ajax/user/detail/{{$user['id']}}" data-title='ユーザー編集' class="btn btn-default ui-edit">{{$user->id}}</a>--}}
              {{$user->id}}
            </td>
            <td>
              @foreach ($user->roles()->pluck('name') as $role)
                {{ $role }}
              @endforeach
              <br>
              @if ($user->isEnabled())
                @lang('users.list.state.enabled')
              @else
                @lang('users.list.state.disabled')
              @endif
              <br>
              @if ($user->isNotActivatedCreator())
                <button class='btn btn-danger btn-xs active-creator' data-id="{{$user->id}}" data-loading-text="検索中">@lang('users.list.activated')</button>
              @else

              @endif
            </td>
            <td style="line-height: 3em;">
              {{--              <a role="button" href="/users/{{$user->id}}" target="_blank">{{$user->display_name}}</a> --}}
              {{$user->display_name}}
            </td>
            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a>
              <br>{{$user->tel}}
            </td>
            <td style="line-height: 3em;">{{$user->created_at}}</td>
            <td>
              <a href="{{ route('admin.user.show', ['id' => $user->id]) }}">
                <button class="btn btn-default">@lang('users.list.edit')</button>
              </a>
              <span href="#modalWindow"
              role="button" data-toggle="modal"
              data-procname="/ajax/message/send/{{$user['id']}}"
              data-title='メッセージ送信'
              class="btn btn-default send-message">@lang('users.list.mail')</span>
              <br/>
              <a href="{{ url('set-permissions/'.$user->id.'/edit') }}">
                <button class="btn btn-default">@lang('users.list.permission')</button>
              </a>
              @if ($user->isCreator())
                <a href="{{ route('creators.show', ['id' => $user->id]) }}" target="_blank">
                  <button class="btn btn-default">@lang('users.list.prop')</button>
                </a>
              @else
                <!--<a href="{{ url('users', ['id' => $user->id]) }}" target="_blank">
                  <button class="btn btn-default">表　　示</button>
                </a>-->
              @endif
            </td>
            <td>
              @if ($user->isClient())
                <a href="{{ route('admin.payments.index', ['userId' => $user->id]) }}">
                  <button type="button" class="btn btn-default">@lang('users.list.payment')</button>
                </a>
              @endif
              @if ($user->isCreator())
                <a href="{{ route('admin.rewords.index', ['userId' => $user->id]) }}">
                  <button type="button" class="btn btn-default">@lang('users.list.reword')</button>
                </a>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
  <div class="text-center">
    <a href="{{ route('admin.user.create') }}">
      <button class="btn btn-lg btn-primary" style="padding-left: 50px; padding-right: 50px">
        @lang('users.list.create')
      </button>
    </a>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  $('#adminuserform').crluoPagenation({dest: '#admin-user-list'});
  $('.pagination a').on('click' , function() {
    var $page = getParameterByName('page', $(this).attr('href'));
    localStorage.setItem('page', $page)
  });
  $(document).on('click', '.send-message', function (){
    path = $(this).attr('data-procname');
    $('.modal-title', '#modalWindow').html($(this).data('title'));
    $('div.modal-body', '#modalWindow').load(path);
  });
});
function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
  results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
</script>
