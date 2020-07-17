<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'IdTransaksi';

    public function setSuccess(){
        $this->setStatusPembayaran = 1;
    }
    public function setPending(){
        $this->setStatusPembayaran = 2;
    }
    public function setFailed(){
        $this->setStatusPembayaran = 3;
    }
    public function setExpired(){
        $this->setStatusPembayaran = 4;
    }
    public function setStatusPembayaran($status){
        $this->StatusPembayaran = $status;
        self::save();
    }

    public function setStatusPesanan($status){
        $this->StatusPesanan = $status;
        self::save();
    }
    public function setDiproses(){
        $this->setStatusPesanan = 1;
    }
    public function setDikirim(){
        $this->setStatusPesanan = 2;
    }
    public function setSelesai(){
        $this->StatusPesanan = 3;
    }

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
