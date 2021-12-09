var qualifyURL = function(pathOrURL) {
    if (!(new RegExp('^(http(s)?[:]//)','i')).test(pathOrURL)) {
    return $(document.body).data('base') + pathOrURL;
}

return pathOrURL;
};

var Cart = {
    cargo_price: 0.0,
    basket_price: 0.0,
    door_price: 0.0,
    installment_price: 0.0,
    installment_percent: 0.0,
    user_credit_price: 0.0,
    user_credit_currency: '',
    
    load : function () {
        //Cart.add();
    },
    
    quick:function (product_id, quantity) {
        $.ajax({
            type: 'POST',
            url: qualifyURL('getAddToCart'),
            data: {
                _token: $('meta[name=_token]').attr("content"),
                product_id: product_id,
                quantity: quantity
            }
        }).done(function (response) {
            $("#cartInfo").html('Sepetim ('+response.count+') - '+response.total+ ' TL');
            window.location.replace(qualifyURL('sepet'));
        });
    },
    
    add : function (product_id, quantity, element) {
        if (isNaN(parseFloat(quantity)) || parseFloat(quantity) == 0 || quantity==undefined ) {
            alert("Lütfen Stok Adedini Doğru Giriniz.");
            return 0
        }
        //console.log($(element).prev());
        if ($(element).attr('class')=='detay_sepete_ekle_buton'){
            var $element = $(element);
        }else{
            if ($(document).width()>700) {
                $(element).css('width','60px');
            }
            
            var $element = $(element).prev();
        }
        
        var $text = $element.html();
        var $child = $(element).children('i');
        
        $.ajax({
            type: 'POST',
            url: qualifyURL('getAddToCart'),
            data: {
                _token: $('meta[name=_token]').attr("content"),
                product_id: product_id,
                quantity: quantity
            },beforeSend: function() {
                //console.log(element);
                $child.removeClass('fa-shopping-cart');
                $child.addClass('fa-spinner fa-spin');
                $element.html('Ekleniyor..');
                
            }
        }).done(function (response) {
            if (response.status==200) {
                $("#cartInfo").html('Sepetim ('+response.count+') - '+response.total+ ' TL');
                if ($(element).attr('class')=='detay_sepete_ekle_buton') {
                    $element.html('Ürün Sepete Eklendi.');
                }else{
                    $element.html('Ürün Sepete <br> Eklendi.');
                }
                
                $child.removeClass();
                $child.addClass('fa fa-check');
                setTimeout(function(){
                    $element.html($text);$(element).removeAttr("style");
                    $child.removeClass('fa-check');
                    $child.addClass('fa-shopping-cart');
                }, 3000);
                
                //$("html, body").stop().animate({scrollTop:0}, 500, 'swing');
            }else{
                $element.html($text);
                $(element).removeAttr("style");
                $child.removeClass('fa-spinner fa-spin');
                $child.addClass('fa-shopping-cart');
                alert(response.message);
                
            }
            
        });
    },
    
    update : function () {
        $.ajax({
            type: 'POST',
            url: 'updateCart',
            data: $('.qtyItem').serialize()+'&_token='+$('meta[name=_token]').attr("content")
        }).done(function (response) {
            console.log(response);
            location.reload();
        });
    }
    
}

Cart.load();

function saveNewDeliveryAddress() {
    var err=0;
    $.each($(".deliveryRequired"),function (i,el) {
        var el = $(el);
        if(el.val()=="" || el.val()==0 || el.val()=="Şehir Seçin" || el.val()=="İlçe Seçin"){
            err++;
            el.addClass("err");
        }else{
            el.removeClass("err");
        }
    });
    
    if(err>0){
        return false;
    }else{
        $.ajax({
            type: 'POST',
            url: 'createDeliveryAddress',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                address_name: $("input[name=newDeliveryAddressName]").val(),
                name:$("input[name=newDeliveryName]").val(),
                surname:$("input[name=newDeliverySurname]").val(),
                phone:$("input[name=newDeliveryPhone]").val(),
                phoneGsm:$("input[name=newDeliveryPhoneGsm]").val(),
                address:$("textarea[name=newDeliveryAddress]").val(),
                //city:$("select[name=newDeliveryCity]").attr('data-val'),
                city:$('#newDeliveryCity option:selected').val(),
                state:$("select[name=newDeliveryState]").val(),
                chooseBilling:$("input[name=chooseBilling]").is(':checked') == true ? 1 : 2 ,
            }
        }).done(function (response) {
            if(response.status==200)
            {
                $("select[name=deliveryAdress] option[value='']").remove();
                $("select[name=billingAddress] option[value='']").remove();
                
                $('#newDeliveryAdd').find("input[type=text], textarea, select").val("");
                $("select[name=newDeliveryState]").html("<option>İlçe Seçin</option>");
                
                $('select[name=deliveryAdress]').append('<option value="'+response.optionId+'">'+response.option+'</option>');
                $("select[name=deliveryAdress] option[value="+response.optionId+"]").attr("selected","selected");
                
                if(response.countBilling==0){
                    $(".historyBilling").html("");
                    $(".historyBilling").hide();
                    $("select[name=billingAddress]").html('<option value="">Kayıtlı Adres Bulunmuyor.</option>');
                }
                
                if(response.same==true){
                    $(".historyBilling").show();
                    $('select[name=billingAddress]').append('<option value="'+response.addBillingId+'">'+response.option+'</option>');
                    $("select[name=billingAddress] option[value="+response.addBillingId+"]").attr("selected","selected");
                    changeBillingAddress();
                }
                
                $(".historyDelivery").show();
                $('#newDeliveryAdd').slideUp();
                $('.adres_bilgi_alan').slideDown();
                
                changeDeliveryAddress();
                
            }
        });
        
    }
}

function changeDeliveryAddress() {
    var id = $("select[name=deliveryAdress]").val();
    if(id!="" && id!="Şehir Seçin" && $.isNumeric(id) ) {
        $.ajax({
            type: 'POST',
            url: 'changeDeliveryAddress',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                id: id
            }
        }).done(function (response) {
            if(response!=""){
                $(".historyDelivery").html('<strong class="adres_baslik">Teslimat Adresi</strong><span><i class="fa fa-user" aria-hidden="true"></i> '+response.name+' '+response.surname+'<br><i class="fa fa-phone" aria-hidden="true"></i> '+response.phone+' <br><i class="fa fa-map-marker" aria-hidden="true"></i> ' +response.address+' <br> '+response.city+' / '+response.state+'</span><div class="address-edit" onclick="AddressEdit.show(\''+response.id+'\', \'shipping\')"><i class="fa fa-pencil"></i> Düzenle</div>');
                //$("#currentBilling").html('<i class="fa fa-user" aria-hidden="true"></i> '+response.name+' '+response.surname+'<br><i class="fa fa-phone" aria-hidden="true"></i> '+response.phone+' - '+response.phoneGsm+' <br><i class="fa fa-map-marker" aria-hidden="true"></i> ' +response.address+' <br> '+response.city+' / '+response.state+' ');
                $(".adres_bilgi_alan").show();
            }
        });
    }else{
        $(".adres_bilgi_alan").slideUp();
    }
}


function saveNewBillingAddress() {
    var err=0;
    $.each($(".billingRequired"),function (i,el) {
        var el = $(el);
        if(el.val()=="" || el.val()==0 || el.val()=="Şehir Seçin" || el.val()=="İlçe Seçin"){
            err++;
            el.addClass("err");
        }else{
            el.removeClass("err");
        }
    });
    
    if(err>0){
        return false;
    }else{
        $.ajax({
            type: 'POST',
            url: 'createBillingAddress',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                address_name: $("input[name=newBillingAddressName]").val(),
                name:$("input[name=newBillingName]").val(),
                surname:$("input[name=newBillingSurname]").val(),
                phone:$("input[name=newBillingPhone]").val(),
                phoneGsm:$("input[name=newBillingPhoneGsm]").val(),
                address:$("textarea[name=newBillingAddress]").val(),
                city:$('#newBillingCity option:selected').val(),
                state:$("select[name=newBillingState]").val(),
                billingType:$("input[name=billingType]:checked").val(),
                companyName:$("input[name=newBillingCompanyName]").val(),
                taxOffice:$("input[name=newBillingTaxOffice]").val(),
                taxNo:$("input[name=newBillingTaxNo]").val()
            }
        }).done(function (response) {
            if(response.status==200)
            {
                $("select[name=deliveryAdress] option[value='']").remove();
                $("select[name=billingAddress] option[value='']").remove();
                
                $('#newDeliveryAdd').find("input[type=text], textarea, select").val("");
                $("select[name=newDeliveryState]").html("<option>İlçe Seçin</option>");
                
                if(response.countDelivery==0){
                    $(".historyDelivery").html("");
                    $(".historyDelivery").hide();
                    $("select[name=deliveryAdress]").html('<option value="">Kayıtlı Adres Bulunmuyor.</option>');
                }
                
                $(".historyBilling").show();
                $('#newBillingAdd').slideUp();
                $('.adres_bilgi_alan').slideDown();
                
                //$('select[name=deliveryAdress]').append('<option value="'+response.optionId+'">'+response.option+'</option>');
                //$("select[name=deliveryAdress] option[value="+response.optionId+"]").attr("selected","selected");
                
                $('select[name=billingAddress]').append('<option value="'+response.optionId+'">'+response.option+'</option>');
                $("select[name=billingAddress] option[value="+response.optionId+"]").attr("selected","selected");
                changeBillingAddress();
            }
        });
        
    }
}

function changeBillingAddress() {
    var id = $("select[name=billingAddress]").val();
    if(id!="" && id!="Şehir Seçin" && $.isNumeric(id) ) {
        $.ajax({
            type: 'POST',
            url: 'changeBillingAddress',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                id: id
            }
        }).done(function (response) {
            if(response!=""){
                $(".historyBilling").html('<strong class="adres_baslik">Fatura Adresi</strong><span><i class="fa fa-user" aria-hidden="true"></i> '+response.name+' '+response.surname+'<br><i class="fa fa-phone" aria-hidden="true"></i> '+response.phone+' <br><i class="fa fa-map-marker" aria-hidden="true"></i> ' +response.address+' <br> '+response.city+' / '+response.state+'</span><div class="address-edit" onclick="AddressEdit.show(\''+response.id+'\', \'billing\')"><i class="fa fa-pencil"></i> Düzenle</div>');
                $(".adres_bilgi_alan").show();
            }
        });
    }else{
        $(".adres_bilgi_alan").slideUp();
    }
}

function changeCity() {
    var id = $("select[name=newDeliveryCity] option:selected").attr('data-val');
    if(id!="" && id!="Şehir Seçin") {
        $.ajax({
            type: 'POST',
            url: 'getDistricts',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                id: id
            }
        }).done(function (response) {
            $("select[name=newDeliveryState]").html("");
            $.each(response,function (i,el) {
                $("select[name=newDeliveryState]").append("<option value='"+el.name+"'>"+el.name+"</option>");
            })
        });
    }else{
        $("select[name=newDeliveryState]").html("<option>İlçe Seçin</option>");
    }
}

function changeCity2() {
    var id = $("select[name=newBillingCity] option:selected").attr('data-val');
    if(id!="" && id!="Şehir Seçin") {
        $.ajax({
            type: 'POST',
            url: 'getDistricts',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                id: id
            }
        }).done(function (response) {
            $("select[name=newBillingState]").html("");
            $.each(response,function (i,el) {
                $("select[name=newBillingState]").append("<option value='"+el.name+"'>"+el.name+"</option>");
            })
        });
    }else{
        $("select[name=newBillingState]").html("<option>İlçe Seçin</option>");
    }
}

function changeShipping() {
    
    var shipping = $("select[name=shipping]").val();
    
    if(shipping!="" && shipping!="Firma Seçiniz"){
        $.ajax({
            type: 'POST',
            url: 'getCartShipping',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                shipping: shipping
            }
        }).done(function (response) {
            console.log(response);
            $(".kargo_saat_sec").html("");
            $("#freeShipText").html("");
            if(response!=false){
                $("#shippingPrice").val(response.ttl+" TL");
                $("#shippingPriceRight").html(response.ttl+" TL");
                $(".sepet_ozet_tutar").html(response.cartTtl+" TL");
                if(response.slot!=0){
                    $.each(response.slot,function (i,el) {
                        $(".kargo_saat_sec").append('<label><input value="'+el.id+'" name="shippingSlot" type="radio" class="kargo_saat_radio"><span>'+el.time1.slice(0,-3)+' - '+el.time2.slice(0,-3)+'</span></label>');
                    });
                }
                if(response.freeShipping!=""){
                    $("#freeShipText").html("<strong> ! </strong>"+response.freeShipping);
                }
                
            }
        });
    }else{
        $(".kargo_saat_sec").html("");
        $("#shippingPrice").val("0,00 TL");
        $("#freeShipText").html("");
    }
    
}

function stockNotification()
{
    var err=0;
    $("#stockNotification").find('.req').each(function () {
        $this = $(this);
        if($this.val()==""){
            err++;
            $this.addClass("err");
        }else{
            $this.removeClass("err");
        }
    });
    if (err>0){
        return false;
    }else{
        
        $.ajax({
            type: 'POST',
            url: 'stockNotification',
            data: $('#stockNotification').serialize()+"&_token="+$('meta[name=_token]').attr("content")
        }).done(function (response) {
            if($.isEmptyObject(response.error)){
                document.getElementById("stockNotification").reset();
                alert(response.success);
            }else{
                printErrorMsg(response.error);
            }
        });
    }
}


function reviewSubmit()
{
    var err=0;
    
    $("#reviewForm").find('.req').each(function () {
        $this = $(this);
        if($this.val()==""){
            err++;
            $this.addClass("err");
        }else{
            $this.removeClass("err");
        }
    });
    if (err>0){
        return false;
    }else{
        
        $.ajax({
            type: 'POST',
            url: 'postReview',
            data: $('#reviewForm').serialize()+"&_token="+$('meta[name=_token]').attr("content")
        }).done(function (response) {
            if($.isEmptyObject(response.error)){
                document.getElementById("reviewForm").reset();
                alert(response.success);
            }else{
                printErrorMsg(response.error);
            }
        });
    }
    
}

function suggestionSubmit()
{
    var err=0;
    
    $("#suggestionForm").find('.req').each(function () {
        $this = $(this);
        if($this.val()==""){
            err++;
            $this.addClass("err");
        }else{
            $this.removeClass("err");
        }
    });
    if (err>0){
        return false;
    }else{
        
        $.ajax({
            type: 'POST',
            url: 'postSuggestion',
            data: $('#suggestionForm').serialize()+"&_token="+$('meta[name=_token]').attr("content")
        }).done(function (response) {
            if($.isEmptyObject(response.error)){
                document.getElementById("suggestionForm").reset();
                alert(response.success);
            }else{
                alert(response.error);
            }
        });
    }
    
}

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');
    if (urlparts.length>=2) {
        
        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);
        
        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }
        
        url= urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

function removePrice()
{
    var currentUrl   =  window.location.href;
    newUrl = removeURLParameter(currentUrl,"fiyat");
    newUrl = removeURLParameter(newUrl,"page");
    window.location.replace(newUrl);
}

function nextInput(elementID) {
    var element = document.getElementById(elementID).value;
    
    if (elementID.length == 5) {
        var index = elementID.substr(4);
        var index2 = elementID.substr(0, 4);
        if (elementID != "card4") {
            if (element.length == 4) {
                index = parseInt(index) + 1;
                var focused = index2 + index;
                document.getElementById(focused).focus();
                focusedInputId = index2 + index
            }
        }
    }
}

function controlNumber(e) {
    var keynum;
    var keychar;
    var numcheck;
    if (window.event) {
        keynum = e.keyCode
    } else {
        if (e.which) {
            keynum = e.which
        }
    }
    if ((Number(keynum) <= 123 && Number(keynum) >= 112) || Number(keynum) == 13 || Number(keynum) == 9 || Number(keynum) == 8) {
        return true
    }
    if ((Number(keynum) >= 48 && Number(keynum) <= 57) || Number(keynum) == 190 || (Number(keynum) >= 96 && Number(keynum) <= 105)) {
        return true
    }
    return false
}

function couponCode(){
    
    var codeInput = $('input[name=couponCode]');
    var code = codeInput.val();
    if(code == '') {
        alert('Lütfen kod alanını boş bırakmayınız. ');
        codeInput.focus();
        return false;
    }else{
        $.ajax({
            type: 'POST',
            url: 'sepet/useCode',
            data: 'code='+code+"&_token="+$('meta[name=_token]').attr("content")
        }).done(function (response) {
            console.log(response);
            if (response.status==200) {
                
                location.reload();
                
            }else{
                alert(response.message);
            }
        });
    }
    
}

$(document).ready(function () {
    
    $(".ot_link").on("click",function(){
        $this=$(this);
        if ($this.attr('data-opt')=="ko") {
            var val = $("select[name=pdo] option:selected").val();
            $(".pDefault").hide();
            $("."+val).show();
        }else{
            $(".pdCash, .pdCard").hide();
            $(".pDefault").show();
        }
    });
    
    $("select[name=pdo]").on("change",function(){
        var val=$("option:selected", this).val();
        $(".pDefault").hide();
        $(".pdCash, .pdCard").hide();
        $("."+val).show();
    });
    
    $('#qty, .qtyItem').keyup(function(){
        var amountElement = $(this);
        amountElement.val(amountElement.val().replace(',', '.'));
        var quantity = parseFloat(amountElement.val());
        if(quantity == 0) {
            return;
        }
        var stockAmount = parseInt($(this).attr('data-available'));
        
        if(quantity > stockAmount) {
            amountElement.val(stockAmount);
        } else {
            if((quantity * 10) < 0.01 && quantity != 0 ) {
                quantity = 0.001;
                amountElement.val(quantity);
            }
        }
    });
    
    /** cart events **/
    $('.fancybox').fancybox();
    
    
    $("input[name=billingType]").on("change",function () {
        if($(this).val()==1){
            $("#corporateArea").slideUp();
            $('input[name=newBillingSurname]').show();
            $('input[name=newBillingSurname]').next().attr('class')=="error" ? $('input[name=newBillingSurname]').next().show() : '' ;
            $('input[name=newBillingSurname]').addClass('billingRequired');
            $('input[name=newBillingName]').attr('placeholder','Ad');
            $("#corporateArea").find('input').removeClass("billingRequired");
        }else{
            $("#corporateArea").slideDown();
            $('input[name=newBillingSurname]').hide();
            $('input[name=newBillingSurname]').next().attr('class')=="error" ? $('input[name=newBillingSurname]').next().hide() : '' ;
            $('input[name=newBillingSurname]').removeClass('billingRequired');
            $('input[name=newBillingName]').attr('placeholder','Ticari Ünvanı');
            $("#corporateArea").find('input').addClass("billingRequired");
        }
    });
    
    $(".guestSame").on("change",function () {
        if($(this).is(':checked')){
            $('input[name=sameInfo]').val(1);
            $("#newBillingAdd").slideUp();
        }else{
            $('input[name=sameInfo]').val(2);
            $("#newBillingAdd").slideDown();
        }
    });
    
    
    $('.tggl1').on('click',function () {
        
        var scroll=0;
        if ($('.adres_bilgi_alan').css('display') == 'block') {
            var scroll=1;
        }
        
        if($('#newBillingAdd:visible').length == 0)
        {
            $('#newDeliveryAdd').slideToggle();
            $('.adres_bilgi_alan').slideToggle();
            $('#newBillingAdd').hide();
        }else{
            scroll=1;
            $('#newDeliveryAdd').show();
            $('#newBillingAdd').hide();
        }
        
        if (scroll==1) {
            $('html, body').animate({
                scrollTop: $("#newDeliveryAdd").offset().top
            }, 300);
        }
        
    });
    
    $('.tggl2').on('click',function () {
        
        var scroll=0;
        if ($('.adres_bilgi_alan').css('display') == 'block') {
            var scroll=1;
        }
        
        if($('#newDeliveryAdd:visible').length == 0)
        {
            $('#newBillingAdd').slideToggle();
            $('.adres_bilgi_alan').slideToggle();
            $('#newDeliveryAdd').hide();
        }else{
            scroll=1;
            $('#newDeliveryAdd').hide();
            $('#newBillingAdd').show();
        }
        
        if (scroll==1) {
            $('html, body').animate({
                scrollTop: $("#newBillingAdd").offset().top
            }, 300);
        }
        
    });
    
    $('.nextAction').on("click",function (e) {
        e.preventDefault();
        var count = $('input[name=shippingSlot]').length;
        if (count>0 && $('input[name=shippingSlot]:checked').length<1) {
            alert('Teslimat saati seçmediniz.');
            return false;
        }
        
        $('#checkout').submit();
        
    });
    
    
    $(".filterBrand").on("change",function () {
        
        $this = $(this);
        
        var currentUrl   =  window.location.href;
        var currentQuery = url('query',currentUrl);
        
        if (currentQuery!="" && currentQuery!=undefined) {
            currentQuery = "?"+currentQuery;
        }else{
            currentQuery="";
        }
        
        if (url('2', currentUrl)){
            var brandFilter  =  url('1', currentUrl);
            $brandFiltrerArr = brandFilter.split("-");
        }else{
            $brandFiltrerArr  = [];
        }
        
        switch ($this.attr('data-filter')){
            case 'brand':
            if(this.checked){
                if(jQuery.inArray($this.val(),$brandFiltrerArr) == -1){
                    $brandFiltrerArr.push($this.val());
                };
            }else{
                $brandFiltrerArr = jQuery.grep($brandFiltrerArr, function(value) {
                    return value != $this.val();
                });
            }
            break;
        }
        
        var urlBrand = ($brandFiltrerArr.join("-")) ? $brandFiltrerArr.join("-")+"/" : "";
        var respUrl='http://'+url('hostname', currentUrl)+'/'+urlBrand+url('-1', currentUrl)+currentQuery;
        respUrl=removeURLParameter(respUrl,"page");
        //console.log(currentQuery);
        window.location.replace(respUrl);
        
        
    });
    
    $('.filterPrice').on('change', function (e) {
        
        e.preventDefault();
        $this = $(this);
        
        var currentUrl   =  window.location.href;
        var priceFilter  =  $this.val();
        
        newUrl = updateQueryStringParameter(currentUrl,"fiyat",priceFilter);
        newUrl = removeURLParameter(newUrl,"page");
        window.location.replace(newUrl);
        
        
    });
    
    $('.filterOpt').on('change',function (e) {
        
        e.preventDefault();
        $this = $(this);
        
        var currentUrl   =  window.location.href;
        
        var query = url('?filtreler',currentUrl);
        
        console.log(query);
        
        if(query!=undefined){
            $filtrerArr = query.split(",");
        }else{
            $filtrerArr  = [];
        }
        
        if(this.checked){
            if(jQuery.inArray($this.val(),$filtrerArr) == -1){
                $filtrerArr.push($this.val());
            }
        }else{
            $filtrerArr = jQuery.grep($filtrerArr, function(value) {
                return value != $this.val();
            });
        }
        
        var urlFilter = ($filtrerArr.join(",")) ? $filtrerArr.join(",") : "";
        
        console.log(urlFilter);
        
        if(urlFilter==""){
            newUrl = removeURLParameter(currentUrl,"filtreler");
            newUrl = removeURLParameter(newUrl,"page");
        }else{
            newUrl = updateQueryStringParameter(currentUrl,"filtreler",urlFilter);
            newUrl = removeURLParameter(newUrl,"page");
        }
        
        window.location.replace(newUrl);
        
    });
    
    $('select[name=siralama]').on('change',function (e) {
        
        e.preventDefault();
        $this = $(this);
        
        var selected = $("option:selected", this);
        var currentUrl   =  window.location.href;
        var query = url('?siralama',currentUrl);
        
        console.log(selected.val());
        
        if (selected.val()=="") {
            newUrl = removeURLParameter(currentUrl,"siralama");
        }else{
            
            newUrl = updateQueryStringParameter(currentUrl,"siralama",selected.val());
            
        }
        
        newUrl = removeURLParameter(newUrl,"page");
        window.location.replace(newUrl);
        
    });
    
    //$('input[name=phone]').mask("(999) 999 99 99");
    $.mask.definitions[9] = "";
    $.mask.definitions.d = "[0-9]";
    $.mask.definitions.z = "[1-9]";
    $('input[name=phone]').mask("+90 (zdd) ddd dd dd");
    $('.phoneMask').mask("+90 (zdd) ddd dd dd");
    
    $('#signInFormBtn').on("click",function (e) {
        e.preventDefault();
        $("#signInForm").submit();
    });
    
    
    $('#signUpBtn').on("click",function (e) {
        e.preventDefault();
        var err=0;
        
        $("#signUpFrom").find('input[type=text]').each(function () {
            $this = $(this);
            if($this.val()==""){
                err++;
                $this.addClass("err");
            }else{
                $this.removeClass("err");
            }
            
        });
        if (err>0){
            return false;
        }else{
            $('#signUpFrom').submit();
        }
    });
    
    $('#sources').on('change',function () {
        var url = $(this).attr("href");
        window.location = url;
    });
    
    //sipariş onayla
    var ajaxRunning = false;
    $('.approveOrder').on('click',function (e) {
        
        e.preventDefault();
        if(ajaxRunning) return false;
        
        var $btn = $(this);
        var $child = $(this).children('i');
        
        if($('#on_bilgilendirme:checked').length>0 && $('#mesafeli_satis:checked').length>0) {
            
            var po = $('.ot_link.active').attr('data-opt');
            var optional={};
            var err=0;
            
            switch (po){
                case 'havale':
                optional="bank_id="+$(".havale_radio:checked").val();
                if(optional=="" || optional==undefined || $(".havale_radio:checked").val()==undefined ){
                    return Toast.fire({
                        icon: 'error',
                        title: 'Banka Seçimi Yapmadınız!'
                    });
                }
                break;
                
                case 'kk':
                    err = 0;
                    $('.cardRequired').each(function(){
                        let $this = $(this);

                        if($this.val() !== ''){
                            return $this.removeClass("err");
                        }

                        err++;
                        $this.addClass("err");
                    });

                    if(err > 0){
                        Toast.fire({
                            icon: 'error',
                            title: 'Lütfen önce Kredi Kartı bilgilerinizi girin!'
                        });
                    }
                break;
                
                case 'ko':
                    optional=$('select[name=pdo]').val();
                    if (optional=="" || optional==undefined) {
                        return Toast.fire({
                            icon: 'error',
                            title: 'Kapıda ödeme seçeneği geçersiz.'
                        });
                    }else{
                        optional="pdo="+optional;
                    }
                break;
                
                default:
                    return false;
                break;
            }
            
            if (err>0) {
                return false;
            }else{
                $.ajax({
                    type: 'POST',
                    url: 'approveOrder',
                    data: $('.odeme_kart_alan :input').serialize()+
                    "&_token="+$('meta[name=_token]').attr("content")+
                    "&po="+po+
                    "&"+optional,
                    beforeSend: function() {
                        ajaxRunning = true;
                        $('.approveOrder').attr('href','javascript:void(0)');
                        $('.approveOrder').html('<i class="fa fa-money" aria-hidden="true"></i> Lütfen bekleyin..');
                    }
                }).done(function (response) {
                    if (response.status==200) {
                        if (response.po=="havale" || response.po=="ko") {
                            window.location = "tesekkurler";
                        }else if(response.po=="kk"){
                            $(".formHDD").html(response.form);
                            $("#webpos_form").submit();
                        }
                    }else if(response.hasOwnProperty('message')){
                        alert(response.message);
                        
                        window.location.replace(qualifyURL('sepet'));
                    }else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'İşlemler sırasında bir hata oluştu! Lütfen daha sonra tekrar deneyin veya bizimle iletişime geçin!',
                        });
                    }
                });
                
                $(document).ajaxComplete(function(){
                    ajaxRunning = false;
                });
                
                $('.approveOrder').attr('href','#');
                $('.approveOrder').html('<i class="fa fa-money" aria-hidden="true"></i> Siparişi Onayla');
            }
            
        }else{        
            $('.live_error').attr('style','margin-top:10px;margin-bottom:5px;display:block;color: #ed1d24;font-size: 13px;font-weight: 700;text-align:center;background: #f9f9f9;padding: 10px;border-radius:5px');
            $('.live_error').text('Alışverişinizi tamamlamak için Mesafeli Satış Sözleşmesini ve Ön Bilgilendirme Formunu kabul etmeniz gerekir.');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Alışverişinizi tamamlamak için Mesafeli Satış Sözleşmesini ve Ön Bilgilendirme Formunu kabul etmeniz gerekir.',
            });
        }
        
    });
    
});


$(document).ready(function(){
    $("#order-track-input").click(function(){
        $("#inputopen").addClass('tracking-active');
    });
    $(".tracking-close").click(function(){
        $(".tracking-modal").removeClass('tracking-active');
    });
    
    // Get value on button click and show alert
    $("#submit-trackorder").click(function(){
        var orderno = $("#ordernoget").val();
        $.ajax({
            type: 'POST',
            url: 'ordertracking',
            data: {
                _token: $('meta[name=_token]').attr("content"),
                orderno : $("#ordernoget").val(),
            }
        }).done(function(response) {
            $("#inputopen").removeClass('tracking-active');
            $("#open-ordertrack").addClass('tracking-active');
            $('.trackingview-class').html(response);
        });
    });
});

/*Cookie Privacy*/
$(document).ready(function () {
    if (getCookie('privacy') == 'true') {
        $('#cookiePrivacyArea').remove();
        renderGoogleBadge();
    }else{
        $('#cookiePrivacyArea').css('display','block');
    }
    
    $('#cookiePrivacyBtn').on('click',function () {
        setCookie('privacy', true, (365 * 24 * 60));
        $('#cookiePrivacyArea').remove();
        renderGoogleBadge();
    });
});

function renderGoogleBadge() {
    if(window.hasOwnProperty('renderBadge')){
        if(window.hasOwnProperty('gapi') && window.gapi.hasOwnProperty('load')){
            window.renderBadge();
        }else {
            setTimeout(function(){
                window.renderBadge();
            }, 1000);
        }
    }
}

function setCookie(cname, cvalue, exminutes) {
    var d = new Date();
    d.setTime(d.getTime() + (exminutes * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

var startKargoTimer = function (time) {
    if(!time) return false;
    
    var cdContent = '';
    $('.kargo_sure').countdown(time, function(event) {
        if (event.strftime('%-H') > 1 && event.strftime('%-M') > 1 ){
            cdContent = '<strong>'+event.strftime('%-H saat %-M dakika %-S saniye')+'</strong> içinde sipariş verirseniz <strong>bugün</strong> kargoda.';
        }
        
        $(this).html(cdContent);
    });
};

$(function(){
    $('img.lazy').each((key, item) => {
        $(item).attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
    });
    $('#tua1 img').each((key, item) => {
        $(item).attr('data-src', $(item).attr('src'));
        $(item).attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==')
            .addClass('lazy');
    });
});

$(function(){
    // $('.detay_buyutec').zoom();
    
    $("#share").jsSocials({
        showLabel: false,
        showCount: false,
        shareIn: "popup",
        shares: ["whatsapp","twitter", "facebook", "googleplus", "linkedin", "pinterest"]
    });
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$(function(){
    $(document).on('keypress', '.entryDecimal', function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        var seperator = ',';
        if (seperator == '.' && charCode == 46) return true;
        if (seperator == ',' && charCode == 44) return true;
        if ([37, 38, 39, 40].indexOf(charCode) > -1) return true;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });

    $(document).on('keypress', '.entryInt', function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode == 44 || charCode == 46) return false;
        if ([37, 38, 39, 40].indexOf(charCode) > -1) return true;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });
});

window.renderBadge = function() {
    var ratingBadgeContainer = document.createElement("div");
    document.body.appendChild(ratingBadgeContainer);

    if(Object(window).hasOwnProperty('gapi') && Object(window.gapi).hasOwnProperty('load')){
        window.gapi.load('ratingbadge', function() {
            window.gapi.ratingbadge.render(ratingBadgeContainer, {
                "merchant_id": 210590127
            });
        });
    }
}