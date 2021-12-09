/**
 * Created by emre on 12.12.2016.
 */
$(document).ready(function () {

$("input[name=doorStatus]").on("change",function () {

    if($(this).attr('id')=='openDoor'){
        $("#collapseOne").slideDown();
    }else{
        $("#collapseOne").slideUp();
    }
})

});