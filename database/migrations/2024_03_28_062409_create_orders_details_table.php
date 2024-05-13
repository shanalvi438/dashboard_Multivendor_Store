<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity');
                $table->decimal('p_price', 8, 2);
                $table->unsignedBigInteger('p_vendor_id');
                $table->string('status');
                $table->string('customer_cancel_status')->nullable();
                $table->string('customer_cancel_reason')->nullable();
                $table->timestamp('customer_cancel_time')->nullable();
                $table->string('refund_status')->nullable();
                $table->string('review_status')->nullable();
                $table->timestamps();
                
                // Foreign key constraints if needed
                // $table->foreign('product_id')->references('id')->on('products');
                // $table->foreign('p_vendor_id')->references('id')->on('vendors');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_details');
    }
};
