<aside>
    <div class="aside-body">
        <figure class="ads">
            @if (Ads::type('sidebar-right-top') == 'image')
                @if (Ads::checkFileAd('sidebar-right-top'))
                    <a href="{{ Ads::url('sidebar-right-top') }}" target="_blank">
                        <img src="{{ Ads::image('sidebar-right-top') }}">
                    </a>
                    <figcaption>{{ __('Advertisement') }}</figcaption>
                @else
                    <a href="#">
                        <img src="{{ asset('themes/magz/images/ad.png') }}">
                    </a>
                    <figcaption>{{ __('Advertisement') }}</figcaption>
                @endif
            @elseif (Ads::type('sidebar-right-top') == 'ga')
                @include('frontend.magz.template-parts.google_adsense', ['ga' => Ads::dataGa('sidebar-right-top')]))
            @elseif (Ads::type('sidebar-right-top') == 'script_code')
                @if (File::exists(storage_path('app/public').'/ad/' . Ads::checkFileScript('sidebar-right-top')))
                    @include('ad::' . Ads::viewFileScript('sidebar-right-top'))
                @endif
            @else
                <a href="#">
                    <img src="{{ asset('themes/magz/images/ad.png') }}">
                </a>
                <figcaption>{{ __('Advertisement') }}</figcaption>
            @endif
        </figure>
    </div>
</aside>
