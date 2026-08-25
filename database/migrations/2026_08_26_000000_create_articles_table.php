<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // politik, ekonomi, teknologi, budaya, olahraga, sains, opini
            $table->string('author');
            $table->text('excerpt');
            $table->longText('body');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_lead')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['category', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
