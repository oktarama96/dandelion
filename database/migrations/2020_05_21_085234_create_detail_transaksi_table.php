<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailtransaksi', function (Blueprint $table) {
            $table->increments('IdDetailTransaksi');
            $table->integer('Qty');
            $table->integer('Diskon');
            $table->integer('SubTotal');
            $table->char('IdProduk', 6);
            $table->integer('IdStokProduk')->unsigned();
            $table->char('IdTransaksi', 15);
            $table->timestamps();

            $table->foreign('IdProduk')->references('IdProduk')->on('produk');
            $table->foreign('IdStokProduk')->references('IdStokProduk')->on('stokproduk');
            $table->foreign('IdTransaksi')->references('IdTransaksi')->on('transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detailtransaksi', function (Blueprint $table) {
            $table->dropForeign(['IdProduk']);
            $table->dropForeign(['IdStokProduk']);
            $table->dropForeign(['IdTransaksi']);
        });

        Schema::dropIfExists('detailtransaksi');
    }
}
