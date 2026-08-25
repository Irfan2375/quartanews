<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    public function test_guest_redirected_from_admin(): void
    {
        $this->get('/admin/articles')->assertRedirect('/login');
    }

    public function test_admin_can_crud_article(): void
    {
        $user = User::first() ?? User::factory()->create([
            'email' => 'admin@quartanews.test',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        // list
        $this->get('/admin/articles')->assertOk();

        // create
        $this->post('/admin/articles', [
            'title' => 'Artikel Test Browser',
            'category' => 'teknologi',
            'author' => 'Irfan',
            'excerpt' => 'Ringkasan test.',
            'body' => '<p>isi</p>',
            'is_published' => '1',
        ])->assertRedirect('/admin/articles');

        $article = Article::where('title', 'Artikel Test Browser')->first();
        $this->assertNotNull($article);

        // edit
        $this->put('/admin/articles/'.$article->id, [
            'title' => 'Artikel Test Browser (Edit)',
            'category' => 'politik',
            'author' => 'Irfan',
            'excerpt' => 'Ringkasan edit.',
            'body' => '<p>isi edit</p>',
            'is_published' => '1',
        ])->assertRedirect('/admin/articles');

        $this->assertEquals('Artikel Test Browser (Edit)', $article->fresh()->title);
        $this->assertEquals('politik', $article->fresh()->category);

        // delete
        $this->delete('/admin/articles/'.$article->id)->assertRedirect('/admin/articles');
        $this->assertNull(Article::find($article->id));
    }
}
