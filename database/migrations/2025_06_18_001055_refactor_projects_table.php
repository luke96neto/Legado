<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('status', ['rascunho', 'em_andamento', 'concluido', 'excluido'])->default('rascunho');
            $table->string('slug')->unique('projects_slug_unique');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_example')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique('projects_slug_unique');
            $table->dropColumn('slug');
            $table->dropColumn('status');
            $table->string('status')->default('Em andamento');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('is_example');
        });
    }
};