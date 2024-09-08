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
        Schema::create('stores', function (Blueprint $table) {  
        $table->id();
        $table->string('name');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('store_type_id');
        $table->string('thumbnail');
        $table->string('min_delevery_time');
        $table->double('min_order');
        $table->double('rating');
        $table->time('opning_time');
        $table->string('address');
        $table->double('lat');
        $table->double('long');
        $table->unsignedInteger('ntn');
        $table->string('delivery_type');
        $table->unsignedInteger('delivery_fee');
        $table->double('delivery_radius');
        $table->unsignedInteger('commission');
        $table->unsignedInteger('platform_fee');
        $table->unsignedInteger('venu_fee')->nullable();
        $table->timestamps();
      });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
