<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'IdPelanggan';

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function transaksi()
    {
        return $this->hasMany('App\Transaksi', 'IdPelanggan', 'IdPelanggan');
    }
}
