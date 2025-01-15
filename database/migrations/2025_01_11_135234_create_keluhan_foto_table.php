<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluhanFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluhan_foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_keluhan'); // Kolom untuk foreign key
            $table->string('path');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_keluhan')->references('id_keluhan')->on('keluhan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluhan_foto');
    }
}
