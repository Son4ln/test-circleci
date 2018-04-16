<!--1-->
@php
  if( !isset($i) )
    $i = 0;

  if( !isset($index) )
    $index = 0;
@endphp 
<div style="height: 255px;" data-id="{{$portfolio->id}}" data-index={{$i+$index}} data-original-title="{{$portfolio->title}}" title="{{$portfolio->title}}"  data-toggle="tooltip" class="flexbox1 background-fff relative margin-bottom20 col-md-6">
  <a style="background:url({{$portfolio->ThumbUrl}})" class="moviesearch1-back relative" href="{{ url('/portfolios/' . $portfolio->id) }}">
    <!-- @if (strpos($portfolio->mime, 'video') !== false)
      <button class="button-blue">
        <img src="{{ asset('images/video_play_button.png') }}" alt="Play video">
      </button>
    @else
      <button class="button-red">
        <img src="{{ asset('images/image_show_button.png') }}" alt="Show image">
      </button>
    @endif -->

    <button class="video-play-btn"></button>
  </a>
</div>

<style type="text/css">
  .video-play-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #444545;
    position: absolute;
    bottom: 5%;
    right: 5%;
    background-image: url('/images/icon.png');
    background-position: right;
    background-repeat: no-repeat;
    background-position: left -659px top 10px;
    cursor: pointer;
    border: none;
  }
</style>
