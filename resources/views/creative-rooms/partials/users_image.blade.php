@foreach ($users as $user)
  <img src="{{ $user->photoThumbnailUrl }}" alt="{{ $user->name }}" title="{{ $user->name }}" class="circel-xs-image">
@endforeach
