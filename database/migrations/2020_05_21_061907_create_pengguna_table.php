<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->increments('IdPengguna');
            $table->string('NamaPengguna', 100);
            $table->string('Email', 100)->unique();
            $table->string('Password');
            $table->rememberToken();
            $table->text('Alamat');
            $table->char('NoHandphone', 15);
            $table->boolean('Is_admin');
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
        Schema::dropIfExists('pengguna');
    }
}
