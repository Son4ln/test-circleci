<style>
fieldset > ul {
  list-style:none;
}
fieldset > ul > li > label{
  width: 100%;
}
</style>
<div class="page-header">
  @lang('admin.messages.debug')
</div><!-- /.page-header -->
<form class='form-horizontal' action="/messages" id="create-message">
  <fieldset id='sendmesform'>
    <input type="hidden" name="kind" value="1">
    <ul>
      <li>
        <label>@lang('admin.messages.sender')</label>
        <select name='send_user_id' class='form-control input-sm'>
          <option value="0">--</option>
          @foreach ($allUsers as $user)
            <option value="{{$user->id}}"
              {{ Request::input('user_id') == $user->id ? 'selected' : '' }}>
              {{$user->name}}
            </option>
          @endforeach
        </select>
      </li>
      <li>
        <label>@lang('admin.messages.receiver')</label>
        <select name='user_id' class='form-control input-sm'>
          <option value="0">--</option>
          @foreach ($allUsers as $user)
            <option value="{{$user->id}}"
              {{ Request::input('user_id') == $user->id ? 'selected' : '' }}>
              {{$user->name}}
            </option>
          @endforeach
        </select>
      </li>
      <li>
        <label>@lang('admin.messages.title')</label>
          <input type='text' class='form-control' name='title' value='{{Request::input('title')}}'>
      </li>
      <li>
        <textarea class='form-control' name='message' style='margin: 1rem 0;'></textarea>
      </li>
      <li>
        <button class='btn btn-warning  pull-right' data-loading-text="送信中">@lang('admin.messages.message_submit')</button>
      </li>
    </ul>
  </fieldset>
</form>
<div id='error'>
</div>
