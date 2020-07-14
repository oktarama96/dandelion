<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    protected $table = 'warna';
    protected $primaryKey = 'IdWarna';

    public function stok()
    {
        return $this->hasMany('App\StokProduk', 'IdWarna', 'IdWarna');
    }
}
