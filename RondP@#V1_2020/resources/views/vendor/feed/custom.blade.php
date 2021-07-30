<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title>{{ $meta['title'] }}</title>
        <link>{{ url($meta['link']) }}</link>
        <description>{{ $meta['description'] }}</description>
        <language>{{ $meta['language'] }}</language>
        <pubDate>{{ $meta['updated'] }}</pubDate>

        @foreach($items as $item)
            <item>
                <title>{{ $item->title }}</title>
                <link>{{ url($item->link) }}</link>
                <description>{{ $item->summary }}</description>
                <author>{{ $item->author }}</author>
                <guid>{{ url($item->id) }}</guid>
                <pubDate>{{ $item->updated->toRfc3339String() }}</pubDate>
                @foreach($item->category as $category)
                    <category>{{ $category }}</category>
                @endforeach
            </item>
        @endforeach
    </channel>
</rss>
