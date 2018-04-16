@if($creators->count() <= 0)
	<h4>@lang('creators.search.no_item')</h4>
@endif


@foreach ($creators as $creator)
	<div class="col-modify">
		<div  class=" background-fff relative margin-bottom20 col-lg-3 col-md-4 col-sm-6 col-xs-12">
			<div class="border-modidy">
				<a style="background-position: center;background-size:cover !important;background-image:url({{ !empty( $creator->backgroundThumbnailUrl ) ? $creator->backgroundThumbnailUrl : 'images/avatar_blank.jpg' }}) !important" class="moviesearch1-back relative" href="{{ url('/creators/' . $creator->id) }}">
				</a>
				<div class="fontsize14 c-info">
					<a href="{{ url('/creators/' . $creator->id) }}" >  
						<img class="avatar1-back border-all-fff c-avatar-update c-u-img avatar-modify" src="{{@@$creator->photoThumbnailUrl}}" onerror="this.src='/images/user.png'">
					</a>
					<a href="{{ url('/creators/' . $creator->id) }}" class="c-u-name">
						{{ $creator->display_name }}
					</a>
				</div>
			</div>
		</div>
	</div>
@endforeach
<div class="col-md-12">
	{{ $creators->links() }}
</div>
<div class="modal fade" id="modalWindow" tabindex="-1" role="dialog" aria-labelledby="modalCompanyLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content  ">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalCompanyLabel"></h4>
	</div>
	<div class="modal-body">
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
	</div>
	</div>
</div>
</div>
@if(!isset( $pagination_ajax ))
<script type="text/javascript">
	$(document).ready(function() {
		$('#creator-filter').crluoPagenation({dest: '#creators-list'});
	});
</script>
@endif