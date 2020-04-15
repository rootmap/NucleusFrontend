<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardPointesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_pointes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_id');
            $table->string('responsejson');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->string('card_expire_month');
            $table->string('card_expire_year');
            $table->string('card_cvc');
            $table->string('amount');
            $table->string('authcode');
            $table->string('token');
            $table->string('account');
            $table->string('retref');
            $table->string('resptext');
            $table->string('respstat');
            $table->string('commcard');
            $table->string('respcode');
            $table->string('refund_status');
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
        Schema::dropIfExists('card_pointes');
    }
}
