<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTesting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_testing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tweet');
            $table->decimal('p_positif', 65,30);
            $table->decimal('p_negatif', 65,30);
            $table->string('class_prediksi');
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
        Schema::drop('tb_testing');
    }
}
