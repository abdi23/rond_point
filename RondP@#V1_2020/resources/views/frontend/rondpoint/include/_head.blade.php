<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="robots" content="index, follow">
<meta name="author" content="{{ Settings::get('company_name') }}">
{!! SEO::generate() !!}

@empty(Settings::get('favicon'))
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
@else
<link rel="icon" sizes="32x32" href="{{ route('icon.display', Settings::get('favicon')) }}">
@endempty
<meta name="google-site-verification" content="{{ Settings::get('googlesiteverification') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">


<!-- bootstrap styles-->
<link href="{{ asset('rondpoint/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- google font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
<!-- ionicons font -->
<link href="{{ asset('rondpoint/css/ionicons.min.css') }}" rel="stylesheet">
<!-- animation styles -->
<link rel="stylesheet" href="{{ asset('rondpoint/css/animate.css') }}" />

<!-- owl carousel styles-->
<link rel="stylesheet" href="{{ asset('rondpoint/css/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('rondpoint/css/owl.transitions.css') }}">

<!-- magnific popup styles -->
<link rel="stylesheet" href="{{ asset('rondpoint/css/magnific-popup.css') }}">

<!-- custom styles -->
<link href="{{ asset('rondpoint/css/custom-red.css') }}" rel="stylesheet" id="style">
<link href="{{ asset('rondpoint/css/horoscop.css') }}" rel="stylesheet" id="style">
<link href="{{ asset('rondpoint/css/rondpoint.css') }}" rel="stylesheet" id="style">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->





@if(Settings::get('publisherid'))
<!-- Google Adsense -->
<script data-ad-client="{{ Settings::get('publisherid') }}" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
@endif

@if(Settings::get('googleanalyticsid'))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ Settings::get('googleanalyticsid') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ Settings::get("googleanalyticsid") }}');
</script>
@endif

<!-- Mailchimp -->
<script id="mcjs">
    ! function(c, h, i, m, p) {
        m = c.createElement(h), p = c.getElementsByTagName(h)[0], m.async = 1, m.src = i, p.parentNode.insertBefore(m, p)
    }(document, "script", "https://chimpstatic.com/mcjs-connected/js/users/dce4ca90b74e9fafbfb2697a6/b08078aa3fbf02461cb5d711e.js");
</script>

{!! NoCaptcha::renderJs() !!}
