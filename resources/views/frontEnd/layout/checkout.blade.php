<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle')</title>
    @hasSection ('pageDescription')<meta name="description" content="{{ trim(View::yieldContent('pageDescription')) }}"/>@endif
    @yield('extraMeta')
    <meta name="robots" content="noindex,follow">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/all.css') }}">
    <link rel='shortcut icon' href="{{url('favicon.ico')}}" type='image/x-icon'>
    <link rel='icon' href="{{url('favicon.ico')}}" type='image/x-icon'>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-55907344-3', 'auto');
    ga('send', 'pageview');
    </script>
    {!! $settings['seo']->seo_kenshoo_global !!}
    {!! $settings['seo']->seo_global_code_ads !!}
    {!! $settings['seo']->seo_tracking_code !!}
    {!! $settings['seo']->seo_remarketing_code !!}
    {!! $settings['seo']->seo_yandex_metrika !!}
    @yield('headscript')
    <script src="//cdn.segmentify.com/4794d2c8-f558-4119-ae99-fae5e293c6a7/segmentify.js" charset="UTF-8"></script>
    {{-- <script defer async src="//marketpaketi.api.useinsider.com/ins.js?id=10003534"></script> --}}
</head>
<body data-base="{{ url('/') }}/">

    @include('frontEnd.include.sepet-header')

    {{-- <div class="container">
        <div class="container_ic">
            <p style="margin-top:10px; background: #eee; border: 2px dashed #777; padding:15px; ">
                <b>ÖNEMLİ NOT:</b>
                Güncel koşullar nedeniyle kargo firmalarındaki yoğunluk ve buna bağlı gecikmeler yaşanmaktadır. 
                Bu nedenle geçici bir süre olağan kargo süreçlerinde aksamalar olabileceğini öngörmekteyiz. 
                Kargo takibi yapılırken bu hususun dikkate alınmasını önermekteyiz.
            </p>
        </div>
    </div> --}}

    @yield('content')

    @include('frontEnd.include.sepet-footer')

    <script>var baseUrl = '{{ url('/') }}';</script>
    <script src="{{ mix('js/all.js') }}"></script>
    @yield('scripts')
</body>
</html>
