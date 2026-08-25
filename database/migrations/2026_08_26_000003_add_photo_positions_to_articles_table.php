<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedSmallInteger('photo1_after')->nullable()->after('photo1');
            $table->unsignedSmallInteger('photo2_after')->nullable()->after('photo2');
            $table->unsignedSmallInteger('photo3_after')->nullable()->after('photo3');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['photo1_after', 'photo2_after', 'photo3_after']);
        });
    }
};
