<footer>
  <div class="btm-sec top-footer">
    <div class="container">
      <div class="row">

            <div class="col-md-8 col-sm-12 f-nav wow fadeInDown animated animated" data-wow-delay="0.5s" data-wow-offset="10" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
              <div class="list-inline">Comment faire de la publicité sur rondpoint.net ? <a href="">Suivez ce lien</a></div>
            </div>
            <div class="col-md-4 col-sm-12 f-social pull-right  wow fadeInDown animated animated" data-wow-delay="1s" data-wow-offset="10" style="visibility: visible; animation-delay: 1s; animation-name: fadeInDown;">
              Suivez-nous sur:
              <ul class="list-inline">
                <li> <a href="#"><span class="ion-social-twitter"></span></a> </li>
                <li> <a href="#"><span class="ion-social-facebook"></span></a> </li>
                <li> <a href="#"><span class="ion-social-instagram"></span></a> </li>
              </ul>
            </div>
        </div>
     </div>
  </div>

    <div class="top-sec">
      <div class="container ">
        <div class="row match-height-container">
          <div class="col-sm-6 subscribe-info wow fadeInDown animated animated" data-wow-delay="1s" data-wow-offset="40" style="visibility: visible; animation-delay: 1s; animation-name: fadeInDown;">
            <div class="row">
              <div class="col-sm-16">
                <div class="f-title">
                  <figure class="foot-logo">
                      @empty(Settings::get('logowebsite_footer'))
                          <img src="{{ asset('themes/magz/images/logo-light.png') }}" alt="Web Logo">
                      @else
                          <img src="{{  route('logo.display', Settings::get('logowebsite_footer')) }}" alt=" Web Logo">
                      @endempty
                  </figure>
                </div>
                <p>Lorem Ipsum has been the standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
              </div>

            </div>
          </div>
          <div class="col-sm-5 popular-tags  wow fadeInDown animated animated" data-wow-delay="1s" data-wow-offset="40" style="visibility: visible; animation-delay: 1s; animation-name: fadeInDown;">
            <div class="f-title">popular tags</div>
            <ul class="tags list-unstyled pull-left">
              <li><a href="#">Business</a></li>
              <li><a href="#" class="">Science</a></li>
              <li><a href="#">video conferece</a></li>
              <li><a href="#">conferece</a></li>
              <li><a href="#">Photo</a></li>
              <li><a href="#">education</a></li>
              <li><a href="#">Smart phones</a></li>
              <li><a href="#">Samsung mobile</a></li>
              <li><a href="#">AI</a></li>
              <li><a href="#">video conferece</a></li>
              <li><a href="#">conferece</a></li>
              <li><a href="#">education</a></li>
              <li><a href="#">Technology</a></li>
              <li><a href="#">computer</a></li>
            </ul>
          </div>
          <div class="col-sm-5 recent-posts  wow fadeInDown animated animated" data-wow-delay="1s" data-wow-offset="40" style="visibility: visible; animation-delay: 1s; animation-name: fadeInDown;">
            <div class="f-title">subscribe to news letter</div>
            <div class="">
              <p>Lorem Ipsum has been the standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
              <form class="form-inline">
                <input type="email" class="form-control" id="input-email" placeholder="Type your e-mail adress">
                <button type="submit" class="btn"> <span class="ion-paper-airplane text-danger"></span> </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xs-16 copyrights text-right wow fadeInDown animated animated" data-wow-delay="0.5s" data-wow-offset="10" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">© 2014 GLOBALNEWS THEME - ALL RIGHTS RESERVED</div>


  </footer>
