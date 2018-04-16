@extends('layouts.ample')

@section('content-header')
<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
	<h4 class="page-title">@lang('proposals.list.title')</h4>
</div>
@endsection

@section('content')
<div class="white-box">
	<div id="proposal-body" class="box-body table-responsive">
	@include('widget.proposals.index')
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
	$(document).on('click', '[data-edit]', function () {
		$('.modal-header', '#modalWindow').text('Edit proposal')
		$('.modal-body', '#modalWindow')
		.load('/proposals/' + $(this).data('edit') + '/edit')
	});
	});
</script>
@endpush
