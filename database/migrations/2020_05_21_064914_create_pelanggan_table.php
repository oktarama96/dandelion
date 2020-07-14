<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('IdPelanggan');
            $table->string('NamaPelanggan', 125);
            $table->date('TglLahir');
            $table->enum('JenisKelamin', ['Laki-laki', 'Perempuan']);
            $table->string('Email', 100)->unique();
            $table->string('Password');
            $table->rememberToken();
            $table->text('Alamat');
            $table->char('NoHandphone', 15);
            $table->integer('IdKecamatan');
            $table->string('NamaKecamatan', 100);
            $table->integer('IdKabupaten');
            $table->string('NamaKabupaten', 100);
            $table->integer('IdProvinsi');
            $table->string('NamaProvinsi', 100);
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
        Schema::dropIfExists('pelanggan');
    }
}
