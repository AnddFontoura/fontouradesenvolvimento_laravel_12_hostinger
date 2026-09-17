<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Render the XML sitemap for the public pages.
     */
    public function sitemap(): Response
    {
        $baseUrl = rtrim(config('seo.url') ?: config('app.url'), '/');
        $lastmod = now()->toAtomString();

        // The site currently exposes a single public page (the landing page).
        // Section anchors (#services, #about, #contact) live on the same URL,
        // so only the home URL is listed here.
        $urls = [
            [
                'loc' => $baseUrl.'/',
                'changefreq' => 'monthly',
                'priority' => '1.0',
            ],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($url['loc'], ENT_XML1).'</loc>'."\n";
            $xml .= '    <lastmod>'.$lastmod.'</lastmod>'."\n";
            $xml .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            $xml .= '    <priority>'.$url['priority'].'</priority>'."\n";
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>'."\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    /**
     * Render robots.txt with an absolute sitemap URL.
     */
    public function robots(): Response
    {
        $baseUrl = rtrim(config('seo.url') ?: config('app.url'), '/');

        $lines = [
            'User-agent: *',
            'Allow: /$',
            'Allow: /img/',
            'Allow: /build/',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /dashboard',
            'Disallow: /profile',
            'Disallow: /contacts',
            'Disallow: /categories',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /verify-email',
            'Disallow: /confirm-password',
            '',
            'Sitemap: '.$baseUrl.'/sitemap.xml',
            '',
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
