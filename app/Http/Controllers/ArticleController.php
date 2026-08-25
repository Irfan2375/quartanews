<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public const CATEGORIES = [
        'politik' => 'Politik',
        'ekonomi' => 'Ekonomi',
        'teknologi' => 'Teknologi',
        'budaya' => 'Budaya',
        'olahraga' => 'Olahraga',
        'sains' => 'Sains',
        'opini' => 'Opini',
    ];

    public function home()
    {
        $lead = Article::published()->lead()->latest('published_at')->first()
            ?? Article::published()->latest('published_at')->first();

        $topNews = Article::published()
            ->where('is_featured', true)
            ->where('id', '!=', optional($lead)->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $latest = Article::published()
            ->where('id', '!=', optional($lead)->id)
            ->latest('published_at')
            ->take(9)
            ->get();

        $techFeature = Article::published()
            ->category('teknologi')
            ->latest('published_at')
            ->take(4)
            ->get();

        $opinions = Article::published()
            ->category('opini')
            ->latest('published_at')
            ->take(2)
            ->get();

        return view('articles.index', compact(
            'lead', 'topNews', 'latest', 'techFeature', 'opinions'
        ));
    }

    public function category(string $category)
    {
        abort_unless(array_key_exists($category, self::CATEGORIES), 404);

        $articles = Article::published()
            ->category($category)
            ->latest('published_at')
            ->paginate(9);

        $label = self::CATEGORIES[$category];

        return view('articles.category', compact('articles', 'category', 'label'));
    }

    public function show(Article $article)
    {
        abort_unless($article->published_at && $article->published_at->lte(now()), 404);

        $related = Article::published()
            ->category($article->category)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}
