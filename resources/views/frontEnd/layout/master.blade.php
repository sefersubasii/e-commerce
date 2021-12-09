<!DOCTYPE html>
<html lang="tr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta id="Content-Language" http-equiv="Content-Language" content="tr"/>
    <meta name="_token" content="{{ csrf_token() }}">
    <title>{{ trim(View::yieldContent('pageTitle')) }}</title>
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    @hasSection ('pageDescription')<meta name="description" content="{{ trim(View::yieldContent('pageDescription')) }}"/>@endif
    @yield('extraMeta')
    
    <link rel="preconnect" href="https://resources.xg4ken.com">
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://connect.facebook.net">
    <link rel="preconnect" href="https://www.facebook.com">
    <link rel="preconnect" href="https://play.google.com">
    <link rel="preconnect" href="https://www.google.com.tr">
    <link rel="preconnect" href="https://apis.google.com">
    <link rel="preconnect" href="https://www.google-analytics.com">
    <link rel="preconnect" href="https://stats.g.doubleclick.net">
    <link rel="preconnect" href="https://www.gstatic.com">
    
    <link rel="stylesheet" href="{{ mix('css/all.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:900&display=swap&subset=latin-ext">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap&subset=latin-ext">

    {!! $settings['seo']->seo_kenshoo_global !!}
    {!! $settings['seo']->seo_global_code_ads !!}
    {!! $settings['seo']->seo_verification_code !!}
    
    @yield('canonical')
    @yield('headscript')
</head>
<body data-base="{{ url('/') }}/">
    
    {{-- Header --}}
    @include('frontEnd.include.header')
    
    {{-- Content --}}
    @yield('content')
    
    {{-- Footer --}}
    @include('frontEnd.include.footer')

    {{-- Cookie --}}
    @include('frontEnd.include.cookie')

    <script>var baseUrl = '{{ url("/") }}';</script>

    {{-- Scripts --}}
    <script src="{{ mix('js/all.js') }}"></script>

    {{-- Google Badge --}}
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    {!! $settings['seo']->seo_tracking_code !!}
    {!! $settings['seo']->seo_remarketing_code !!}
    {!! $settings['seo']->seo_yandex_metrika !!}

    @yield('scripts')
    @stack('scripts') 
    {{-- <script async src="//marketpaketi.api.useinsider.com/ins.js?id=10003534"></script> --}}
</body>
</html>
