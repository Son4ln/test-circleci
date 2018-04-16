@extends('layouts.ample')

@section('content')
  <div class="row">
    <div class="col-sm-6">
      <div class="box">
        <div class="box-body">
          <div class="well well-sm">
  <!--          <p>{{ $plan->id }}: {{ $plan->name }}</p> -->
            <h3>@lang('subscriptions.index.plans.22')</h3>
          </div>
          {{--@empty($isSubscribed)--}}
          @component('payments.partials.credit_card', [
            'action' => route('subscriptions.subscribe'),
            'method' => 'POST',
            'submit' => 'Subcribe',
            'allowCoupon' => true,
          ])
            <input type="hidden" name="plan" value="{{ $plan->id }}">
          @endcomponent
          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>@lang('ui.has_error')</strong>@lang('ui.has_error_text')<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          {{--@endempty--}}
        </div>
      </div>
    </div>
  </div>
@endsection
