<?php
namespace Dipoengoro\GudangBase\Util;

use Exception;

abstract class ValidateInput extends Exception
{
    abstract function validation(): bool;
}

class Validation
{
    static function validateHarga(string $s)
    {
        $input = (int) $s;
        if ($input == 0) {
            throw new Exception("Input pada harga (Rupiah) bukan bertipe integer", 1);
        }
    }
    
    static function validateSisa(string $s)
    {
        $input = (float) $s;
        if ($input == 0) {
            throw new Exception("Input pada sisa barang bukan bertipe float", 1);
        }
    }
}