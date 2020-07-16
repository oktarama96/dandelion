<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'IdProduk';

    protected $keyType = 'string';

    public function kategori()
    {
        return $this->belongsTo('App\KategoriProduk', 'IdKategoriProduk', 'IdKategoriProduk');
    }

    public function stok()
    {
        return $this->hasMany('App\StokProduk', 'IdProduk', 'IdProduk');
    }

    public function detailtransaksi()
    {
        return $this->hasMany('App\DetailTransaksi', 'IdProduk', 'IdProduk');
    }

    public function warnas()
    {
        return $this->belongsToMany('App\Warna', 'stokproduk', 'IdProduk', 'IdWarna');
    }

    public function ukurans()
    {
        return $this->belongsToMany('App\Ukuran', 'stokproduk', 'IdProduk', 'IdUkuran');
    }
}
