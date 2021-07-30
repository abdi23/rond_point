<!-- header toolbar start -->
  <div class="header-toolbar">
    <div class="container">
      <div class="row">
        <div class="col-md-16 text-uppercase">
          <div class="row">

            <div class="col-xs-16 col-sm-8 ">
                <div id="time-date" class="pull-left tophour"></div>
            </div>

            <div class="col-sm-8 col-xs-16">
              <ul id="inline-popups" class="list-inline pull-right topnav">
                <li class="hidden-xs"><a href="#">A Propos de nous</a></li>
                <li><a  href="#">Besoin d'aide ?</a></li>
                <li><a class="open-popup-link" href="#log-in" data-effect="mfp-zoom-in">Se connecter</a></li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- header toolbar end -->


<!-- sticky header start -->
<div class="sticky-header">
  <!-- header start -->
  <div class="container header">
    <div class="row">
      {{-- Logo--}}
      <div class="col-sm-12 col-md-4 wow fadeInUpLeft animated">
        <a href="{{url('/')}}" class="navbar-brand" >
            @empty(Settings::get('logowebsite'))
                <img src="{{ asset('themes/magz/images/logo.png') }}" alt="Web Logo">
            @else
                <img src="{{ route('logo.display', Settings::get('logowebsite')) }}" alt=" Web Logo">
            @endempty
        </a>
      </div>
      {{-- Pub--}}
      <div class="col-sm-12 col-md-4 hidden-xs">
        <img src="{{asset('rondpoint/images/ads/468-60-ad.gif')}}" width="468" height="60" alt=""/>
      </div>
      {{-- Barre de recherche--}}
      <div class="col-md-4 col-sm-12 pull-right">
          @include('frontend.rondpoint.include._search-form')
      </div>

    </div>
  </div>
  <!-- header end -->
  <!-- nav and search start -->
  <div class="nav-search-outer">
    <!-- nav start -->
      @include('frontend.rondpoint.include._navbar')
    <!--nav end-->
  </div>
  <!-- nav and search end-->
</div>
<!-- sticky header end -->
