<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->char('IdProduk', 6)->primary();
            $table->string('NamaProduk', 100);
            $table->string('GambarProduk');
            $table->integer('HargaPokok');
            $table->integer('HargaJual');
            $table->integer('Berat');
            $table->text('Deskripsi');

            $table->integer('IdKategoriProduk')->unsigned();

            $table->timestamps();

            $table->foreign('IdKategoriProduk')->references('IdKategoriProduk')->on('kategoriproduk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['IdKategoriProduk']);
        });

        Schema::dropIfExists('produk');
    }
}
