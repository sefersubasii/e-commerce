import Loader from "./loader";

class AddressEdit {
    constructor() {
        this.getAddressUrl = baseUrl + '/getAddress';
        this.saveAddressUrl = baseUrl + '/saveAddress';
        this.loader = new Loader('.odeme_alan_bilgi');
        this.content = $('#addressEdit');
        this.checkoutContent = $('#checkout-content');

        $(document).on("change", 'input.billing-type', function () {
            if ($(this).val() == 1) {
                $('input[name=name]').attr('placeholder', 'Ad');
                $("#corporateArea").find('input').removeClass("billingRequired");
                $("#corporateArea").slideUp();

                $('input[name=surname]').show().addClass('billingRequired');
                if ($('input[name=surname]').next().attr('class') == "error") {
                    $('input[name=surname]').next().show();
                }
            } else {
                $('input[name=name]').attr('placeholder', 'Ticari Ünvanı');
                $("#corporateArea").slideDown().find('input').addClass("billingRequired").val('');

                $('input[name=surname]').slideUp().removeClass('billingRequired').val('');
                if ($('input[name=surname]').next().attr('class') == "error") {
                    $('input[name=surname]').next().slideUp();
                }
            }
        });

        $(document).on('change', 'select[name=city]', function () {
            var id = $('option:selected', this).attr('data-val');
            if (!id || id === "" || id === "Şehir Seçin") {
                return $("select[name=state]").html("<option>İlçe Seçin</option>");
            }

            $.post('getDistricts', {
                id: id,
                _token: $('meta[name=_token]').attr("content")
            }).done(function (response) {
                $("select[name=state]").empty();
                $.each(response, function (i, el) {
                    $("select[name=state]").append("<option value='" + el.name + "'>" + el.name + "</option>");
                });
            });
        });
    }

    show(id, type) {
        this.getAddress(`${type}Id=${id}`);
    }

    getAddress(data){
        this.loader.toggle();
        
        $.get(this.getAddressUrl, data)
            .done((response) => {
                this.loader.toggle();
                this.checkoutContent.hide();
                this.content.html(response.view).slideDown();
                $('input[name=phone], .phoneMask').mask("+90 (zdd) ddd dd dd");
                this.setPositionTop();
            });
    }

    save(){
        let data = this.content.find(':input').serialize();
        this.loader.toggle();

        $.post(baseUrl + '/saveAddress', data)
            .done((response) => {
                this.loader.toggle();

                if (response.hasOwnProperty('view')) {
                    this.checkoutContent.hide();
                    this.content.html(response.view).slideDown();
                    $('input[name=phone], .phoneMask').mask("+90 (zdd) ddd dd dd");
                    this.setPositionTop();
                } else {
                    this.close();
                    this.reloadData(response);
    
                    Toast.fire(response.message, "", response.type);
                }
            });
    }

    close() {
        this.content.slideUp().delay(300).empty();
        this.checkoutContent.show();
    }

    reloadData(response) {
        let refreshSelectBox = function (element, response, type) {
            let el = $(element);

            el.empty();
            response[type].forEach((item) => {
                el.append('<option value="' + item.id + '">' + item.address_name + '</option>');
            });
            el.change();
        };

        if (response.hasOwnProperty('shippingAddresses')) {
            refreshSelectBox('select#shippingAddress', response, 'shippingAddresses');
        }

        if (response.hasOwnProperty('billingAddresses')) {
            refreshSelectBox('select#billingAddress', response, 'billingAddresses');
        }
    }

    setPositionTop(){
        if(this.isMobile()){
            $(window).scrollTop(this.content.position().top);
        }
    }

    isMobile(){
        return (window.outerWidth < 699);
    }
}

window.AddressEdit = new AddressEdit();