@foreach ($files as $file)
  <div class="btn btn-black movie-drag"
  data-fileid='{{ $file->id }}' data-procname="{{ $file->path }}"
  data-toggle="tooltip" data-placement="top" title="{{ $file->title }}"
  role="button" draggable="true">
    <div>
      <img src="{{ $file->thumb_path }}"
      onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='">
      <span> {{ date('Y/m/d h:i', strtotime($file->created_at)) }} </span>
    </div>
 </div>
@endforeach
