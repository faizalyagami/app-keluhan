<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggapan', function (Blueprint $table) {
            $table->id('id_tanggapan');
            $table->unsignedBigInteger('id_keluhan');
            $table->dateTime('tgl_tanggapan');
            $table->text('tanggapan');
            $table->unsignedBigInteger('id_petugas');

            $table->timestamps();

            $table->foreign('id_keluhan')->references('id_keluhan')->on('keluhan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanggapan');
    }
}
