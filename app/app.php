<?php
require_once __DIR__ . "../../vendor/autoload.php";
require_once __DIR__ . "../../src/Repository/Repository.php";
require_once __DIR__ . "../../src/Service/Service.php";
require_once __DIR__ . "../../src/View/Gudang.php";
require_once __DIR__ . "../../src/Util/Validate.php";


use Dipoengoro\GudangBase\Repository\BarangRepositoryImpl;
use Dipoengoro\GudangBase\Service\BarangServiceImpl;
use Dipoengoro\GudangBase\Util\Connect;
use Dipoengoro\GudangBase\Util\Validation;
use Dipoengoro\GudangBase\View\GudangView;

echo "Aplikasi Gudang" . PHP_EOL;

$connection = Connect::getConnection();
$barangRepository = new BarangRepositoryImpl($connection);
$barangService = new BarangServiceImpl($barangRepository);
$validation = new Validation();
$gudangView = new GudangView($barangService, $validation);

$gudangView->showBarang();