<?php

require_once __DIR__ . "../../../vendor/autoload.php";
require_once __DIR__ . "../../Repository/Repository.php";

use Dipoengoro\GudangBase\Repository\BarangRepositoryImpl;
use Dipoengoro\GudangBase\Util\Connect;

$conn = Connect::getConnection();
$repo = new BarangRepositoryImpl($conn);
echo "Berhasil konak";

