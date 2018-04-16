@if ($proposals->count())
  <div class="panel panel-default">
    <div class="panel-heading">
      採択したクリエイター
    </div>
    <div class="panel-body">
      @foreach ($proposals as $proposal)
        <div class="c-operation-proposal">
          {{ $proposal->user->name }} <label class="label {{ $proposal->label }}">{{ config('const.project_status.' . $proposal->state) }}</label>
          <br>
          @if ($proposal->state == $proposal->states['checking'])
            <a href="{{ route('operation.client_acceptance', ['id' => $proposal->id]) }}">
              <button type="button" class="btn btn-danger">検収申請を受付ました</button>
            </a>
          @endif
          <a href="{{ route('creative-rooms.show', ['id' => $proposal->room_id]) }}">
            <button class="btn btn-default">@lang('projects.show.creator_room')</button>
          </a>
        </div>
      @endforeach
    </div>
  </div>
@endif
