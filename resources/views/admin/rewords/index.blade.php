@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('admin.rewords.list.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="box-header with-border">
      <a href="{{ route('admin.rewords.create', ['userId' => request()->route()->parameters['userId']]) }}">
        <button type="button" class="btn btn-primary">@lang('admin.rewords.list.create')</button>
      </a>
    </div>
    <section class="box-body ui-reword">
      <table class='table'>
        <thead>
          <tr>
            <th>@lang('rewords.list.date')</th>
            <th>@lang('rewords.list.project_name')</th>
            <th>@lang('rewords.list.amount')</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rewords as $reword)      
            <tr>
              <td>
                @if ($reword->reword_date)
                  {{date('Y/m/d ',strtotime($reword->reword_date))}}
                @else
                  {{date('Y/m/d ',strtotime($reword->created_at))}}
                @endif
              </td>
              <td><a href="{{ route('projects.show', ['id' => $reword->project_id]) }}">
                {{$reword->project_title}}
              </a></td>
              <td>{{number_format($reword->reword)}}円</td>
              <td>
                <a href="{{ route('admin.rewords.edit', ['id' => $reword->id]) }}" target="_blank">
                  <button class="btn btn-warning">@lang('admin.rewords.list.edit')</button>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class='ui-page-reword'>
        {!! $rewords->render() !!}
      </div>
    </section>
  </div>
@endsection
