<?php

    namespace App;

    class Item{
        private $nama;
        private $nilai;
        
        public function __construct($nama='', $nilai=''){
            $this -> nama = $nama;
            $this -> nilai = $nilai;
        }
        
        public function __toString(){
            $colkiri = 0;
            $colkanan = 32 - strlen($this -> nama);
            
            $kiri = str_pad($this -> nama, $colkiri);
            $kanan = str_pad($this -> nilai, $colkanan, ' ', STR_PAD_LEFT);
            return "$kiri$kanan\n";
        }
    }