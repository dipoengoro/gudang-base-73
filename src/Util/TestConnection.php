<?php
require_once __DIR__ . "../../../vendor/autoload.php";

use Dipoengoro\GudangBase\Util\Connect;

$db = Connect::getConnection();
echo "Berhasil konek";