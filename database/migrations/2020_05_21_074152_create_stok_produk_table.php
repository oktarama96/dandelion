<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stokproduk', function (Blueprint $table) {
            $table->increments('IdStokProduk');
            $table->integer('StokMasuk');
            $table->integer('StokKeluar');
            $table->integer('StokAkhir');

            $table->integer('IdWarna')->unsigned();
            $table->integer('IdUkuran')->unsigned();
            $table->char('IdProduk', 6);
            $table->timestamps();

            $table->foreign('IdWarna')->references('IdWarna')->on('warna');
            $table->foreign('IdUkuran')->references('IdUkuran')->on('ukuran');
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
        Schema::table('stokproduk', function (Blueprint $table) {
            $table->dropForeign(['IdWarna']);
            $table->dropForeign(['IdUkuran']);
            $table->dropForeign(['IdProduk']);
        });

        Schema::dropIfExists('stokproduk');
    }
}
