<style>
  .ui-preview-movie {
    display: inline-block;
    margin-right: 1%;
    white-space: normal;
    position: relative;
  }

  .ui-preview-movie > div {
    position: relative
  }

  .ui-preview-movie img {
    width: 160px;
    max-width: 160px;
    max-height: 90px;
  }

  .ui-preview-movie img + span {
    position: absolute;
    bottom: 0px;
    right: 0px;
    margin: 0px;
    color: rgb(201, 201, 201);
    text-shadow: -1px -1px #000, 1px -1px #000, -1px 1px #000, 1px 1px #000;
  }

  .ui-delete-movie, .ui-share-movie {
    position: absolute;
    width: 24px;
    height: 22px;
    top: 3px;
    right: 3px;
    display: none;
  }

  .ui-preview-movie:hover .ui-share-movie, .ui-preview-movie:hover .ui-delete-movie {
    display: block;
  }
</style>

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>エラー</strong><br>
    @foreach ($errors->all() as $error)
      {{ $error }}<br>
    @endforeach
  </div>
@endif

<div id="deliver_upload" class="block-inline  uploader-not-display">
</div>

@foreach ($files as $file)
  <div class="media">
    <div class="media-body">
      <div class="media-header">
        <a download='{{$file->title}}' href="{{ $file->path }}">
            <span style="color:#3c8dbc;">{{$file->title}}</span>
        </a>
        @can('delete', $file)
          <span roll='button' class="btn btn-danger btn-xs glyphicon glyphicon-trash ui-del-deliver pull-right" data-id='{{$file->id}}'></span>
        @endcan
      </div>
    </div>
  </div>
@endforeach

<script type="text/javascript">
  $(document).ready(function() {
    $('#deliver_upload').dropFile({
      source: '#video',
      type: 3,
      replace: '.ui-deliver-list',
      thumbnail: true,
      validation: true,
      prefix: 'files/' + $('#creativeroom_id').val() + '/'
    })
  })
</script>
