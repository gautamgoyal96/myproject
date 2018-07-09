"use strict";$.noConflict();var $=jQuery;$(document).ready(function($){var headerHeight=$("#header").height();$('.menuBar a[href*="#"]:not([href="#"])').click(function(){if(location.pathname.replace(/^\//,'')==this.pathname.replace(/^\//,'')&&location.hostname==this.hostname){var target=$(this.hash);target=target.length?target:$('[name='+this.hash.slice(1)+']');if(target.length){$('html, body').animate({scrollTop:target.offset().top-headerHeight},1000);return false;}}});$('.navbar-nav li a').on("click",function(e){$('.navbar-nav li').removeClass('active');var $parent=$(this).parent();if(!$parent.hasClass('active')){$parent.addClass('active');}});$("#owl-example").owlCarousel({navigation:true,smartSpeed:1000,items:1,itemsDesktop:false,itemsDesktopSmall:false,itemsTablet:false,itemsMobile:false,pagination:false,loop:true,autoplay:true,autoplayTimeout:3000});new WOW().init();$(".navbar-toggle").on("click",function(){$(this).toggleClass("active");$("#header").toggleClass("headClr");});function resMenu(){if($(window).width()<1200){$('.main-menu ul li a').on("click",function(){$(".navbar-collapse").removeClass("in");$(".navbar-toggle").addClass("collapsed").removeClass("active");$("#header").removeClass("headClr");});}}
resMenu();$("#owl-deal").owlCarousel({items:4,loop:true,mouseDrag:false,nav:true,autoplay:true,autoplayTimeout:3000,dots:false,autoplayHoverPause:true,responsive:{1200:{items:4},767:{items:3},600:{items:2},200:{items:1}}});$("#owl-upcoming").owlCarousel({items:1,loop:true,mouseDrag:false,nav:true,autoplay:true,autoplayTimeout:3000,dots:false,autoplayHoverPause:true,responsive:{767:{items:1},600:{items:1},200:{items:1}}});$(document).ready(function(){$(".advertisement").owlCarousel({navigation:true,slideBy:1,loop:true,mouseDrag:false,autoplay:true,autoplayTimeout:3000,smartSpeed:1000,pagination:false,autoplayHoverPause:true,transitionStyle:"backSlide",items:1});$(".owl-prev").html('<i class="fa fa-arrow-left"></i>');$(".owl-next").html('<i class="fa fa-arrow-right"></i>');});$("#owl-popular").owlCarousel({items:2,loop:true,mouseDrag:true,nav:true,autoplay:true,autoplayTimeout:3000,dots:false,responsive:{767:{items:2},600:{items:2},200:{items:1}}});$("#owl-airindia").owlCarousel({items:1,itemsDesktop:false,itemsDesktopSmall:false,itemsTablet:false,itemsMobile:false,pagination:false,});$("#owl-airways").owlCarousel({items:1,itemsDesktop:false,itemsDesktopSmall:false,itemsTablet:false,itemsMobile:false,pagination:false,});$("#owl-airbus").owlCarousel({items:1,itemsDesktop:false,itemsDesktopSmall:false,itemsTablet:false,itemsMobile:false,pagination:false,});$("#owl-review").owlCarousel({items:1,itemsDesktop:false,itemsDesktopSmall:false,itemsTablet:false,itemsMobile:false,pagination:false,});$(".grouped_gallery").fancybox({helpers:{overlay:{locked:false}}});$('.obtn').on('click',function(event){event.preventDefault();var $div=$('<div/>'),btnOffset=$(this).offset(),xPos=event.pageX-btnOffset.left,yPos=event.pageY-btnOffset.top;$div.addClass('ripple-effect');var $ripple=$(".ripple-effect");$ripple.css("height",$(this).height());$ripple.css("width",$(this).height());$div.css({top:yPos-($ripple.height()/2),left:xPos-($ripple.width()/2),background:$(this).data("ripple-color")}).appendTo($(this));window.setTimeout(function(){$div.remove();},2000);});});var offset=300,offset_opacity=1200,scroll_top_duration=700,$back_to_top=$('.back-to-top');$(window).scroll(function(){($(this).scrollTop()>offset)?$back_to_top.addClass('cd-is-visible'):$back_to_top.removeClass('cd-is-visible cd-fade-out');if($(this).scrollTop()>offset_opacity){$back_to_top.addClass('cd-fade-out');}
$back_to_top.on('click',function(event){event.preventDefault();$('body,html').animate({scrollTop:0,},scroll_top_duration);});var scroll=$(window).scrollTop();if(scroll>=150){$("#header").addClass("fixed");}else{$("#header").removeClass("fixed");}});$(window).on("load",function(){$(".popBox").height($(".popImg").height());$(".hotel-img").height($(".hotel-side").height());$(".serviceSlider").height($(".servSide").height());$(".customerSlider").height($(".testSide").height());});$(function(){$("#slider-range").slider({range:true,min:0,max:5000,values:[0,5000],stop:function(event,ui){var start=parseInt(ui.values[0]);var end=parseInt(ui.values[1]);getPrc(start,end);},slide:function(event,ui){if(ui.values[1]==5000){$("#amount").val("$"+ui.values[0]+" - $"+ui.values[1]+'+');}else{$("#amount").val("$"+ui.values[0]+" - $"+ui.values[1]);}}});if($("#slider-range").slider("values",1)==5000){$("#amount").val("$"+$("#slider-range").slider("values",0)+" - $"+$("#slider-range").slider("values",1)+'+');}else{$("#amount").val("$"+$("#slider-range").slider("values",0)+" - $"+$("#slider-range").slider("values",1));}});$(function(){$("#distance-range").slider({range:true,min:0,max:500,values:[0,500],stop:function(event,ui){var min=parseInt(ui.values[0]);var max=parseInt(ui.values[1]);getDist(min,max);},slide:function(event,ui){$("#distance").val(ui.values[0]+" miles - "+ui.values[1]+" miles");}});$("#distance").val($("#distance-range").slider("values",0)+" miles - "+$("#distance-range").slider("values",1)+" miles");});$('.input-daterange input').each(function(){$(this).datepicker('clearDates');});$(window).load(function(){$('.flexslider').flexslider({animation:"slide",controlNav:"thumbnails"});});$('.panel-heading a').click(function(){$('.panel-heading').removeClass('actives');$(this).parents('.panel-heading').addClass('actives');$('.panel-title').removeClass('actives');$(this).parent().addClass('actives');});$('.timepicker').wickedpicker();$(".modal").each(function(index){$(this).on('show.bs.modal',function(e){var open=$(this).attr('data-easein');if(open=='shake'){$('.modal-dialog').velocity('callout.'+open);}else if(open=='pulse'){$('.modal-dialog').velocity('callout.'+open);}else if(open=='tada'){$('.modal-dialog').velocity('callout.'+open);}else if(open=='flash'){$('.modal-dialog').velocity('callout.'+open);}else if(open=='bounce'){$('.modal-dialog').velocity('callout.'+open);}else if(open=='swing'){$('.modal-dialog').velocity('callout.'+open);}else{$('.modal-dialog').velocity('transition.'+open);}});});$('.datepicker').datepicker({format:'mm/dd/yyyy',startDate:'-3d'});var count=0;function validation(event){var radio_check=document.getElementsByName('gender');var input_field=document.getElementsByClassName('text_field');var text_area=document.getElementsByTagName('textarea');if(radio_check[0].checked==false&&radio_check[1].checked==false){var y=0;}else{var y=1;}
for(var i=input_field.length;i>count;i--){if(input_field[i-1].value==''||text_area.value==''){count=count+1;}else{count=0;}}
if(count!=0||y==0){alert("*All Fields are mandatory*");event.preventDefault();}else{return true;}}
function next_step1(){document.getElementById("first").style.display="none";document.getElementById("second").style.display="block";document.getElementById("active2").style.color="red";}
function prev_step1(){document.getElementById("first").style.display="block";document.getElementById("second").style.display="none";document.getElementById("active1").style.color="red";document.getElementById("active2").style.color="gray";}
function next_step2(){document.getElementById("second").style.display="none";document.getElementById("third").style.display="block";document.getElementById("active3").style.color="red";}
function prev_step2(){document.getElementById("third").style.display="none";document.getElementById("second").style.display="block";document.getElementById("active2").style.color="red";document.getElementById("active3").style.color="gray";}