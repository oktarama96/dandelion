<?php

    namespace App;
    
class ItemDt{
        private $nama;
        private $sub;
        private $nilai;
        
        public function __construct($nama='', $sub='', $nilai=''){
            $this -> nama = $nama;
            $this -> sub = $sub;
            $this -> nilai = $nilai;
        }
        
        public function __toString(){
            $colkiri = 0;
            $colkanan = 32 - strlen($this -> sub);
            
            $top = str_pad($this -> nama, $colkiri);
            
            $kiri = str_pad($this -> sub, $colkiri);
            $kanan = str_pad($this -> nilai, $colkanan, ' ', STR_PAD_LEFT);
            return "$top\n$kiri$kanan\n";
        }
    }