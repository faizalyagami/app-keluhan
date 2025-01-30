<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetugasStrukturalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas_struktural', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petugas');
            $table->unsignedBigInteger('id_struktural');
            $table->timestamps();

            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade');
            $table->foreign('id_struktural')->references('id_struktural')->on('struktural')->onDelete('cascade');

            $table->unique(['id_petugas', 'id_struktural']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petugas_struktural');
    }
}
