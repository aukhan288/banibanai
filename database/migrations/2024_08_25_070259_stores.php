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
        $table->unsignedBigInteger('user_id');
        $table->string('name');
        $table->string('storeType');
        $table->string('storePurpose');
        $table->string('storeBankDetails');
        $table->string('storeOwner');
        $table->string('storeManager');
        $table->unsignedInteger('ntn');
        $table->string('thumbnail');
        $table->string('storeContactName');
        $table->string('storeContact1');
        $table->string('storeContact2');
        $table->string('storeContactMail');
        $table->string('address');
        $table->double('lat');
        $table->double('long');
        $table->time('opning_time');
        $table->time('closing_time');
        $table->double('min_order');
        $table->double('min_order_price');
        $table->string('deliveryFeetype');
        $table->double('delivery_amount_min');
        $table->double('delivery_amount_max');
        $table->double('delivery_radius');
        $table->string('deliveryBy');
        $table->string('orderTakingTime');

        $table->json('delivery_slots_start')->nullable();
        $table->json('delivery_slots_end')->nullable();

        $table->double('rating')->nullable();
        $table->unsignedInteger('commission');
        $table->unsignedInteger('platform_fee');
        $table->unsignedInteger('store_status')->default(1);
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
