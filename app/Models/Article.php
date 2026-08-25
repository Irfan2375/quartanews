<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'author',
        'excerpt',
        'body',
        'thumbnail',
        'photo1',
        'photo2',
        'photo3',
        'photo1_after',
        'photo2_after',
        'photo3_after',
        'is_featured',
        'is_lead',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_lead' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeLead(Builder $query): Builder
    {
        return $query->where('is_lead', true);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // --- Foto helpers (accessor supaya $article->thumbnail_url / ->photo_urls jalan) ---

    public function getThumbnailUrlAttribute(): string
    {
        return $this->urlFor($this->thumbnail);
    }

    public function getPhotoUrlsAttribute(): array
    {
        return $this->photosWithPosition();
    }

    public function photosWithPosition(): array
    {
        $out = [];
        foreach ([1, 2, 3] as $i) {
            $path = $this->{'photo'.$i};
            $url = $this->urlFor($path);
            if ($url === '') {
                continue;
            }
            $out[] = [
                'url' => $url,
                'after' => $this->{'photo'.$i.'_after'},
            ];
        }

        return $out;
    }

    public function getPhoto1UrlAttribute(): string { return $this->urlFor($this->photo1); }
    public function getPhoto2UrlAttribute(): string { return $this->urlFor($this->photo2); }
    public function getPhoto3UrlAttribute(): string { return $this->urlFor($this->photo3); }

    protected function urlFor(?string $path): string
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return '';
    }

    // --- Body: plain text -> paragraf HTML rapi ---

    public function bodyHtml(): string
    {
        $text = trim((string) $this->body);
        if ($text === '') {
            return '';
        }

        // pisah jadi paragraf berdasar baris kosong / enter ganda
        $blocks = preg_split('/\n\s*\n/', $text);
        $html = '';
        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }
            // escape dulu biar aman, lalu ubah newline jadi <br>
            $escaped = e($block);
            $escaped = nl2br($escaped, false);
            $html .= '<p>'.$escaped.'</p>';
        }

        return $html;
    }
}
