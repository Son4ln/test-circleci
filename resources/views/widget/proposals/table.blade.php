<strong style="font-size: 17px; margin-bottom: 20px;">@lang('proposals.table.total'): <span class="color-60bfb3">{{ $project->proposals->count() }}</span></strong>
<table class="table table-striped l-p-proposal-table">
  @foreach ($project->proposals as $proposal)
    @if ($proposal->user_id == Auth::id() || $project->isOwn() || Auth::user()->isAdmin())
      <tr>
        <td  class="l-td-bg-525252 text-center" style="width: 200px"><strong> {{ $proposal->user->name }} </strong></td>
        <td style="text-align: center;color:#363636"><strong>{{ number_format($proposal->price) }}</strong>円</td>
        <td style="text-align: center">
          <a target="_blank" href="{{ route('proposals.show', ['id' => $proposal->id]) }}">
            <button class="btn  btn-xs l-btn-new-border-radius">@lang('proposals.table.detail')</button>
          </a>
        </td>
        @can('chooseProposal', $project)
          <td class="">
            <a href="#modalWindow" data-toggle="modal">
              <button class="btn btn-info btn-xs send-message l-btn-new"
                data-user="{{ $proposal->user->id }}"
                data-proposal="{{ $proposal->id }}">
                @lang('proposals.table.message')
              </button>
            </a>
            @if (!$proposal->offer && $project->canSelect())
              <a href="#proposal_confirm" data-toggle="modal">
                <button class="btn btn-warning btn-xs accept "
                  data-user="{{ $proposal->user_id }}"
                  data-proposal="{{ $proposal->id }}">
                  @lang('proposals.table.accept')
                </button>
              </a>
            @endif
          </td>
        @endcan
      </tr>
    @endif
  @endforeach
</table>
<form id="accept-form" action="{{ url('creative-rooms/ajax-store') }}" method="post">
  <input type="hidden" name="project_id" value="{{ $project->id }}">
  <input type="hidden" name="owner_id" value="{{ $project->user_id }}">
  <input type="hidden" name="proposal_id">
  <input type="hidden" name="user_id">
  {{ csrf_field() }}
</form>
