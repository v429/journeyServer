<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->string('title');
            $table->integer('type');
            $table->timestamp('start_time')->default(date('Y-m-d H:i:s', time()));
            $table->timestamp('end_time')->default(date('Y-m-d H:i:s', time()));
            $table->tinyInteger('sex_limit');
            $table->string('target');
            $table->integer('spend');
            $table->integer('face_pic_id');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active');
    }
}
