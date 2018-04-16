@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('payments.list.title')</h4>
  </div>
@endsection

@section('content')
  <div class="white-box">
    <div class="box-header with-border">
      <a href="{{ route('admin.payments.create', ['userId' => request()->route()->parameters['userId']]) }}">
        <button type="button" class="btn btn-primary">@lang('admin.payments.list.create')</button>
      </a>
    </div>
    <div class="box-body">
      <?php $paymentStatus = config('const.payment_status', []); ?>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>@lang('payments.list.payment_date')</th>
            <th>@lang('payments.list.project_name')</th>
            <th>@lang('payments.list.state')</th>
            <th>@lang('payments.list.payment_name')</th>
            <th>@lang('payments.list.amount')</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
          <tr>
            <td>{{ $payment->paid_at ?  $payment->paid_at->format('Y/m/d') : '----/--/--' }}</td>
            <td>
              @if ($project = $payment->project)
                {{ $project->title }}
              @endif
            </td>
            <td>{{ $paymentStatus[$payment->status] ?? '' }}</td>
            <td>{{ $payment->title }}</td>
            <td>{{ $payment->amount / 10000 }}万円</td>
            <td>
              <a class="btn btn-default" href="{{ route('admin.payments.edit', [
                'id' => $payment->id,
                'userId' => $payment->user_id]) }}" target="_blank">@lang('admin.payments.list.edit')</a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      {{ $payments->render() }}
    </div>
  </div>
@endsection
