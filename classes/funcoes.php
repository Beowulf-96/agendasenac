<?php
    class Funcoes {
        public function dataNasc ($vir, $tipo) {
            switch($tipo) {
                case 1:
                    $rst =implode("-", array_reverse(explode("/", $vir)));
                    break;

                case 2:
                    $rst = implode("/", array_reverse(explode("-", $vir)));
                    break;
            }
            return $rst;
        }
    }
?>