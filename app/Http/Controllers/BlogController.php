<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
        return Inertia::render('Article', ['article' => $article]);
    }
}
