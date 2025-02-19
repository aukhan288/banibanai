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
        Schema::table('products', function (Blueprint $table) {
            $table->json('itemVariations')->nullable();
            $table->integer('minNumOfChoices')->nullable();
            $table->integer('maxNumOfChoices')->nullable();
            $table->text('choiceGroupName')->nullable();
            $table->integer('minNumOfChoicesGroup')->nullable();
            $table->integer('maxNumOfChoicesGroup')->nullable();
            $table->json('customChoices')->nullable();
            $table->json('flatChoices')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
