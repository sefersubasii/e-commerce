$(function(){
    const CARD_TYPE = {
        VISA: {
            id: '1', 
            name: 'VISA', 
            slug: 'visa'
        },
        MASTERCARD: {
            id: '2',
            name: 'MASTERCARD',
            slug: 'mastercard'
        },
    };

    $('.card_number_mask').mask("dddd dddd dddd dddd", {
        placeholder: '_ ',
    });

    $.getCardType = function (number) {
        if (number.match(new RegExp("^4")) != null) return CARD_TYPE.VISA;
        if (number.match(new RegExp("^5[1-5]|^2[2-7]")) != null) return CARD_TYPE.MASTERCARD;
        return CARD_TYPE.VISA; // default type 
    };

    $.setCartType = function(element){
        let number = $(element).data($.mask.dataName)();
        let cartType = $.getCardType(number);

        $('#cart_type').val(cartType.id);
        
        $('#cart_type_name .icon_cart_type')
            .removeClass()
            .addClass("icon_cart_type icon_" + cartType.slug);
    }

    $('#card_number').on('keydown blur', function(){
        $.setCartType(this);
    });

    // odaklanıldığında imleci başa götürür
    $('#card_number').on('focus', function(e) {
        $(this).selectRange(0);
    });

    $.fn.selectRange = function(start, end) {
        if(end === undefined) {
            end = start;
        }
        return this.each(function() {
            if('selectionStart' in this) {
                this.selectionStart = start;
                this.selectionEnd = end;
            } else if(this.setSelectionRange) {
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    };
});