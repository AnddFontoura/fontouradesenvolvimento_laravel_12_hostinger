<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO defaults
    |--------------------------------------------------------------------------
    |
    | Central place for the site metadata used to render meta tags, Open Graph,
    | Twitter cards and JSON-LD structured data. Values that vary per
    | environment (URLs, social handles) can be overridden via .env.
    |
    */

    // Company / brand name.
    'name' => env('APP_NAME', 'Fontoura Desenvolvimento'),

    // Short brand name used in title suffix.
    'short_name' => 'Fontoura',

    // Default page title (used on the home page).
    'title' => 'Desenvolvimento de Software Sob Medida',

    // Suffix appended to page titles, e.g. "Serviços | Fontoura Desenvolvimento".
    'title_suffix' => 'Fontoura Desenvolvimento',

    // Default meta description (max ~155 chars for best results).
    'description' => 'A Fontoura Desenvolvimento cria aplicações web modernas, '
        .'escaláveis e confiáveis com Laravel e Vue. Sistemas sob medida, APIs, '
        .'integrações e sustentação para o seu negócio.',

    // Keywords (minor SEO weight today, but harmless and useful for reference).
    'keywords' => [
        'desenvolvimento de software',
        'aplicações web',
        'Laravel',
        'Vue',
        'APIs',
        'sistemas sob medida',
        'desenvolvimento de sistemas',
        'consultoria de software',
    ],

    // Canonical/site URL. Falls back to APP_URL.
    'url' => env('SEO_SITE_URL', env('APP_URL', 'https://fontouradesenvolvimento.com.br')),

    // Absolute path (relative to public) to the image used for social sharing.
    // Recommended size: 1200x630. Falls back to the logo if not provided.
    'og_image' => env('SEO_OG_IMAGE', 'img/fontoura-dragao.png'),

    // Locale used by Open Graph.
    'locale' => 'pt_BR',

    // Contact / business info used for JSON-LD structured data.
    'business' => [
        'type' => 'ProfessionalService',
        'telephone' => '+55 41 99251-6138',
        'email' => env('SEO_CONTACT_EMAIL', 'contato@fontouradesenvolvimento.com.br'),
        'area_served' => 'BR',
        'address' => [
            'region' => 'PR',
            'country' => 'BR',
        ],
    ],

    // Social profiles (used as "sameAs" in JSON-LD). Leave empty to omit.
    'social' => array_filter([
        'whatsapp' => env('SEO_WHATSAPP_URL', 'https://wa.me/5541992516138'),
        'linkedin' => env('SEO_LINKEDIN_URL'),
        'instagram' => env('SEO_INSTAGRAM_URL'),
        'github' => env('SEO_GITHUB_URL'),
    ]),

    // Twitter/X handle (without @). Leave empty to omit twitter:site.
    'twitter_handle' => env('SEO_TWITTER_HANDLE'),

    // Brand color used for theme-color meta.
    'theme_color' => '#f26522',
];
