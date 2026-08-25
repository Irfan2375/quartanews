<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('photo1')->nullable()->after('thumbnail');
            $table->string('photo2')->nullable()->after('photo1');
            $table->string('photo3')->nullable()->after('photo2');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['photo1', 'photo2', 'photo3']);
        });
    }
};
