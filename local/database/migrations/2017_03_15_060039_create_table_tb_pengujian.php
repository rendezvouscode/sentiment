<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTbPengujian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pengujian', function (Blueprint $table) {
            $table->integer('id_tweet')->unsigned()->primary('id_tweet');
            $table->enum('predicted_class', ['positif','negatif']);
            $table->string('matriks');
            $table->timestamps();

            $table->foreign('id_tweet')
                  ->references('id')->on('tb_training')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tb_pengujian');
    }
}
