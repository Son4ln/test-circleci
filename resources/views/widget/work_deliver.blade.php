<div class='panel panel-default'>
<div class='panel-heading'>@lang('creative_rooms.show.delivery_title')
</div>
<div class="panel-body ui-deliver-list" data-remote="{{ url('/files/upload/deliver') }}"
	style='overflow-x:auto; overflow-y:hidden; width:100%; white-space:nowrap;'>
	@include('widget.messages.deliver_list', ['files' => $deliverFiles])
</div>

</div>

@push('styles')
<style media="screen">
.qq-upload-button, .qq-drop-processing {
	display: none;
}
</style>
@endpush
