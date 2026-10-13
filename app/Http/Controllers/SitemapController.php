<?php

namespace App\Http\Controllers;

use App\Services\Seo\SeoService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function sitemap(SeoService $seoService): Response
    {
        $xml = $seoService->generateSitemapXml();

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /admin/*\n";
        $content .= "Disallow: /api/*\n";
        $content .= "Allow: /\n\n";
        $content .= 'Sitemap: '.url('/sitemap.xml')."\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
