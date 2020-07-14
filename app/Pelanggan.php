<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'IdPelanggan';

    protected $hidden = [
        'Password',
        'remember_token'
    ];

    public function transaksi()
    {
        return $this->hasMany('App\Transaksi', 'IdPelanggan', 'IdPelanggan');
    }
}
