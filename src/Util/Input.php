<?php

namespace Dipoengoro\GudangBase\Util;

use Dipoengoro\GudangBase\Entity\Barang;

class Input
{
    static function inputMenu(string $info): string
    {
        echo "$info: ";
        $result = fgets(STDIN);
        return trim(strtolower($result));
    }

    static function inputData(string $info): string
    {
        echo "$info: ";
        $result = fgets(STDIN);
        return trim($result);
    }

    static function inputDataInt(string $info): int
    {
        echo "$info: ";
        fscanf(STDIN, "%d\n", $result);
        return $result;
    }

    static function titleBanner(string $s): void
    {
        $result = strtoupper($s);
        echo PHP_EOL . "-(& $result &)-" . PHP_EOL;
    }

    static function banner(string $s): void
    {
        echo "$s" . PHP_EOL;
    }

    static function barang(Barang $b): void
    {
        Input::banner(
            $b->getIdBarang() . " | " .
                $b->getNamaBarang() . " | " .
                $b->getHargaSatuan() . " | " .
                $b->getSatuanBarang()  . " | " .
                $b->getSisaBarang()
        );
    }

    static function exit(): void
    {
        exit();
    }
}
