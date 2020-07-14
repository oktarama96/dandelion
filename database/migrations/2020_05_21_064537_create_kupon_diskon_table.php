<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuponDiskonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kupondiskon', function (Blueprint $table) {
            $table->string('IdKuponDiskon', 50)->primary();
            $table->string('NamaKupon');
            $table->dateTime('TglMulai');
            $table->dateTime('TglSelesai');
            $table->integer('JumlahPotongan');
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
        Schema::dropIfExists('kupondiskon');
    }
}
