<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtestoComarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protesto_comarcas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->string('comarca');
            $table->integer('count_titulos');
            $table->integer('nr_remessa');
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
        Schema::dropIfExists('protesto_comarcas');
    }
}
