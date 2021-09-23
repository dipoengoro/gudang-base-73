<?php
require_once __DIR__ . "../../../vendor/autoload.php";
require_once __DIR__ . "../../Repository/Repository.php";
require_once __DIR__ . "../../Service/Service.php";

use Dipoengoro\GudangBase\Repository\BarangRepositoryImpl;
use Dipoengoro\GudangBase\Service\BarangServiceImpl;
use Dipoengoro\GudangBase\Util\Connect;
use Dipoengoro\GudangBase\Util\Input;

function testShowBarang(): void
{
    $connection = Connect::getConnection();
    $barangRepository = new BarangRepositoryImpl($connection);
    $barangService = new BarangServiceImpl($barangRepository);
    $barangService->showBarang();
    $connection = null;
}

function testRepository(): PDO
{
    $connection = Connect::getConnection();
    try {
        $barangRepository = new BarangRepositoryImpl($connection);
    } catch(Exception $e) {
        echo $e->getMessage();
    }
    
    // $result = $barangRepository->remove("dfada");
    return $connection;
}

function testExeption(int $i): void {
    if($i > 0) {
        throw new Exception("Eror lebih dari 0", 1);
    }
}

function testValidation(string $s) {
    $input = (int) $s;
    if ($input == 0) {
        throw new Exception("Error bukan integer", 1);   
    }
}

function testMinus(string $s): int {
    $input = (float) $s;
    return $input - 2;
}

function testName() 
{
    date_default_timezone_set("Asia/Jakarta");
    $currentDatetime = date("YmdHis");
    return $currentDatetime;
}
echo testName();
