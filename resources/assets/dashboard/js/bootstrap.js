$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('keypress', '.entryDecimal', function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        var seperator = '.';
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