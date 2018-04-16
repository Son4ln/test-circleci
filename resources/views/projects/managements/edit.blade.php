@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.project_states.title')</h4>
  </div>
  <a class="pull-right" href="{{ url('projects-state') }}">
    <button type="button" class="btn btn-danger">@lang('admin.project_states.back')</button>
  </a>
@endsection

@section('content')
  @php $states = Config::get('const.project_status') @endphp
  @if ($project->is_prime)
    @php
      unset($states[50], $states[60]);
    @endphp
  @endif
  <form id="state_form" class="form-horizontal white-box" method="POST" action="{{ url('project-states/'.$project->id) }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="status" value="{{ $project->status }}">
    <div class="form-group">
      <label class="col-sm-2 control-label">@lang('admin.project_states.project_name')</label>
      <div class="col-sm-8">
        <a href="{{ route('projects.show', ['id' => $project->id]) }}">
          <strong style="display: block; padding-top: 7px">{{ $project->title }}</strong>
        </a>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">@lang('admin.project_states.amount')</label>
      <div class="col-sm-8" style="padding-top: 6px">
        <label class="label label-primary">{{ $project->offeredProposal()->price2 ?? 0 }}</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">@lang('admin.project_states.price')</label>
      <br>
      <div class="col-sm-8" style="margin-top: -20px">
        <span id="price_min">{{ $project->price_min }}</span>　万円 - <span id="price_max">{{ $project->price_max }}</span> 万円
        <input type="hidden" name="price_min" value="{{ $project->price_min }}">
        <input type="hidden" name="price_max" value="{{ $project->price_max }}">
        <div id="slider"></div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">@lang('admin.project_states.state')</label>
      <div class="col-sm-8">
        @foreach ($states as $key => $state)
          <button class="btn btn-xs state {{ $key == $project->status ? 'btn-success disabled' : 'btn-default' }}"
            data-key="{{ $key }}"
            type="button">
            {{ $state }}
          </button>
        @endforeach
      </div>
    </div>
    <div class="text-center" style="margin-bottom: 15px; margin-top: 15px">
      @lang('admin.project_states.alert')
    </div>
    <div class="form-group">
      <label class="col-md-2"></label>
      <div class="col-sm-8">
        <button class="btn btn-warning">@lang('admin.project_states.button')</button>
        @can ('public', $project)
          <button class="hidden" name="public" id="public_submit">
          </button>
          <button type="button" name="public" class="btn btn-success" data-toggle="modal" data-target="#confirm_submit">
            @lang('admin.project_states.button_1', ['count' => \App\User::creator()->count()])
          </button>
        @endcan
        @if ($project->isStatus('pending'))
          <button class="btn btn-info" type="button" onclick="document.getElementById('acceptance').submit()">
            @lang('admin.project_states.button_2')
          </button>
        @endif
      </div>
    </div>
  </form>
  {{ Form::open([
    'url'   => url('project-states/acceptance'),
    'id'    => 'acceptance',
    'class' => 'hidden'
  ]) }}
    {{ Form::hidden('project_id', $project->id) }}
  {{ Form::close() }}
  @if ($project->isPrime())
    <div class="well">
      <label class="label label-danger">C-Operation</label>
      <p></p>
      @if ($proposals->count())
        <table class="table">
          @foreach ($proposals as $proposal)
            <tr>
              <td>{{ $proposal->user->name }}</td>
              <td><label class="label {{ $proposal->label }}">{{ config('const.project_status.' . $proposal->state) }}</label></td>
              <td>
                @if ($proposal->state == $proposal->states['pending'])
                  <a href="{{ route('operation.admin_acceptance', ['id' => $proposal->id]) }}">
                    <button type="button" class="btn btn-default">@lang('admin.project_states.button_2')</button>
                  </a>
                @endif
              </td>
            </tr>
          @endforeach
        </table>
      @endif
    </div>
  @endif
  <div class="modal fade" id="confirm_submit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body text-center">
          @lang('admin.project_states.confirm')
        </div>
        <div class="modal-footer">
          <button id="ok" class="btn btn-success">@lang('admin.project_states.yes')</button>
          <button class="btn btn-default" data-dismiss="modal">@lang('admin.project_states.no')</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  {{ Html::style('adminlte/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css') }}
@endpush

@push('scripts')
  {{ Html::script('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}
  <script type="text/javascript">
    $(document).ready(function() {
      $('#ok').click(function() {
        $('#public_submit').click();
      });
      $("#slider").slider({
        range: true,
        min: 5,
        max: 500,
        values: [{{ $project->price_min }}, {{ $project->price_max }}],
        slide: function (event, ui) {
          $('#price_min').text(ui.values[0])
          $('#price_max').text(ui.values[1])
          $('input[name="price_min"]').val(ui.values[0])
          $('input[name="price_max"]').val(ui.values[1])
        }
      });

      $('.state').click(function() {
        $('.state').removeClass('btn-success disabled').addClass('btn-default')
        $(this).removeClass('btn-default').addClass('btn-success disabled')
        $('input[name="status"]').val($(this).data('key'))
      });
    });
  </script>
@endpush
