<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdStrukturalToKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_struktural')->nullable()->after('status');

            $table->foreign('id_struktural')->references('id_struktural')->on('struktural')->onDelete('set null')->onUpdate('cascade');
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
            $table->dropForeign(['id_struktural']);
            $table->dropColumn(['id_struktural']);
        });
    }
}
