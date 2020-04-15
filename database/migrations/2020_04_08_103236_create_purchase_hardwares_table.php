<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseHardwaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_hardwares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->integer('country');
            $table->string('country_name');
            $table->string('state');
            $table->string('zip_code');
            $table->string('delivery_address');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->string('card_month');
            $table->string('card_year');
            $table->string('card_pin');
            $table->integer('hardware');
            $table->string('hardware_title');
            $table->string('hardware_price');
            $table->string('payment_status');
            $table->string('hardware_delivery_status');
            $table->integer('store_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            
            $table->softDeletes();
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
        Schema::dropIfExists('purchase_hardwares');
    }
}
