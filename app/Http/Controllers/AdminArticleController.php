<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $articles = Article::latest('published_at')->paginate(15);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.form', ['article' => null]);
    }

    public function store(Request $request)
    {
        $data = request()->validate($this->rules());

        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['thumbnail'] = $this->handleUpload($request, 'thumbnail');
        $data['photo1'] = $this->handleUpload($request, 'photo1');
        $data['photo2'] = $this->handleUpload($request, 'photo2');
        $data['photo3'] = $this->handleUpload($request, 'photo3');
        $data['published_at'] = $request->boolean('is_published')
            ? ($request->input('published_at') ?: now())
            : null;

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('status', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $rules = $this->rules();
        $data = request()->validate($rules);

        if ($request->hasFile('thumbnail')) {
            $this->deleteOldFile($article->thumbnail);
            $data['thumbnail'] = $this->handleUpload($request, 'thumbnail');
        }
        foreach (['photo1', 'photo2', 'photo3'] as $f) {
            if ($request->hasFile($f)) {
                $this->deleteOldFile($article->$f);
                $data[$f] = $this->handleUpload($request, $f);
            }
        }

        $data['published_at'] = $request->boolean('is_published')
            ? ($request->input('published_at') ?: $article->published_at ?: now())
            : null;

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        foreach (['thumbnail', 'photo1', 'photo2', 'photo3'] as $f) {
            $this->deleteOldFile($article->$f);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('status', 'Artikel berhasil dihapus.');
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:'.implode(',', array_keys(\App\Http\Controllers\ArticleController::CATEGORIES))],
            'author' => ['required', 'string', 'max:120'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
            'photo1' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
            'photo2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
            'photo3' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'],
            'photo1_after' => ['nullable', 'integer', 'min:1', 'max:30'],
            'photo2_after' => ['nullable', 'integer', 'min:1', 'max:30'],
            'photo3_after' => ['nullable', 'integer', 'min:1', 'max:30'],
            'is_featured' => ['boolean'],
            'is_lead' => ['boolean'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $i = 1;
        while (Article::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $original.'-'.$i++;
        }

        return $slug;
    }

    protected function handleUpload(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $name = Str::random(20).'.'.$file->getClientOriginalExtension();

        return $file->storeAs('articles', $name, 'public');
    }

    protected function deleteOldFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
