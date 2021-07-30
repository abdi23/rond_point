<h1 class="block-title">{{ __('Popular Tags') }}</h1>
<div class="block-body">
    <ul class="tags">
        @foreach (Posts::tagCount()->skip(0)->take(10) as $count)
        <li><a href="{{ route('tag.show', $count->term->slug) }}">{{ $count->term->name }}</a></li>
        @endforeach
    </ul>
</div>