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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acreage');
            $table->integer('child_out_of_quantity_fee');
            $table->integer('child_quantity');
            $table->integer('usage_quantity')->default(1);
            $table->integer('place_quantity')->default(1);
            $table->string('product_type');
            $table->integer('last_check_out_fee');
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
