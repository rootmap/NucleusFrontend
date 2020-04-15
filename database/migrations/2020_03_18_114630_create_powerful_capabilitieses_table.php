<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePowerfulCapabilitiesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powerful_capabilitieses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('heading_detail');
            $table->string('heading_title');
            $table->string('capability_item');
            $table->string('content_image');
            $table->string('section_foreground_color');
            $table->string('section_status');
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
        Schema::dropIfExists('powerful_capabilitieses');
    }
}
