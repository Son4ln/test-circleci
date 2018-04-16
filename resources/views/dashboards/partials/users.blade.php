@php
$group = [0 => '-'];
$group += Config::get('const.group');
@endphp
@if (!Request::ajax())
  <div class="">
    <br>
    <form id='adminuserform' class='form-horizontal' method='post' action='users/filter'>
      <div class="form-group">
        <label class="col-md-2 control-label">kind</label>
        <div class="col-md-4">

          <select name='kind' class='form-control input-sm'>
            @foreach (Config::get('const.kind') as $key => $val)
              <option value="{{$key}}" {{  Request::input('kind') == $key ? 'selected' : '' }}>{{$val}}</option>
            @endforeach
          </select>

          <select name='enabled' class='form-control input-sm'>
            @foreach (['' => '-'] + Config::get('const.enabled') as $key => $val)
              <option value="{{$key}}" {{  Request::input('enabled') == $key ? 'selected' : '' }}>{{$val}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">名称</label>
        <div class="col-md-4">
          <input type=text name='name' value="{{Request::input('name')}}">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-2">
          <button id='admin-user-search-btn' class='btn btn-warning' data-loading-text="検索中">検索</button>
        </div>
      </div>
    </form>
  </div>
  <div id="admin-user-list">
  @endif
  @if (isset($users))
    {!! $users->render() !!}
    <table class="table table-condensed admin-user-list-table">
      <thead>
        <tr>
          <th>id</th>
          <th>状態</th>
          <th>名前</th>
          <th>メール&電話番号</th>
          <th>登録種別&知った</th>
          <th>登録日時</th>
          <th>メール</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>
              <span href="#modalWindow" role="button" data-toggle="modal" data-procname="/ajax/user/detail/{{$user['id']}}" data-title='ユーザー編集' class="btn btn-default ui-edit">{{$user->id}}</span>
            </td>
            <td>
              @foreach ($user->roles()->pluck('name') as $role)
                {{ $role }}
              @endforeach
              <br>
              @if ($user->isActivatedCreator())
                有効
              @else
                <button class='btn btn-danger btn-xs active-creator' data-id="{{$user->id}}" data-loading-text="検索中">有効にする</button>
              @endif
            </td>
            <td>
              <a  class="btn btn-success btn-block" role="button" href="/users/{{$user->id}}" target="_blank">{{$user->display_name}}</a>
            </td>
            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a>
              <br>{{$user->tel}}
            </td>
            <td>{{$group[$user->group]}}<br>{{$user->knew}}</td>
            <td>{{$user->created_at}}</td>
            <td>
              <span href="#modalWindow"
              role="button" data-toggle="modal"
              data-procname="/ajax/message/send/{{$user['id']}}"
              data-title='メッセージ送信'
              class="btn btn-default glyphicon glyphicon-envelope send-message"></span>
              <a href="{{ url('set-permissions/'.$user->id.'/edit') }}">
                <button class="btn btn-info"><i class="glyphicon glyphicon-cog"></i></button>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
<script type="text/javascript">
$(document).ready(function () {
  $('#adminuserform').crluoPagenation({dest: '#admin-user-list'});
})
</script>
