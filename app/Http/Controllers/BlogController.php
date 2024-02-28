<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\SchemaOrg;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index(): \Inertia\Response
    {
        $articles = Article::with('user')
            ->where('active', true)
            ->latest()->get();

        return Inertia::render('Blog', [
            'articles' => $articles,
        ]);
    }

    public function article(Article $article): \Inertia\Response
    {
        abort_if(! $article->active, 404);

        \View::share(['schema' => ['article' => app(SchemaOrg::class)->article($article->load('user'))]]);

        return Inertia::render('Article', ['article' => $article->load('user')]);
    }
}
