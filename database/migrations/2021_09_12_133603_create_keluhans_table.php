<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluhan', function (Blueprint $table) {
            $table->id('id_keluhan');
            $table->dateTime('tgl_keluhan');
            $table->char('npm', 16);
            $table->string('judul_keluhan');
            $table->text('isi_keluhan');
            $table->string('foto');
            $table->enum('status', ['0', 'proses', 'selesai']);

            $table->timestamps();

            $table->foreign('npm')->references('npm')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluhan');
    }
}
