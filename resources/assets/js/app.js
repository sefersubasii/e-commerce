window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');
require('@fancyapps/fancybox');
require('jssocials');
require('jquery-countdown');
require('block-ui');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});