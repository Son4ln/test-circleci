@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">支払い一覧</h4>
</div>
@endsection

@section('content')

<div class="white-box">
	{{-- @can('create', \App\Payment::class)
	<div class="box-header with-border">
	<a class="btn btn-primary" href="{{ route('payments.create') }}">作成する</a>
	</div>
	@endcan --}}
	<div class="box-body table-responsive">
	<?php $paymentStatus = config('const.payment_status', []); ?>
	<table class="table table-hover payment-table">
		<thead>
		<tr>
			<th class="font-bold">@lang('payments.list.payment_date')</th>
			<th class="font-bold">@lang('payments.list.state')</th>
			<th class="font-bold">@lang('payments.list.payment_name')</th>
			<th class="font-bold">@lang('payments.list.amount')</th>
			{{-- <th></th> --}}
		</tr>
		</thead>
		<tbody>
		@foreach($payments as $payment)
		<tr>
			<td>{{ $payment->paid_at ?  $payment->paid_at->format('Y/m/d') : '----/--/--' }}</td>
			<td class="color-60bfb3">{{ $paymentStatus[$payment->status] ?? '' }}</td>
			<td>
			@if ($project = $payment->project)
				{{ $project->title . ' デポジット'}}
			@else
				デポジット
			@endif
			</td>
			<td>{{ $payment->amount / 10000 }}万円</td>
			{{-- <td>
			@can('view', $payment)
				<a class="btn btn-default" href="{{ route('payments.show', ['payment' => $payment]) }}">Detail</a>
			@endcan
			@can('update', $payment)
				<a class="btn btn-default" href="{{ route('payments.edit', ['payment' => $payment]) }}">Update</a>
			@endcan
			@can('delete', $payment)
				<a class="btn btn-danger post-link"
				data-confirm="{{ trans('このデータを削除しますか？') }}"
				href="{{ route('payments.destroy', ['payment' => $payment]) }}">Remove</a>
			@endcan
			</td> --}}
		</tr>
		@endforeach
		</tbody>
	</table>
	{{ $payments->render() }}
	</div>
</div>

@endsection
