<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategoriproduk';
    protected $primaryKey = 'IdKategoriProduk';

    public function produk()
    {
        return $this->hasMany('App\Produk', 'IdKategoriProduk', 'IdKategoriProduk');
    }
}
