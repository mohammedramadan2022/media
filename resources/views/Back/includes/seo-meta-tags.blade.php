    <!-- Search Engine -->
    <meta name="robots" content="index, follow"/>
    <meta name="author" content="{{ $author }}"/>
    <meta name="description" content="{{ $description }}"/>
    <meta name="keywords" content="{{ $keywords }}"/>
    <meta name="image" content="{{ $image }}">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="{{ $name }}">
    <meta itemprop="description" content="{{ $description }}">
    <meta itemprop="image" content="{{ $image }}">
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta property="og:title" content="{{ $name }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:url" content="{{ $url ?? request()->root() }}">
    <meta property="og:site_name" content="{{ $author }}">
    <meta property="og:type" content="website">
    <!-- Twitter -->
    <meta property="twitter:card" content="website">
    <meta property="twitter:title" content="{{ $name }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image:src" content="{{ $image }}">
    <meta name="twitter:card" content="{{ $author }}">
    <meta name="twitter:site" content="{{ getSetting('seo_twitter_site') }}">
    <meta name="twitter:creator" content="{{ getSetting('seo_twitter_creator') }}">
