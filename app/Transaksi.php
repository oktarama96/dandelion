<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'IdTransaksi';

    public function detailtransaksi()
    {
        return $this->hasMany('App\DetailTransaksi', 'IdTransaksi', 'IdTransaksi');
    }

    public function pengguna()
    {
        return $this->belongsTo('App\Pengguna', 'IdPengguna', 'IdPengguna');
    }

    public function pelanggan()
    {
        return $this->belongsTo('App\Pelanggan', 'IdPelanggan', 'IdPelanggan');
    }

    public function kupondiskon()
    {
        return $this->belongsTo('App\KuponDiskon', 'IdKuponDiskon', 'IdKuponDiskon');
    }
}
