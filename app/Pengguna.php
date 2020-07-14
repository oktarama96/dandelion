<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $guard = 'pengguna';

    protected $table = 'pengguna';
    protected $primaryKey = 'IdPengguna';

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function transaksi()
    {
        return $this->hasMany('App\Transaksi', 'IdPengguna', 'IdPengguna');
    }
}
