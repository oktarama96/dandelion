<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'IdPengguna';

    protected $hidden = [
        'Password',
        'remember_token'
    ];

    public function transaksi()
    {
        return $this->hasMany('App\Transaksi', 'IdPengguna', 'IdPengguna');
    }
}
