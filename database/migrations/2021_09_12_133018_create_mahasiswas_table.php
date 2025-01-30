<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->char('npm', 11)->primary();
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->dateTime('email_verified_at');
            $table->string('username', 25)->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('password');
            $table->string('telp', 13);
            $table->string('alamat', 13);
            $table->char('rt', 4)->nullable();
            $table->char('rw', 4)->nullable();
            $table->char('kode_pos', 5)->nullable();
            $table->char('province_id', 2)->nullable();
            $table->char('regency_id', 4)->nullable();
            $table->char('district_id', 7)->nullable();
            $table->char('village_id', 10)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('mahasiswa');
    }
}
