<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardpointeStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardpointe_store_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merchant_id');
            $table->string('username');
            $table->string('password');
            $table->string('module_status');
            $table->string('hsn');
            $table->string('authkey');
            $table->string('bolt_status');
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
        Schema::dropIfExists('cardpointe_store_settings');
    }
}
