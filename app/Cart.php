<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'Cart';
    protected $primaryKey = 'IdCart';

    public function stokproduk()
    {
        return $this->hasOne('App\StokProduk', 'IdStokProduk', 'IdStokProduk');
    }

    
    public function produk()
    {
        return $this->stokproduk()->produk();
    }
}
