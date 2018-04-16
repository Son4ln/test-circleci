@extends('layouts.ample')

@section('content-header')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">@lang('portfolios.list.title_update')</h4>
  </div>
  <a href="{{ url('portfolios/create') }}"
  class="pull-right">
    <button type="button" class="btn btn-info btn-sm">@lang('portfolios.list.create_new')</button>
  </a>
@endsection

@section('content')
    <section class="content container-fluid">
        <!--この位置をご編集ください-->
        <!--ポートフォリオ検索-->

    <!--/.box-->

    <div class="columns32 space-between" id="portfolios-list">
        @if( $portfolios->count() > 0 )
              @include('widget.portfolios.list')
        @else
          <p class="color-5aa7af">@lang('portfolios.list.empty')</p>
        @endif
    </div>
    <!-- /.ポートフォリオ検索-->
    <!--編集終わり-->
    </section>
@endsection

@push('scripts')
  <script src="/adminlte/plugins/jquery-ui/jquery-ui_sortable.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('a.add-portfolio').click(function () {
        $('div.modal-body', '#modalWindow').html("");
        $('.modal-title', '#modalWindow').html(name != '' ? "ポートフォリオ編集" : "ポートフォリオ登録");
        $('div.modal-body', '#modalWindow').load('/portfolios/create', function (response, status, xhr) {
          if (status == "error") {
            $('div.modal-body', '#modalWindow').html(xhr.responseText);
          }
        });
      });
      $(document).on('click', '.delete-portfolio' , function(e) {
          e.preventDefault()
          if (!confirm('よろしいですか?')) {
            return;
          }
          var url = $(this).attr('href')
          $('#loading').fadeIn()
          $.ajax({
              url: url,
              type: 'DELETE',
              success: function() {
                  $('#portfolios-list').html('');
                  $('#portfolios-list').load('/portfolios/filter', {self: true});
              },
              error: function() {
                  alert('An error occur!')
              },
              complete: function() {
                $('#loading').fadeOut()
              }
          })
      })
      
      $(document).on( 'mouseenter', '.background-fff', function() {
		    $(this).find('.portfolio-control').css({'z-index':1});
  	  })
	    $(document).on( 'mouseleave', '.background-fff', function() {
		    $('.portfolio-control').css({'z-index':0});
  	  })

      //sortablePortfolios();

    })
  </script>
@endpush

@push('styles')
  <link rel="stylesheet" href="/css/style.css?v=<?= VERSION_CSS_JS ?>">
  <link rel="stylesheet" href="/css/custom.css?=<?= VERSION_CSS_JS ?>">
  <style media="screen">
    .ui-widget-content {
      border: 1px solid #bdc3c7;
      background: #e1e1e1;
      color: #222222;
      margin-top: 15px;
    }

    .ui-slider .ui-slider-handle {
      position: absolute;
      z-index: 2;
      width: 5.2em;
      height: 2.2em;
      cursor: default;
      text-align: center;
      line-height: 30px;
      color: #FFFFFF;
      font-size: 15px;
    }

    .ui-slider .ui-slider-handle .glyphicon {
      color: #FFFFFF;
      margin: 0 3px;
      font-size: 11px;
      opacity: 0.5;
    }

    .ui-corner-all {
      border-radius: 20px;
    }

    .ui-slider-horizontal {
      height: auto;
    }

    .ui-slider-horizontal .ui-slider-handle {
      top: -1.2em;
    }

    .ui-state-default,
    .ui-widget-content .ui-state-default {
      border: 1px solid #f9f9f9;
      background: #3498db;
    }

    .ui-slider-horizontal .ui-slider-handle {
      margin-left: -0.5em;
    }

    .ui-slider .ui-slider-handle {
      cursor: pointer;
    }

    .ui-slider a,
    .ui-slider a:focus {
      cursor: pointer;
      outline: none;
    }
  </style>
@endpush
