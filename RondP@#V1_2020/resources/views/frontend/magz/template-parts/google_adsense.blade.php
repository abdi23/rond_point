<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
    @if($ga->ad_size == 'fixed')
    style="display:inline-block;width:{{ $ga->ad_width }}px;height:{{ $ga->ad_height }}px"
    @else
    style="display:block"
    @endif

    data-ad-client="{{ $ga->ad_client }}"
    data-ad-slot="{{ $ga->ad_slot }}"

    @if($ga->ad_sizes == 'responsive')
        @if($ga->ad_format)
        data-ad-format="{{ $ga->ad_format }}"
        @endif
        data-full-width-responsive="{{ $ga->full_width_responsive }}">
    @endif
</ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>
