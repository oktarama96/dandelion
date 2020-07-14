<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detailtransaksi';
    protected $primaryKey = 'IdDetailTransaksi';

    public function produk()
    {
        return $this->belongsTo('App\Produk', 'IdProduk', 'IdProduk');
    }

    public function stokproduk()
    {
        return $this->belongsTo('App\StokProduk', 'IdStokProduk', 'IdStokProduk');
    }

    public function transaksi()
    {
        return $this->belongsTo('App\Transaksi', 'IdTransaksi', 'IdTransaksi');
    }
}
