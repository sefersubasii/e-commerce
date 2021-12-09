<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php /*<meta name="viewport" content="width=device-width, initial-scale=1">*/?>
    <meta name="viewport" content="width=1266">
    <meta name="description" content="">
    <meta name="robots" content="noindex,follow">
    <meta name="author" content="">
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <?php /*<link rel="icon" type="image/png" sizes="16x16" href="{{asset('src/plugins/images/favicon.png')}}">
    <link rel='shortcut icon' href="{{url('favicon.ico')}}" type='image/x-icon'>
    <link rel='icon' href="{{url('favicon.ico')}}" type='image/x-icon'>*/ ?>
    <title>@yield('title', 'Yönetim Paneli | Market Paketi')</title>
    <link rel="stylesheet" href="{{ mix('dashboard/css/admin.css') }}">
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('src/admin/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{asset('src/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{asset('src/admin/plugins/bower_components/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <!-- sweetalert CSS -->
    <link href="{{asset('src/admin/plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <!-- switchery CSS -->
    <link href="{{asset('src/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}" rel="stylesheet">
    <!-- tagsinput CSS -->
    <link href="{{asset('src/admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <!-- token input -->
    <link href="{{asset('src/admin/plugins/bower_components/token-inputs/tokeninput.css')}}" rel="stylesheet">
    <!-- select2 css -->
    <link href="{{asset('src/admin/plugins/bower_components/select2/select2.min.css')}}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{asset('src/admin/plugins/bower_components/switchery/dist/switchery.min.css')}}" rel="stylesheet">
    <!-- dropify CSS -->

    <!-- fontAwesome CSS -->
    <link rel="stylesheet" href="{{asset('src/admin/css/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!-- bootstrap-select -->
    <link href="{{asset('src/admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{asset('src/admin/css/animate.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('src/admin/css/style.css')}}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{asset('src/admin/css/colors/blue.css')}}" id="theme"  rel="stylesheet">
    <link rel="stylesheet" href="{{asset('src/css/custom.css')}}">
    @yield('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
@include('admin.include.header')

@yield('content')

    <?php /*
    <!-- .right-sidebar -->
    <div class="right-sidebar">
        <div class="slimscrollright">
            <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
            <div class="r-panel-body">
                <ul>
                    <li><b>Layout Options</b></li>

                    <li>
                        <div class="checkbox checkbox-info">
                            <input id="checkbox1" type="checkbox" class="fxhdr">
                            <label for="checkbox1"> Fix Header </label>
                        </div>
                    </li>
                </ul>
                <ul id="themecolors" class="m-t-20">
                    <li><b>With Light sidebar</b></li>
                    <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
                    <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
                    <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
                    <li><a href="javascript:void(0)" theme="blue" class="blue-theme working">4</a></li>
                    <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
                    <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
                    <li><b>With Dark sidebar</b></li>
                    <br/>
                    <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
                    <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
                    <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>

                    <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
                    <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
                    <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
                </ul>
                <ul class="m-t-20 chatonline">
                    <li><b>Chat option</b></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/varun.jpg')}}" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/genu.jpg')}}" alt="user-img"  class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/ritesh.jpg')}}" alt="user-img"  class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/arijit.jpg')}}" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/govinda.jpg')}}" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/hritik.jpg')}}" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/john.jpg')}}" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a></li>
                    <li><a href="javascript:void(0)"><img src="{{asset('src/admin/plugins/images/users/pawandeep.jpg')}}" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.right-sidebar -->
    */  ?>
</div>
<!-- /#wrapper -->



<!-- jQuery -->
<script src="{{ mix('dashboard/js/admin.js') }}"></script>
{{-- <script src="{{asset('src/admin/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script> --}}
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('src/admin/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Menu Plugin JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
<!--slimscroll JavaScript -->
<script src="{{asset('src/admin/js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('src/admin/js/waves.js')}}"></script>
<!--Counter js -->
<script src="{{asset('src/admin/plugins/bower_components/counterup/jquery.counterup.min.js')}}"></script>
<?php /*
<!--Morris JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/raphael/raphael-min.js')}}"></script>
<script src="{{asset('src/admin/plugins/bower_components/morrisjs/morris.js')}}"></script>
*/ ?>
<!-- Custom Theme JavaScript -->
<script src="{{asset('src/admin/js/custom.min.js')}}"></script>
<script src="{{asset('src/admin/js/dashboard1.js')}}"></script>
<!-- Sparkline chart JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('src/admin/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js')}}"></script>
<script src="{{asset('src/admin/plugins/bower_components/toast-master/js/jquery.toast.js')}}"></script>
<!-- bootstrap select JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/bootstrap-select/bootstrap-select.min.js')}}"></script>
<!-- ckeditor JavaScript -->
{{-- <script src="{{asset('src/admin/plugins/bower_components/ckeditor/ckeditor.js')}}" charset="utf-8"></script> --}}
<script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script>
    // $(window).on('load', function (){
        $('textarea.editor').each(function(){
            CKEDITOR.replace(this, {
                entities_latin: false,
                // filebrowserImageBrowseUrl: '{{ url("filemanager?type=Images") }}',
                // filebrowserImageUploadUrl: '{{ url("filemanager/upload?type=Images&_token=") }}',
                filebrowserBrowseUrl: '{{ url("filemanager?type=Files") }}',
                filebrowserUploadUrl: '{{ url("filemanager/upload?type=Files&_token=") }}',
                removeDialogTabs: 'link:upload;image:Upload'
            });       
        });
    // });
</script>
<!-- select2 JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/select2/select2.min.js')}}"></script>
<script src="{{asset('src/admin/plugins/bower_components/select2/tr.js')}}"></script>
<!-- Switchery JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/switchery/dist/switchery.min.js')}}"></script>
<!-- sweetalert JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/sweetalert/sweetalert.min.js')}}"></script>
<!--token inputs -->
<script src="{{asset('src/admin/plugins/bower_components/token-inputs/tokeninput.js')}}"></script>
<!-- bootstrap tags input JavaScript -->
<script src="{{asset('src/admin/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>

    <?php

    if(Session::has("status")){  ?>
<script>
        $(document).ready(function() {
            $.toast({
                heading: '{{Session("status")[1]}}',
                text: '',
                position: 'bottom-right',
                loaderBg:'#ff0000',
                icon: '{{Session("status")[0]==0 ? "error" : "success" }}',
                hideAfter: false,
                stack: 6
            });
    });
</script>
    <?php }
    ?>
<script type="text/javascript">
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
</script>
<!--Style Switcher -->
<script src="{{asset('src/admin/plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>
<script src="{{asset('src/admin/js/ready.js')}}"></script>

<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>
<script>
  window.renderBadge = function() {
    var ratingBadgeContainer = document.createElement("div");
    document.body.appendChild(ratingBadgeContainer);
    window.gapi.load('ratingbadge', function() {
      window.gapi.ratingbadge.render(ratingBadgeContainer, {"merchant_id": 210590127});
    });
  }
</script>
@yield('scripts')
</body>
</html>
