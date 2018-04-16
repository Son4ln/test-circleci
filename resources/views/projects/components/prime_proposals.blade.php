@php
  $proposals = $proposals->filter(function($item, $key) {
    return $item->state == 0;
  });
@endphp
<div style="background: #ffffff;">

    <div class="panel-heading bg-fefeff l-project-head l-bg-color-60bfb3 color-ffffff pt25-pb-25">
        <h3 style="font-size: 13px;line-height: 0;color: #ffffff">@lang('projects.show.prime_proposals')</h3>
      </div>
      <p style="padding-left: 10px;padding-top:20px;padding-bottom: 20px;">@lang('projects.show.proposal_limit') &nbsp;&nbsp;&nbsp;&nbsp; @lang('projects.show.proposals_remain', ['number' => (6 -@@ $selectedProposals)])</p>
      @if ($proposals->count())
        {{ Form::open([
            'url' => route('prime-projects.accept-proposals', ['id' => $project->id]),
            'class' => 'columns32 flexbox margin-bottom300 space-between',
            'id' => 'creators-list'
        ]) }}
          @foreach ($proposals as $proposal)
            <div class="flexbox1 background-fff relative margin-bottom20">
              <div class="checkbox checkbox-primary">
                <input type="checkbox" id="p_{{ $proposal->id }}" name="ids[]" value="{{ $proposal->id }}">
                <label for="p_{{ $proposal->id }}">@lang('projects.show.choose_proposal')</label>
              </div>
              <a href="{{ route('proposals.show', ['id' => $proposal->id]) }}">
                <div style="background-size:contain !important;background:url({{ $proposal->user->backgroundUrl }}) !important"
                class="moviesearch1-back relative">
                </div>
                <div class="fontsize14 padding10202010">
                  <!--<span class="light-green-back white radius6 margin-right10 padding0207">チーム</span>-->
                  {{ $proposal->user->name }}
                </div>
                <img class="avatar1-back absolute-right2020 border-all-fff" src="{{ $proposal->user->photoUrl }}" onerror="this.src='/images/user.png'">
              </a>
            </div>
          @endforeach
      
          <div class="text-center" style="width: 100%">
            <button class="btn btn-primary btn-lg" style="width: 300px">@lang('projects.show.select_proposal')</button>
          </div>
        {{ Form::close() }}
      @else
        @lang('')
      @endif
      
      
      @push('styles')
        {{ Html::style('css/style.css') }}
      @endpush
      

</div>