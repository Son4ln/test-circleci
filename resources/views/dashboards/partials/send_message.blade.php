<style>
fieldset > ul {
    list-style:none;
}
fieldset > ul > li > label{
    width: 100%;
}
</style>
<div class="page-header">
    他のユーザーにメッセージをおくれます
</div><!-- /.page-header -->
<form class='form-horizontal' action="/messages" id="create-message">

    <fieldset id='sendmesform'>
        <input type="hidden" name="kind" value="1">
        <ul>
            {{-- <li><label>メッセージ種別</lable>
                <select name='kind' class='form-control input-sm'>
                    @foreach (['1' => 'メッセージ', '2' => 'お知らせ'] as $key => $val)
                        <option value="{{$key}}" {{  Request::input('kind') == $key ? 'selected' : '' }}>{{$val}}</option>
                    @endforeach
                </select>
            </li> --}}
            <li><label>送信元</label>
                <select name='send_user_id' class='form-control input-sm'>
                    <option value="0">--</option>
                    @foreach ($allUsers as $user)
                        <option value="{{$user->id}}"
                            {{ Request::input('user_id') == $user->id ? 'selected' : '' }}>
                            {{$user->name}}</option>
                    @endforeach
                </select>
            </li>
            <li><label>宛先</lable>
                <select name='user_id' class='form-control input-sm'>
                    <option value="0">--</option>
                    @foreach ($allUsers as $user)
                        <option value="{{$user->id}}"
                            {{ Request::input('user_id') == $user->id ? 'selected' : '' }}>
                            {{$user->name}}</option>
                    @endforeach
                </select>
            </li>
            <li><label>タイトル</lable>
                <input type='text' class='form-control' name='title' value='{{Request::input('title')}}'>
            </li>
            <li>
                <textarea class='form-control' name='message' style='margin: 1rem 0;'></textarea>
                <li>
                    <button class='btn btn-warning  pull-right' data-loading-text="送信中">送信</button>
                </li>
            </ul>
        </fieldset>
    </form>
    <div id='error'>
    </div>
