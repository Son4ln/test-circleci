$(document).ready(function(){"use strict";var e=$("body");$(function(){$(".preloader").fadeOut(),$("#side-menu").metisMenu()}),$(".open-close").on("click",function(){e.toggleClass("show-sidebar").toggleClass("hide-sidebar"),$(".sidebar-head .open-close i").toggleClass("ti-menu")}),$(".right-side-toggle").on("click",function(){$(".right-sidebar").slideDown(50).toggleClass("shw-rside"),$(".fxhdr").on("click",function(){e.toggleClass("fix-header")}),$(".fxsdr").on("click",function(){e.toggleClass("fix-sidebar")});var i=$(".fxhdr");e.hasClass("fix-header")?i.attr("checked",!0):i.attr("checked",!1)}),$(function(){var i=function(){var i=60,l=window.innerWidth>0?window.innerWidth:this.screen.width,s=(window.innerHeight>0?window.innerHeight:this.screen.height)-1;768>l?($("div.navbar-collapse").addClass("collapse"),i=100):$("div.navbar-collapse").removeClass("collapse"),1170>l?(e.addClass("content-wrapper"),$(".sidebar-nav, .slimScrollDiv").css("overflow-x","visible").parent().css("overflow","visible")):e.removeClass("content-wrapper"),s-=i,1>s&&(s=1),s>i&&$("#page-wrapper").css("min-height",s+"px")},url=window.location.href.replace(/#[^#]*$/,"").replace(/\?[^\?]*$/,"").replace(/^https:/,"http:"),element=$('ul.nav a').filter(function(){var href=this.href.replace(/#[^#]*$/,"").replace(/\?[^\?]*$/,"").replace(/^https:/,"http:");return url===href}).addClass('active').parent().parent().addClass('in').parent();if(element.is('li')){element.addClass('active')}
$(window).ready(i);$(window).bind("resize",i)}),function(e,i,l){var s='[data-perform="panel-collapse"]',n='[data-perform="panel-dismiss"]';e(s).each(function(){var i={toggle:!1},l=e(this).closest(".panel"),s=l.find(".panel-wrapper"),n=e(this).children("i");s.length||(s=l.children(".panel-heading").nextAll().wrapAll("<div/>").parent().addClass("panel-wrapper"),i={}),s.collapse(i).on("hide.bs.collapse",function(){n.removeClass("ti-minus").addClass("ti-plus")}).on("show.bs.collapse",function(){n.removeClass("ti-plus").addClass("ti-minus")})}),e(l).on("click",s,function(i){i.preventDefault();var l=e(this).closest(".panel"),s=l.find(".panel-wrapper");s.collapse("toggle")}),e(l).on("click",n,function(i){function s(){var i=l.parent();l.remove(),i.filter(function(){return e(this).is('[class*="col-"]')&&0===e(this).children("*").length}).remove()}
i.preventDefault();var l=e(this).closest(".panel");s()})}(jQuery,window,document),$(function(){$('[data-toggle="tooltip"]').tooltip()}),$(function(){$('[data-toggle="popover"]').popover()}),$(".list-task li label").on("click",function(){$(this).toggleClass("task-done")}),$(".settings_box a").on("click",function(){$("ul.theme_color").toggleClass("theme_block")}),$(".collapseble").on("click",function(){$(".collapseblebox").fadeToggle(350)}),$(".slimscrollright").slimScroll({height:"100%",position:"right",size:"5px",color:"#dcdcdc"}),$(".slimscrollsidebar").slimScroll({height:"100%",position:"right",size:"6px",color:"rgba(0,0,0,0.3)"}),$(".chat-list").slimScroll({height:"100%",position:"right",size:"0px",color:"#dcdcdc"}),e.trigger("resize"),$(".visited li a").on("click",function(e){$(".visited li").removeClass("active");var i=$(this).parent();i.hasClass("active")||i.addClass("active"),e.preventDefault()}),$("#to-recover").on("click",function(){$("#loginform").slideUp(),$("#recoverform").fadeIn()}),$(".navbar-toggle").on("click",function(){$(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close")})});var fileDownloads={};$(document).on("click",'.ui-deliver-list .l-selected-download:not(.ui-del-delive)',function(){var _this=$(this);var id=_this.attr('data-id');var url=_this.attr('data-href');if(_this.hasClass('active')){_this.removeClass('active');delete(fileDownloads[id])}else{_this.addClass('active');fileDownloads[id]=url}});$('.download-all-file').click(function(){if(!jQuery.isEmptyObject(fileDownloads)){$('#progress_screen').show();$('#progress_text').html('Downloading... '+'<i class="fa fa-refresh fa-spin fa-fw"></i>');$('.progress').hide();$.ajax({type:"POST",url:"/creative-rooms/downloadfile",data:fileDownloads,success:function(data){data=JSON.parse(data);$('#progress_screen').hide();$('.progress').show();console.log(data);if(data.status==1){window.location.href="/creative-rooms-downloadfile?name="+data.file_name}}})}else{alert('ダウンロードファイルを選択ください。')}});function sortablePortfolios(){var temp=$('#portfolios-list').find(".flexbox1");var drag=null;$('#portfolios-list').sortable({start:function(event,ui){var index=ui.item.attr('data-index');drag=ui.item.attr('id')},change:function(event,ui){var index=ui.item.index();index=parseInt(index)+1;var element=$('#portfolios-list div:nth-child('+index+')')},update:function(event,ui){var index=ui.item.index();var drop=$(temp).find(".flexbox1");$('#portfolios-list').find('.flexbox1').each(function(_index,_element){$(_element).attr('data-index',_index+1)});temp=$('#portfolios-list').find(".flexbox1");var data={};$('#portfolios-list').find('.flexbox1').each(function(_index,_element){data[$(_element).attr('data-index')]=$(_element).attr('data-id')});$.ajax({url:'/portfoliossort',type:'POST',data:data,success:function(){},error:function(){alert('An error occur!')},complete:function(){$('#loading').fadeOut()}})},stop:function(event,ui){}})}