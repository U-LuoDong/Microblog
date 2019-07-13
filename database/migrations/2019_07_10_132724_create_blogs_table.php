<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //blogs和users表是多对一关系
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('content', 200);
            $table->integer('user_id')->index();//创建了索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
