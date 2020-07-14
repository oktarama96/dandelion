<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    protected $table = 'stokproduk';
    protected $primaryKey = 'IdStokProduk';

    public function produk()
    {
        return $this->belongsTo('App\Produk', 'IdProduk', 'IdProduk');
    }

    public function warna()
    {
        return $this->belongsTo('App\Warna', 'IdWarna', 'IdWarna');
    }

    public function ukuran()
    {
        return $this->belongsTo('App\Ukuran', 'IdUkuran', 'IdUkuran');
    }

    public function detailtransaksi()
    {
        return $this->hasMany('App\DetailTransaksi', 'IdStokProduk', 'IdStokProduk');
    }
}
