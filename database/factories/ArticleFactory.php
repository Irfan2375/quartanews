<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(4),
            'category' => fake()->randomElement([
                'politik', 'ekonomi', 'teknologi', 'budaya', 'olahraga', 'sains', 'opini',
            ]),
            'author' => fake()->name(),
            'excerpt' => fake()->paragraph(2),
            'body' => collect(fake()->paragraphs(6))->map(
                fn ($p) => '<p>'.$p.'</p>'
            )->implode(''),
            'is_featured' => false,
            'is_lead' => false,
            'published_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
