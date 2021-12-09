// Lazy Load
$(document).ready(function(){
	$(".lazy").Lazy({
		defaultImage: 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==' ,
		scrollDirection: 'vertical',
		effect: 'fadeIn',
		visibleOnly: true,
		onError: function(element) {
			console.log('error loading ' + element.data('src'));
		}
	});
});

/*--- Tab ---*/

$(document).ready(function() {

	$(".tua_content").hide();
	$(".tua span:first").addClass("active").show();
	$(".tua_content:first").show();

	$(".tua span").click(function() {
		$(".tua span").removeClass("active");
		$(this).addClass("active");
		$(".tua_content").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();

		$(activeTab).find('img.lazy').each(function(key, item){
			$(item).attr('src', $(item).data('src'));
		});
		return false;
	});

});

/*--- Tab ---*/


/*--- Sipariş Tab ---*/

$(document).ready(function() {

	$(".siparis_content").hide();
	$(".siparis_tab span:first").addClass("active").show();
	$(".siparis_content:first").show();

	$(".siparis_tab span").click(function() {
		$(".siparis_tab span").removeClass("active");
		$(this).addClass("active");
		$(".siparis_content").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();
		return false;
	});

});

/*--- Sipariş Tab ---*/





/*--- slider ---*/

$(document).ready(function() {

  var sync1 = $("#sync1");
  var sync2 = $("#sync2");

  sync1.owlCarousel({
    singleItem : true,
    slideSpeed : 1000,
    navigation: true,
	transitionStyle:"fade",
    pagination:false,
    afterAction : syncPosition,
    responsiveRefreshRate : 200,
	loop:true,
	autoplay:true,
	autoPlay : 5000,
	lazyLoad:true
  });

  sync2.owlCarousel({
    items : 9,
    itemsDesktop      : [1199,9],
    itemsTablet       : [959,9],
    itemsMobile       : [699,3],
    pagination:false,
    responsiveRefreshRate : 100,
	lazyLoad: true,
    afterInit : function(el){
      el.find(".owl-item").eq(0).addClass("synced");
    }
  });

  function syncPosition(el){
    var current = this.currentItem;
    $("#sync2")
      .find(".owl-item")
      .removeClass("synced")
      .eq(current)
      .addClass("synced")
    if($("#sync2").data("owlCarousel") !== undefined){
      center(current)
    }
  }

  $("#sync2").on("click", ".owl-item", function(e){
    e.preventDefault();
    var number = $(this).data("owlItem");
    sync1.trigger("owl.goTo",number);
  });

  function center(number){
    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
    var num = number;
    var found = false;
    for(var i in sync2visible){
      if(num === sync2visible[i]){
        var found = true;
      }
    }

    if(found===false){
      if(num>sync2visible[sync2visible.length-1]){
        sync2.trigger("owl.goTo", num - sync2visible.length+2)
      }else{
        if(num - 1 === -1){
          num = 0;
        }
        sync2.trigger("owl.goTo", num);
      }
    } else if(num === sync2visible[sync2visible.length-1]){
      sync2.trigger("owl.goTo", sync2visible[1])
    } else if(num === sync2visible[0]){
      sync2.trigger("owl.goTo", num-1)
    }

  }

});

/*--- slider ---*/


/*--- Mobil Slider ---*/

$(document).ready(function(){
	$(".mobil_slider").owlCarousel({
		autoPlay:3000,
		stopOnHover:true,
		navigation:false,
		paginationSpeed:1000,
		goToFirstSpeed:2000,
		singleItem:true,
		autoHeight:false,
		transitionStyle:"fade",
		loop:true,
		autoplay:true,
		lazyLoad: true
	});
});

/*--- Mobil Slider ---*/


/*--- gölge ---*/

			$(document).ready(function () {


            $(".uyelik_alan").hover(
                    function () {
                        $('.golge').addClass("golge_ac");
                    },
                    function () {
                        $('.golge').removeClass("golge_ac");
                    }
            	);
			});


			$(document).ready(function () {


            $(".menu").hover(
                    function () {
                        $('.menu_golge').addClass("menu_golge_ac");
                    },
                    function () {
                        $('.menu_golge').removeClass("menu_golge_ac");
                    }
            	);
			});

/*--- gölge ---*/




/*--- tab ---*/
$(document).ready(function() {

	$(".ana_vitrin_tab_icerik").hide();
	$(".ana_vitrin_tab strong:first").addClass("active").show();
	$(".ana_vitrin_tab_icerik:first").show();

	$(".ana_vitrin_tab strong").click(function() {
		$(".ana_vitrin_tab strong").removeClass("active");
		$(this).addClass("active");
		$(".ana_vitrin_tab_icerik").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();

		$(activeTab).find('img.lazy').each(function(key, item){
			$(item).attr('src', $(item).data('src'));
		});

		return false;
	});
});


/*--- tab ---*/


/*--- ödeme tab ---*/
$(document).ready(function() {

	$(".odeme_sec_icerik").hide();
	$(".odeme_tab strong:first").addClass("active").show();
	$(".odeme_sec_icerik:first").show();

	$(".odeme_tab strong").click(function() {
		$(".odeme_tab strong").removeClass("active");
		$(this).addClass("active");
		$(".odeme_sec_icerik").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn();
		return false;
	});

});


/*--- ödeme tab ---*/



/*--- kategori ---*/

	$(document).ready(function() {

		$(".ana_kategori").owlCarousel({

			loop:true,
			autoplay:false,
			items : 4,
			itemsDesktop : [1199,4],
			itemsTablet : [959, 2],
        	itemsMobile : [699, 1],
			lazyload: true

		});

	});

/*--- kategori ---*/



/*--- yorum ---*/

	$(document).ready(function() {

	  $(".ana_yorum").owlCarousel({
		autoPlay : 3000,
		stopOnHover : true,
		paginationSpeed : 1000,
		goToFirstSpeed : 2000,
		singleItem : true,
		autoHeight : false,
		transitionStyle:"fade",
		loop:true,
		autoplay:true,
		lazyLoad:true
	  });

	});


/*--- yorum ---*/


/*--- detay slider ---*/

$(document).ready(function() {

  var sync1 = $("#detay_slider");
  var sync2 = $("#detay_slider2");

  sync1.owlCarousel({
    singleItem : true,
    slideSpeed : 1000,
    navigation: true,
	transitionStyle:"fade",
    pagination:false,
    afterAction : syncPosition,
    responsiveRefreshRate : 200,
	loop:true,
	autoplay:true,
	lazyLoad: true
  });

  sync2.owlCarousel({
    items :4,
    itemsDesktop      : [1199,4],
    itemsTablet       : [959,4],
    itemsMobile       : [699,3],
    pagination:false,
    responsiveRefreshRate : 100,
    afterInit : function(el){
		el.find(".owl-item").eq(0).addClass("detay_slider");
	},
  	lazyLoad: true,
  });

  function syncPosition(el){
    var current = this.currentItem;
    $("#detay_slider2")
      .find(".owl-item")
      .removeClass("detay_slider")
      .eq(current)
      .addClass("detay_slider")
    if($("#detay_slider2").data("owlCarousel") !== undefined){
      center(current)
    }
  }

  $("#detay_slider2").on("click", ".owl-item", function(e){
    e.preventDefault();
    var number = $(this).data("owlItem");
    sync1.trigger("owl.goTo",number);
  });

  function center(number){
    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
    var num = number;
    var found = false;
    for(var i in sync2visible){
      if(num === sync2visible[i]){
        var found = true;
      }
    }

    if(found===false){
      if(num>sync2visible[sync2visible.length-1]){
        sync2.trigger("owl.goTo", num - sync2visible.length+2)
      }else{
        if(num - 1 === -1){
          num = 0;
        }
        sync2.trigger("owl.goTo", num);
      }
    } else if(num === sync2visible[sync2visible.length-1]){
      sync2.trigger("owl.goTo", sync2visible[1])
    } else if(num === sync2visible[0]){
      sync2.trigger("owl.goTo", num-1)
    }

  }

});

/*--- detay slider ---*/



/*--- Filtre Aç ---*/


$(function() {
		var a = 0;
		$('.filtre_ac').click(function(){
			if (a == 0 ){
					$(this).data(' <img src="images/icon.png" alt=""> ');
					a++;
				} else {
					$(this).data(' <img src="images/icon.png" alt="">');
					a = 0;
				}
				$(this).next('.urun_filtre').slideToggle(500);
		});

	});

/*--- Filtre Aç ---*/

/*--- Uye Aç ---*/


$(function() {
		var a = 0;
		$('.mobil_uye_islem').click(function(){
			if (a == 0 ){
					$(this).data(' <img src="images/icon.png" alt=""> ');
					a++;
				} else {
					$(this).data(' <img src="images/icon.png" alt="">');
					a = 0;
				}
				$(this).next('.uye_icerik').slideToggle(500);
		});

	});

/*--- Uye Aç ---*/


/**
 * Popup Manager
 */
function popupShow(popupId = null, popupTitle = null, popupContent = null, cookieTime = 5){	
	if(!popupId || !popupContent) {
		return false;
	}

	let cookieName = '_mp_popup_' + popupId;

	if(getCookie(cookieName) == 'true'){
		return false;
	}

	popupTitle = popupTitle ? '<span class="popup_title">' + popupTitle + '</span>' : '';

	$.fancybox.open('<div class="popup_content">' + popupTitle + popupContent + '</div>', {
		afterShow : function() {
			setCookie(cookieName, true, cookieTime);
		}
	});
}