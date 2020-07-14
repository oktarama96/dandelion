<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KuponDiskon extends Model
{
    protected $table = 'kupondiskon';
    protected $primaryKey = 'IdKuponDiskon';

    protected $keyType = 'string';

    public function kupondiskon()
    {
        return $this->hasMany('App\KuponDiskon', 'IdKuponDiskon', 'IdKuponDiskon');
    }
}
