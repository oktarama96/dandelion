<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->char('IdTransaksi', 15)->primary();
            $table->dateTime('TglTransaksi');
            $table->integer('Total');
            $table->integer('Potongan');
            $table->integer('OngkosKirim');
            $table->string('NamaEkspedisi', 50);
            $table->integer('GrandTotal');
            $table->string('MetodePembayaran');
            $table->integer('StatusPembayaran');
            $table->integer('StatusPesanan');
            $table->string('Snap_token');
            $table->string('IdKuponDiskon', 50)->nullable();
            $table->integer('IdPengguna')->unsigned();
            $table->integer('IdPelanggan')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('IdKuponDiskon')->references('IdKuponDiskon')->on('kupondiskon');
            $table->foreign('IdPengguna')->references('IdPengguna')->on('pengguna');
            $table->foreign('IdPelanggan')->references('IdPelanggan')->on('pelanggan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['IdKuponDiskon']);
            $table->dropForeign(['IdPengguna']);
            $table->dropForeign(['IdPelanggan']);
        });

        Schema::dropIfExists('transaksi');
    }
}
