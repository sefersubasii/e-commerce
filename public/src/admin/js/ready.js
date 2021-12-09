/**
 * Created by emre on 12.12.2016.
 */
$(document).ready(function () {

	$("#side-menu li a").dblclick(function(){
		var url = $(this).attr("href");
		if (url!="" && url !="#") {
			window.location.href = url;
		}
	});

    $("input[name=doorStatus]").on("change",function () {

        if($(this).attr('id')=='openDoor'){
            $("#collapseOne").slideDown();
        }else{
            $("#collapseOne").slideUp();
        }
    })

});