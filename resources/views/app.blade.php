<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="{{ config('app.base') }}">

        @php
            $seo = config('seo');
            $seoUrl = rtrim($seo['url'] ?? config('app.url'), '/');
            // Canonical for the current request (query string stripped).
            $canonical = url()->current();
            // Build an absolute URL for the social sharing image.
            $ogImage = $seo['og_image'] ?? '';
            if ($ogImage && ! \Illuminate\Support\Str::startsWith($ogImage, ['http://', 'https://'])) {
                $ogImage = $seoUrl.'/'.ltrim($ogImage, '/');
            }
        @endphp

        {{-- Primary meta tags (rendered server-side so crawlers and link
             previews that don't run JavaScript can read them). Inertia's
             <Head> may override title/description on a per-page basis. --}}
        <title inertia>{{ ($seo['title'] ?? config('app.name')).' | '.($seo['title_suffix'] ?? config('app.name')) }}</title>
        <meta head-key="description" name="description" content="{{ $seo['description'] ?? '' }}">
        <meta name="keywords" content="{{ implode(', ', $seo['keywords'] ?? []) }}">
        <meta name="author" content="{{ $seo['name'] ?? config('app.name') }}">
        <meta name="robots" content="index, follow, max-image-preview:large">
        <meta name="theme-color" content="{{ $seo['theme_color'] ?? '#f26522' }}">
        <link rel="canonical" href="{{ $canonical }}">

        {{-- Open Graph (Facebook, WhatsApp, LinkedIn) --}}
        <meta head-key="og:type" property="og:type" content="website">
        <meta head-key="og:site_name" property="og:site_name" content="{{ $seo['name'] ?? config('app.name') }}">
        <meta head-key="og:title" property="og:title" content="{{ ($seo['title'] ?? config('app.name')).' | '.($seo['title_suffix'] ?? config('app.name')) }}">
        <meta head-key="og:description" property="og:description" content="{{ $seo['description'] ?? '' }}">
        <meta head-key="og:url" property="og:url" content="{{ $canonical }}">
        <meta head-key="og:locale" property="og:locale" content="{{ $seo['locale'] ?? 'pt_BR' }}">
        @if ($ogImage)
            <meta head-key="og:image" property="og:image" content="{{ $ogImage }}">
            <meta property="og:image:alt" content="{{ $seo['name'] ?? config('app.name') }}">
        @endif

        {{-- Twitter / X card --}}
        <meta head-key="twitter:card" name="twitter:card" content="summary_large_image">
        <meta head-key="twitter:title" name="twitter:title" content="{{ ($seo['title'] ?? config('app.name')).' | '.($seo['title_suffix'] ?? config('app.name')) }}">
        <meta head-key="twitter:description" name="twitter:description" content="{{ $seo['description'] ?? '' }}">
        @if ($ogImage)
            <meta head-key="twitter:image" name="twitter:image" content="{{ $ogImage }}">
        @endif
        @if (! empty($seo['twitter_handle']))
            <meta name="twitter:site" content="@{{ $seo['twitter_handle'] }}">
        @endif

        {{-- Structured data: ProfessionalService + WebSite (JSON-LD) --}}
        <script type="application/ld+json">
        @php
            $sameAs = array_values(array_filter($seo['social'] ?? []));
            $jsonLd = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    array_filter([
                        '@type' => $seo['business']['type'] ?? 'ProfessionalService',
                        '@id' => $seoUrl.'/#organization',
                        'name' => $seo['name'] ?? config('app.name'),
                        'url' => $seoUrl,
                        'image' => $ogImage ?: null,
                        'logo' => $ogImage ?: null,
                        'description' => $seo['description'] ?? null,
                        'telephone' => $seo['business']['telephone'] ?? null,
                        'email' => $seo['business']['email'] ?? null,
                        'areaServed' => $seo['business']['area_served'] ?? null,
                        'address' => ! empty($seo['business']['address']) ? array_filter([
                            '@type' => 'PostalAddress',
                            'addressRegion' => $seo['business']['address']['region'] ?? null,
                            'addressCountry' => $seo['business']['address']['country'] ?? null,
                        ]) : null,
                        'sameAs' => ! empty($sameAs) ? $sameAs : null,
                    ]),
                    [
                        '@type' => 'WebSite',
                        '@id' => $seoUrl.'/#website',
                        'url' => $seoUrl,
                        'name' => $seo['name'] ?? config('app.name'),
                        'inLanguage' => str_replace('_', '-', $seo['locale'] ?? 'pt_BR'),
                        'publisher' => ['@id' => $seoUrl.'/#organization'],
                    ],
                ],
            ];
        @endphp
        {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>

</html>
