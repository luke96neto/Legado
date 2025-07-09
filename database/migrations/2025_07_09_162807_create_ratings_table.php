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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->unsignedTinyInteger('rating')->default(0); 
            $table->timestamps();
            $table->unique(['project_id', 'user_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};