<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $table = 'ukuran';
    protected $primaryKey = 'IdUkuran';

    public function stok()
    {
        return $this->hasMany('App\StokProduk', 'IdUkuran', 'IdUkuran');
    }
}
