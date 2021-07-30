  @extends('frontend.rondpoint.index')



  @section('content')

  <div class="container">
      <div class="row">

          <!-- hot news start -->
          <div class="col-sm-16 hot-news hidden-xs">
              <div class="row">
                  <div class="col-sm-15">
                      <span class="ion-ios7-timer icon-news pull-left"></span>
                      <ul id="js-news" class="js-hidden">
                          @foreach (Posts::recentPosts()->limit(4)->get() as $post)
                          <li class="news-item">
                              <a href="{{ Settings::getRoutePost($post) }}">
                                  <div class="badge">
                                      {{ Posts::getCategory($post) }}
                                  </div>
                                  {!! $post->post_title !!}
                              </a>
                          </li>
                          @endforeach
                      </ul>
                  </div>
                  <div class="col-sm-1 shuffle text-right"><a href="#"><span class="ion-shuffle"></span></a></div>
              </div>
          </div>
          <!-- hot news end -->

          <!-- banner A la une et Alerte -->
          <div class="col-sm-16 banner-outer wow fadeInLeft animated" data-wow-delay="1s" data-wow-offset="50">
              <div class="row">
                <!-- banner A la une -->
                  <div class="col-sm-16 col-md-11 col-lg-11 news-caroussel">
                      <!-- carousel start -->
                      <div id="sync1" class="owl-carousel headnews">
                          {{-- A la une  - Headline news --}}
                          @foreach (Posts::recentPosts()->limit(4)->get() as $post)
                          <div class="box item headnews-item">
                              <a href="#">
                                  <div class="carousel-caption">
                                      <a href="{{ Settings::getRoutePost($post) }}">{{ $post->post_title }}</a>
                                  </div>
                                  <img class="img-responsive  headnews-img" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" alt="{{ $post->post_image }}" />
                                  <div class="overlay"></div>
                                  <div class="overlay-info">
                                      <div class="cat">
                                          <p class="cat-data"><span class="ion-model-s"></span>
                                              <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                                  {{ Posts::getCategory($post) }}
                                              </a>
                                          </p>
                                      </div>
                                      <div class="info">
                                          <p><span class="ion-android-data"></span>{{ $post->created_at->format('d/m/Y') }}<span class="ion-eye"></span>351</p>
                                      </div>
                                  </div>
                              </a>
                          </div>
                          @endforeach
                      </div>
                      <div class="row">
                          <div id="sync2" class="owl-carousel headnews-min">
                              @foreach (Posts::recentPosts()->limit(4)->get() as $post)
                                  <div class="item"><img class="img-responsive headnews-min-img" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" alt="" /></div>
                              @endforeach
                          </div>
                      </div>

                  </div>
                  <!-- Fin banner A la une  -->

                   <!-- Alerte -->
                  <div class="col-sm-16 col-md-5 col-lg-5 hidden-sm hidden-xs">
                      @include('frontend.rondpoint.include._alert-news')
                  </div>
                  <!-- Fin Alerte -->

              </div>
          </div>
      </div>
      <!-- banner outer end -->

      <div class="container">
          <div class="col-sm-16 col-md-16 col-lg-16">

              <div class="row">
                  <div class="col-sm-16 actu-home-main">
                      <div class="row">
                          <div class="actu-home-main-item col-xs-16 col-sm-5 wow fadeInLeft animated science animated"  style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInLeft;">
                              {{-- Titre block --}}
                              <div class="main-title-outer pull-left">
                                  <div class="main-title categ-title"><a href="#">Politique</a></div>
                              </div>
                              <div class="row ">
                                  @foreach (Posts::recentPosts()->limit(1)->get() as $post)
                                  <div class="topic news-big-bloc col-sm-16">
                                      <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                          <img class=" news-img" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" alt="">
                                          <div class="text-danger news-sub-info ">
                                              <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                              <div class="news-view pull-right"><span class="ion-eye icon"></span>204</div>
                                          </div>
                                          <div class="news-title"> {{ $post->post_title }}</div>

                                      </a>
                                      <div class="news-summary">{!! $post->post_summary !!}</div>
                                  </div>
                                  @endforeach
                                  <div class="col-sm-16">
                                      <ul class="list-unstyled  top-bordered ex-top-padding">
                                          @foreach (Posts::recentPosts()->limit(2)->get() as $post)
                                          <li>
                                              <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                                  <div class="row">
                                                      <div class="col-lg-3 col-md-4 hidden-sm  ">
                                                          <img  alt="" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" class="news-img pull-left">
                                                      </div>
                                                      <div class="col-lg-13 col-md-12">
                                                          <div class="news-title-next">{{ $post->post_title }} </div>
                                                          <div class="text-danger sub-info">
                                                              <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                                              <div class="news-view pull-right"><span class="ion-eye icon"></span>351</div>

                                                          </div>
                                                      </div>
                                                  </div>
                                              </a>
                                          </li>
                                          @endforeach
                                      </ul>
                                  </div>
                              </div>
                          </div>

                          <div class="actu-home-main-item col-sm-5 col-xs-16 wow fadeInRight animated animated"  style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInRight;">
                              {{-- Titre block --}}
                              <div class="main-title-outer pull-right">
                                  <div class="main-title categ-title"><a href="#">Economie</a></div>
                              </div>

                              <div class="row left-bordered">
                                  @foreach (Posts::recentPosts()->limit(1)->get() as $post)
                                  <div class="topic news-big-bloc col-sm-16">
                                      <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                          <img class=" news-img" src="{{ Posts::getImage($post->post_content, $post->post_image) }}"  alt="">
                                          <div class="text-danger news-sub-info ">
                                              <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                              <div class="news-view pull-right"><span class="ion-eye icon"></span>204</div>
                                          </div>
                                          <div class="news-title"> {{ $post->post_title }}</div>
                                      </a>
                                      <div class="news-summary">{!! $post->post_summary !!}</div>
                                  </div>
                                  @endforeach
                                  <div class="col-sm-16">
                                      <ul class="list-unstyled top-bordered ex-top-padding">
                                          @foreach (Posts::recentPosts()->limit(2)->get() as $post)
                                          <li>
                                              <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                                  <div class="row">
                                                      <div class="col-lg-3 col-md-4 hidden-sm  ">
                                                          <img  alt="" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" class="news-img pull-left">
                                                      </div>
                                                      <div class="col-lg-13 col-md-12">
                                                          <div class="news-title-next">{{ $post->post_title }} </div>
                                                          <div class="text-danger sub-info">
                                                              <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                                              <div class="news-view pull-right"><span class="ion-eye icon"></span>351</div>

                                                          </div>
                                                      </div>
                                                  </div>
                                              </a>
                                          </li>
                                          @endforeach
                                      </ul>
                                  </div>
                              </div>
                          </div>

                          <div class="actu-home-main-item col-sm-5 col-xs-16 wow fadeInRight animated animated"  style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInRight;">
                              {{-- Titre block --}}
                              <div class="main-title-outer pull-right">
                                  <div class="main-title categ-title"><a href="#">Société</a></div>
                              </div>

                              <div class="row left-bordered">
                                  @foreach (Posts::recentPosts()->limit(1)->get() as $post)
                                  <div class="topic news-big-bloc col-sm-16">
                                      <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                          <img class=" news-img" src="{{ Posts::getImage($post->post_content, $post->post_image) }}"  alt="">
                                          <div class="text-danger news-sub-info ">
                                              <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                              <div class="news-view pull-right"><span class="ion-eye icon"></span>204</div>
                                          </div>
                                          <div class="news-title"> {{ $post->post_title }}</div>
                                      </a>
                                      <div class="news-summary">{!! $post->post_summary !!}</div>
                                  </div>
                                  @endforeach
                                  <div class="col-sm-16">
                                      <ul class="list-unstyled top-bordered ex-top-padding">
                                          @foreach (Posts::recentPosts()->limit(2)->get() as $post)
                                          <li>
                                              <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                                  <div class="row">
                                                      <div class="col-lg-3 col-md-4 hidden-sm  ">
                                                          <img  alt="" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" class="news-img pull-left">
                                                      </div>
                                                      <div class="col-lg-13 col-md-12">
                                                          <div class="news-title-next">{{ $post->post_title }} </div>
                                                          <div class="text-danger sub-info">
                                                              <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                                              <div class="news-view pull-right"><span class="ion-eye icon"></span>351</div>

                                                          </div>
                                                      </div>
                                                  </div>
                                              </a>
                                          </li>
                                          @endforeach
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <hr>
                  </div>

                  {{-- Publicité --}}
                  @if (Ads::checkAdPlacementActive('home-horizontal'))
                    @include('frontend.magz.inc._ads-home-horizontal')
                  @endif

                  <!-- Sport-->
                  <div class="col-sm-11 wow fadeInUp animated " data-wow-delay="0.5s" data-wow-offset="100">
                      <div class="main-title-outer pull-left">
                          <div class="main-title categ-title"><a href="#">Sport</a></div>
                      </div>
                      <div class="row">
                          <div id="owl-lifestyle" class="owl-carousel owl-theme lifestyle pull-left">
                              @foreach (Posts::recentPosts()->limit(5)->get() as $post)
                              <div class="item topic sport col-m d-4">
                                  <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                                      <img class="sport-img" src="{{ Posts::getImage($post->post_content, $post->post_image) }}"  alt="" />
                                      <div class="text-danger news-sub-info remove-borders">
                                          <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                                          <div class="news-view pull-right"><span class="ion-eye icon"></span>204</div>
                                      </div>
                                      <div class="news-title-next">{{ $post->post_title }}</div>
                                  </a>
                              </div>
                              @endforeach
                          </div>
                      </div>
                      <hr>
                  </div>
                  <div class="col-sm-5 wow fadeInUp animated " data-wow-delay="0.5s" data-wow-offset="100">
                      <img src="https://magz.retenvi.com/ad/350x300.png">
                  </div>
                  <!-- Fin sport -->
              </div>

          </div>





      </div>


  </div>



  <section class="section-dossiers section-marginb" style=" display: block;
                                                            padding-top: 60px;
                                                            padding-bottom: 40px;
                                                            width: 100%;
                                                            mar gin-left: -80px;
                                                            marg in-right: -80px;
                                                            padding-left: 80px;
                                                            padding-right: 80px;
                                                            background-color: #000;
                                                            margin: 30px 0;
  ">
      <div class="container">
        <div class="row">
          <div class="col-md-8">



            <div class="sidebar-widget widget-latest-posts mb-50 wow fadeInUp  animated" style="visibility: visible; animation-name: fadeInUp;">
                              <div class="widget-header-1 position-relative mb-30">
                                  <h5 class="mt-5 mb-30">Most popular</h5>
                              </div>
                              <div class="post-block-list post-module-1">
                                  <ul class="list-post">
                                      <li class="mb-30 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                          <div class="d-flex bg-white has-border p-25 hover-up transition-normal border-radius-5">
                                              <div class="post-content media-body">
                                                  <h6 class="post-title mb-15 text-limit-2-row font-medium"><a href="single.html">Spending Some Quality Time with Kids? It’s Possible</a></h6>
                                                  <div class="entry-meta meta-1 float-left font-x-small text-uppercase">
                                                      <span class="post-on">05 August</span>
                                                      <span class="post-by has-dot">150 views</span>
                                                  </div>
                                              </div>
                                              <div class="post-thumb post-thumb-80 d-flex ml-15 border-radius-5 img-hover-scale overflow-hidden">
                                                  <a class="color-white" href="single.html">
                                                      <img src="assets/imgs/news/thumb-6.jpg" alt="">
                                                  </a>
                                              </div>
                                          </div>
                                      </li>
                                      <li class="mb-30 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                          <div class="d-flex bg-white has-border p-25 hover-up transition-normal border-radius-5">
                                              <div class="post-content media-body">
                                                  <h6 class="post-title mb-15 text-limit-2-row font-medium"><a href="single.html">Relationship Podcasts are Having “That” Talk</a></h6>
                                                  <div class="entry-meta meta-1 float-left font-x-small text-uppercase">
                                                      <span class="post-on">12 August</span>
                                                      <span class="post-by has-dot">6k views</span>
                                                  </div>
                                              </div>
                                              <div class="post-thumb post-thumb-80 d-flex ml-15 border-radius-5 img-hover-scale overflow-hidden">
                                                  <a class="color-white" href="single.html">
                                                      <img src="assets/imgs/news/thumb-7.jpg" alt="">
                                                  </a>
                                              </div>
                                          </div>
                                      </li>
                                      <li class="mb-30 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                          <div class="d-flex bg-white has-border p-25 hover-up transition-normal border-radius-5">
                                              <div class="post-content media-body">
                                                  <h6 class="post-title mb-15 text-limit-2-row font-medium"><a href="single.html">Here’s How to Get the Best Sleep at Night</a></h6>
                                                  <div class="entry-meta meta-1 float-left font-x-small text-uppercase">
                                                      <span class="post-on">15 August</span>
                                                      <span class="post-by has-dot">16k views</span>
                                                  </div>
                                              </div>
                                              <div class="post-thumb post-thumb-80 d-flex ml-15 border-radius-5 img-hover-scale overflow-hidden">
                                                  <a class="color-white" href="single.html">
                                                      <img src="assets/imgs/news/thumb-2.jpg" alt="">
                                                  </a>
                                              </div>
                                          </div>
                                      </li>
                                      <li class="wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                          <div class="d-flex bg-white has-border p-25 hover-up transition-normal border-radius-5">
                                              <div class="post-content media-body">
                                                  <h6 class="post-title mb-15 text-limit-2-row font-medium"><a href="single.html">America’s Governors Get Tested for a Virus That Is Testing Them</a></h6>
                                                  <div class="entry-meta meta-1 float-left font-x-small text-uppercase">
                                                      <span class="post-on">12 August</span>
                                                      <span class="post-by has-dot">3k views</span>
                                                  </div>
                                              </div>
                                              <div class="post-thumb post-thumb-80 d-flex ml-15 border-radius-5 img-hover-scale overflow-hidden">
                                                  <a class="color-white" href="single.html">
                                                      <img src="assets/imgs/news/thumb-3.jpg" alt="">
                                                  </a>
                                              </div>
                                          </div>
                                      </li>
                                  </ul>
                              </div>
                          </div>






          </div>
          <div class="col-md-8">

          </div>

        </div>

      </div>
  </section>






  <section class="divers-home" >
      <div class="container ">
        <div class="row ">
          <!-- left sec start -->
          <div class="col-md-16 col-sm-16">
            <div class="row">

              <div class="main-title-outer pull-left">
                  <div class="main-title categ-title"><a href="#">Faits Divers</a></div>
              </div>

              {{-- Divers --}}
              @foreach (Posts::recentPosts()->limit(4)->get() as $post)
                <div class="diverbloc-home sec-topic col-sm-16 col-md-5 wow fadeInDown animated " data-wow-delay="0.5s">{{-- \Image::make(storage_path("app/public/images/".$post->post_image))->resize(200, 200) --}}
                  <a href="{{ route('category.show', Posts::getLinkCategory($post))}}">
                    <img alt="" src="{{ Posts::getImage($post->post_content, $post->post_image) }}" class="news-img divers-img">
                    <div class="sec-info">
                      <div class="text-danger news-sub-info">
                        <div class="news-time"><span class="ion-android-data icon"></span>{{ $post->created_at->format('d/m/Y') }}</div>
                        <div class="news-view pull-right"><span class="ion-eye icon"></span>204</div>
                      </div>
                      <div class="news-title">{{ $post->post_title }}</div>

                    </div>
                  </a>
                  <p>{!! $post->post_summary !!} </p>
                </div>
              @endforeach

            </div>
          </div>
          <!-- left sec end -->


        </div>
      </div>
    </section>
    <!-- data end -->






  {{--
<section class="home">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                @include('frontend.magz.inc._headline')
                @include('frontend.magz.inc._featured-carousel')
                @include('frontend.magz.inc._latest-news-home')

                @if (Ads::checkAdPlacementActive('home-horizontal'))
                @include('frontend.magz.inc._ads-home-horizontal')
                @endif

                <div class="line transparent little"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 trending-tags">
                        @include('frontend.magz.inc._trending-tags')
                    </div>
                    <div class="col-md-6 col-sm-6">
                       @include('frontend.magz.inc._hot-news')
                    </div>
                </div>
                @include('frontend.magz.inc._just-another-news')
            </div>

            <div class="col-xs-6 col-md-4 sidebar" id="sidebar">
                @include('frontend.magz.template-parts.sidebar-right')
            </div>
        </div>
    </div>
</section>

@include('frontend.magz.inc._best-of-the-week')
--}}

  @endsection
