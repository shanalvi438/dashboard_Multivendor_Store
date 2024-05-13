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
        Schema::create('vendor_profile', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_id');
            $table->string('logo')->nullable();
            $table->string('country');
            $table->string('slider_title')->nullable();
            $table->string('slider_title2')->nullable();
            $table->json('slider_images')->nullable();
            $table->text('about')->nullable();
            $table->text('portfolio')->nullable();
            $table->text('disclaimer')->nullable();
            $table->string('company_name')->nullable();
            $table->string('p_category1')->nullable();
            $table->json('p_c1_images')->nullable();
            $table->string('p_category2')->nullable();
            $table->json('p_c2_images')->nullable();
            $table->string('p_category3')->nullable();
            $table->json('p_c3_images')->nullable();
            $table->string('p_category4')->nullable();
            $table->json('p_c4_images')->nullable();
            $table->string('p_category5')->nullable();
            $table->json('p_c5_images')->nullable();
            $table->string('id_front')->nullable();
            $table->string('id_back')->nullable();
            $table->string('trade_license')->nullable();
            $table->string('tagline')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_profile');
    }
};
