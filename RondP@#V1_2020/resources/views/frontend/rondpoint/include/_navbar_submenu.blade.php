<ul class="dropdown-menu text-capitalize mega-menu" role="menu">
  @foreach( $childs as $child )
    <li>
        <span class="ion-ios7-arrow-right nav-sub-icn"></span>
        <a href="{{ $child['link'] }}" title="">{{ $child['label'] }}@if($child['child'])<i class="ion-ios-arrow-right"></i>@endif</a>
    </li>
  @endforeach
</ul>
