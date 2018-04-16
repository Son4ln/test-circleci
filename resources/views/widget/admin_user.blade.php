<?php
  $group = [0 => '-'];
  $group += Config::get('const.group');
?>
@if (!Request::ajax())
    <div class="">
        <br>
        <form id='adminuserform' class='form-horizontal' method='post' action='/admin/user/list'>
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
                  {{Config::get('const.kind')[$user->kind]}}<br>
                  @if ($user->enabled >= 1)
                    {{Config::get('const.enabled')[$user->enabled]}}
                  @else
                    <button class='btn btn-danger btn-xs admin-user-enable-btn' data-id="{{$user->id}}" data-loading-text="検索中">有効にする</button>
                  @endif
                </td>
                <td>
                <a  class="btn btn-success btn-block" role="button" href="/profile/{{$user->id}}" target="_blank">{{$user->name}}</a></td>
                <td><a href="mailto:{{$user->email}}">{{$user->email}}</a>
                <br>{{$user->tel}}</td>
                <td>{{$group[$user->group]}}<br>{{$user->knew}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                <span href="#modalWindow" role="button" data-toggle="modal" data-procname="/ajax/message/send/{{$user['id']}}" data-title='メッセージ送信' class="btn btn-default glyphicon glyphicon-envelope"></span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
<script>
            /* modal dialog */
        $('span[data-toggle="modal"]', '.admin-user-list-table').click(function (){
            $('.modal-title', '#modalWindow').html($(this).attr('data-title'));
            $('div.modal-body', '#modalWindow').load( $(this).attr('data-procname'));
        });
        $('button.admin-user-enable-btn', '.admin-user-list-table').click(function (){
            var $parent = $(this).parent();
            var $btn = $(this).button('loading');
            var $div = $('#loading').fadeIn();
            //$.ajaxSetup({ async: false });
            var $data = {'_token' : '{{{ csrf_token() }}}', 'id' : $(this).attr('data-id')};
            $.ajax({
            url: "/admin/user/enable",
            data: $data,
            type: "post",
            dataType : "html",
            success: function( data ) {
                $parent.html('有効');
                $div.fadeOut();
            },
            error: function( xhr, status ) {
                console.log( xhr);
                $('#loading').html(xhr.responseText);
            },
            complete: function( xhr, status ) {
                $btn.button('reset');
            }
            });
        });
        $('#adminuserform').crluoPagenation({dest: '#admin-user-list'});

</script>
@if (!Request::ajax())
    </div>

<script>
    (function($){
        $('#adminuserform').crluoFormInputSearch({dest: '#admin-user-list'});
        console.log("userchange")
        $('input[name="name"]','#adminuserform').change();

        /* modal dialog
        $('span[data-toggle="modal"]', '.admin-user-list-table').click(function (){
            $('.modal-title', '#modalWindow').html($(this).attr('data-title'));
            $('div.modal-body', '#modalWindow').load( $(this).attr('data-procname'));
        });
 */

    })(jQuery);
</script>
@endif
