<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameJudulKeluhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->renameColumn('kategori_keluhan', 'kategori_keluhan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->renameColumn('kategori_keluhan', 'kategori_keluhan');
        });
    }
}
