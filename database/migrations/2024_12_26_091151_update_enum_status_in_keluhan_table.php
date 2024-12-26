<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnumStatusInKeluhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            DB::statement("ALTER TABLE `keluhan` CHANGE `status` `status` ENUM('0', 'proses', 'selesai', 'disposisi') NOT NULL");
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
            DB::statement("ALTER TABLE `keluhan` CHANGE `status` `status` ENUM('0', 'proses', 'selesai') NOT NULL");
        });
    }
}
