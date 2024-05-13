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
        Schema::create('vendor_bank_card_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_profile_id');
            $table->foreign('vendor_profile_id')->references('id')->on('vendor_profiles');
            $table->string('card_holder_name');
            $table->string('card_number');
            $table->string('cvv');
            $table->date('valid_date');
            $table->string('card_type');
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
        Schema::dropIfExists('vendor_bank_card_details');
    }
};
