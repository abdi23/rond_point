<h1 class="title-col">
    {{ __('Hot News') }}
    <div class="carousel-nav" id="hot-news-nav">
        <div class="prev">
            <i class="ion-ios-arrow-left"></i>
        </div>
        <div class="next">
            <i class="ion-ios-arrow-right"></i>
        </div>
    </div>
</h1>
<div class="fbt-scroll-tab_container ">

  <div class="list-group">
    <a href="#" class="list-group-item btnUp"><i class="ion-ios-arrow-right"></i></a>
    <a href="#" class="list-group-item btnDown"><i class="ion-ios-arrow-left"></i></a>
  </div>

{{--
<div class="body-col vertical-slider alertRP" data-max="4" data-nav="#hot-news-nav" data-item="article">
    @foreach( Posts::popularPosts()->limit(4)->get() as $post )
    <article class="article-mini">
        <div class="inner">
            <figure>
                <a href="{{ Settings::getRoutePost($post) }}">
                    <img src="{{ Posts::getImage($post->post_content, $post->post_image) }}"
                        alt="{{ $post->post_image }}" alt="{{ $post->post_image }}">
                </a>
            </figure>
            <div class="padding">
                <h1><a href="{{ Settings::getRoutePost($post) }}">{{ $post->post_title }}</a></h1>
                <div class="detail">
                    <div class="category">
                        <a href="{{ route('category.show', Posts::getLinkCategory($post)) }}">
                            {{ Posts::getCategory($post) }}
                        </a>
                    </div>
                    <div class="time">{{ $post->created_at->format('F d, Y')}}</div>
                </div>
            </div>
        </div>
    </article>
    @endforeach
</div>
--}}


  <div class="fbt-scroll-tab_content">
    <div id="latest-posts" class="alertRP demof ">
      <div class="fbt-scroll-tab">
          @foreach( Posts::popularPosts()->limit(5)->get() as $post )

              <div class="alert-item">
                  <a class="alert-category" href="{{ route('category.show', Posts::getLinkCategory($post)) }}">
                      {{ Posts::getCategory($post) }}
                  </a>
                  <a href="https://anartisis-classic-fbt.blogspot.com/2018/09/the-future-of-news-blogger-themes.html">
                    <h3 class="h6"><a href="{{ Settings::getRoutePost($post) }}">{{ $post->post_title }}</a></h3>
                  </a>
                  <div class="alert-meta">
                    <span class="timestamp">{{ $post->created_at->format('F d, Y')}}</span>
                  </div>
              </div>

              {{--
              <h1><a href="{{ Settings::getRoutePost($post) }}">{{ $post->post_title }}</a></h1>
              <div class="det ail">
                  <div class="cate gory">
                      <a href="{{ route('category.show', Posts::getLinkCategory($post)) }}">
                          {{ Posts::getCategory($post) }}
                      </a>
                  </div>
                  <div class="time">{{ $post->created_at->format('F d, Y')}}</div>
              </div>
              --}}
          @endforeach
     </div>
    </div>
  </div>

</div>
