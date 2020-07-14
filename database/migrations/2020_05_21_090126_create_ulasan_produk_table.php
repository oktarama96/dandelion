<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasanProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulasanproduk', function (Blueprint $table) {
            $table->increments('IdUlasanProduk');
            $table->string('Deskripsi');
            $table->integer('nilai');
            $table->integer('IdPelanggan')->unsigned();
            $table->char('IdProduk', 6);
            $table->timestamps();

            $table->foreign('IdPelanggan')->references('IdPelanggan')->on('pelanggan');
            $table->foreign('IdProduk')->references('IdProduk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ulasanproduk', function (Blueprint $table) {
            $table->dropForeign(['IdPelanggan']);
            $table->dropForeign(['IdProduk']);
        });

        Schema::dropIfExists('ulasanproduk');
    }
}
