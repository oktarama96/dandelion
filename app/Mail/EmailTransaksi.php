<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTransaksi extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi, $detailtransaksis;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaksi, $detailtransaksis)
    {
        $this->transaksi = $transaksi;
        $this->detailtransaksis = $detailtransaksis;
        $this->subject('Dandelion Fashion Shop - Invoice');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@dandelionfashionshop.com')
                   ->view('email',['transaksi'=> $this->transaksi,'detailtransaksis'=>$this->detailtransaksis]);
    }
}
