<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    public function index(): \Spatie\Sitemap\Sitemap
    {
        $url = config('app.url');

        return SitemapGenerator::create($url)->getSitemap();
    }
}
