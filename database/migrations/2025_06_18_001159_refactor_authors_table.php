<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropUnique(['user_id', 'project_id']);
            $table->dropColumn(['project_id']);
            $table->foreignId('user_id')->nullable()->change();
            $table->string('slug')->unique('authors_slug_unique');
            $table->text('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->unique(['user_id', 'project_id']);
            $table->foreignId('user_id')->nullable(false)->change();
            $table->dropUnique('authors_slug_unique');
            $table->dropColumn(['slug', 'bio']);
        });
    }
};