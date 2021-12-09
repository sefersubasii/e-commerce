/*global $ */
$(document).ready(function() {

  "use strict";

  $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');

  $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');

  $(".menu > ul > li").hover(
      //$(this).children("ul").stop(true, false).slideToggle(300);
        function(e) {
          e.preventDefault();
          if ($(window).width() > 959) {
            $(this).children("ul").stop(true, false).slideDown(300);
          }
        },
        function(e) {
          e.preventDefault();
          if ($(window).width() > 959) {
            $(this).children("ul").stop(true, false).slideUp(300);
          }
        }
  );

  $(".menu > ul > li").click(function() {
    if ($(window).width() <= 959) {
      $(this).children("ul").slideToggle(300);
    }
  });
  
  $( window ).resize(function() {
  	if($(document).width()>970){
		    $(".menu > ul > li").children("ul").slideUp();
	  }
	});
  

  $(".menu-mobile").click(function(e) {
    $(".menu > ul").toggleClass('show-on-mobile');
    e.preventDefault();
  });


});