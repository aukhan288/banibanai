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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Category name
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable(); // Optional description
            $table->string('thumbnail')->nullable(); // Thumbnail field
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // Self join for parent category
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
