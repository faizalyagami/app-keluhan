<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameKategoriKeluhanToNamaKategoriKeluhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kategori_keluhan', function (Blueprint $table) {
            $table->renameColumn('kategori_keluhan', 'nama_kategori_keluhan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kategori_keluhan', function (Blueprint $table) {
            $table->renameColumn('nama_kategori_keluhan', 'kategori_keluhan');
        });
    }
}
