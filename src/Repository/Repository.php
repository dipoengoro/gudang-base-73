<?php

namespace Dipoengoro\GudangBase\Repository;
require_once __DIR__ . "../../../vendor/autoload.php";

use Dipoengoro\GudangBase\Entity\Barang;
use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

interface BarangRepository
{
    function add(Barang $barang): void;

    function remove(string $id): void;

    function findAll(): array;

    function check(string $idBarang): bool;

    function find(string $idBarang): Barang;

    function updateNama(string $idBarang, string $valueBaru): void;

    function updateHarga(string $idBarang, string $valueBaru): void;

    function updateSatuan(string $idBarang, string $valueBaru): void;

    function checkSisaBarang(string $idBarang): float;

    function transactionKeluar(string $idBarang, float $jumlah_barang): void;

    function transactionMasuk(string $idBarang, float $jumlah_barang): void;

    function exportExcel(): void;
}

class BarangRepositoryImpl implements BarangRepository
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(Barang $barang): void
    {
        try {
            $this->connection->beginTransaction();
            $sql = "INSERT INTO 
                barang(
                    id_barang,
                    nama_barang, 
                    harga_satuan, 
                    satuan_barang,
                    sisa_barang
                ) 
                VALUES (?, ?, ?, ?, ?)";
            $statement = $this->connection->prepare($sql);

            $statement->execute([
                $barang->getIdBarang(),
                $barang->getNamaBarang(),
                $barang->getHargaSatuan(),
                $barang->getSatuanBarang(),
                $barang->getSisaBarang()
            ]);
            $statement->closeCursor();
            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            die($e->getMessage());
        }
    }

    public function remove(string $idBarang): void
    {
        $sql = "DELETE FROM barang WHERE id_barang = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$idBarang]);
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM barang";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $result = [];

        foreach ($statement as $row) {
            $barang = new Barang();
            $barang->setIdBarang($row['id_barang']);
            $barang->setNamaBarang($row['nama_barang']);
            $barang->setHargaSatuan($row['harga_satuan']);
            $barang->setSatuanBarang($row['satuan_barang']);
            $barang->setSisaBarang($row['sisa_barang']);

            $result[] = $barang;
        }
        return $result;
    }

    public function check(string $idBarang): bool
    {
        $sql = "SELECT id_barang FROM barang WHERE id_barang = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$idBarang]);

        if ($statement->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public function find(string $idBarang): Barang
    {
        $sql = "SELECT * FROM barang WHERE id_barang = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$idBarang]);
        $barang = new Barang();

        foreach ($statement as $row) {
            $barang->setIdBarang($row['id_barang']);
            $barang->setNamaBarang($row['nama_barang']);
            $barang->setHargaSatuan($row['harga_satuan']);
            $barang->setSatuanBarang($row['satuan_barang']);
            $barang->setSisaBarang($row['sisa_barang']);
        }
        return $barang;
    }

    public function updateNama(string $idBarang, string $valueBaru): void
    {
        $sql = "UPDATE barang SET nama_barang = ? WHERE id_barang = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$valueBaru, $idBarang]);
    }

    public function updateHarga(string $idBarang, string $valueBaru): void
    {
        $sql = "UPDATE barang SET harga_satuan = ? WHERE id_barang = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$valueBaru, $idBarang]);
    }

    public function updateSatuan(string $idBarang, string $valueBaru): void
    {
        $sql = "UPDATE barang SET satuan_barang = ? WHERE id_barang = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$valueBaru, $idBarang]);
    }

    public function checkSisaBarang(string $idBarang): float
    {
        try {
            $sql = 'SELECT sisa_barang FROM barang WHERE id_barang = ?';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$idBarang]);
            $sisaTersedia = (float) $stmt->fetchColumn();
            return $sisaTersedia;
        } catch (PDOException $e) {
            throw $e->getMessage();
            return 0;
        }
    }

    public function transactionKeluar(
        string $idBarang,
        float $jumlah_barang
    ): void {
        try {
            $this->connection->beginTransaction();

            $barang = $this->find($idBarang);

            $sql_update_barang =
                'UPDATE barang SET sisa_barang = sisa_barang - ? WHERE id_barang = ?';
            $statement = $this->connection->prepare($sql_update_barang);
            $statement->execute([$jumlah_barang, $idBarang]);
            $statement->closeCursor();

            $sql_create_transaction =
                'INSERT INTO transaksi(
                    id_barang,
                    nama_barang, 
                    transaksi_type,
                    satuan_barang, 
                    jumlah_barang)
                VALUES (?, ?, ?, ?, ?)';
            $statement = $this->connection->prepare($sql_create_transaction);
            $statement->execute([
                $barang->getIdBarang(),
                $barang->getNamaBarang(),
                'Keluar',
                $barang->getSatuanBarang(),
                $jumlah_barang
            ]);
            $statement->closeCursor();

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            die($e->getMessage());
        }
    }

    public function transactionMasuk(
        string $idBarang,
        float $jumlah_barang
    ): void {
        try {
            $this->connection->beginTransaction();

            $barang = $this->find($idBarang);

            $sql_update_barang =
                'UPDATE barang SET sisa_barang = sisa_barang + ? WHERE id_barang = ?';
            $statement = $this->connection->prepare($sql_update_barang);
            $statement->execute([$jumlah_barang, $idBarang]);
            $statement->closeCursor();

            $sql_create_transaction =
                'INSERT INTO transaksi(
                    id_barang,
                    nama_barang, 
                    transaksi_type,
                    satuan_barang, 
                    jumlah_barang)
                VALUES (?, ?, ?, ?, ?)';
            $statement = $this->connection->prepare($sql_create_transaction);
            $statement->execute([
                $barang->getIdBarang(),
                $barang->getNamaBarang(),
                'Masuk',
                $barang->getSatuanBarang(),
                $jumlah_barang
            ]);
            $statement->closeCursor();

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            die($e->getMessage());
        }
    }

    public function exportExcel(): void
    {
        // Create Spreadsheet + worksheet
        $spreadsheet  = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Daftar Barang");

        // Fetch data + write to spreadsheet
        $sql = "SELECT * FROM barang";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $i = 2;
        $sheet->setCellValue('A1', "Id Barang");
        $sheet->setCellValue('B1', "Nama Barang");
        $sheet->setCellValue('C1', "Harga Satuan");
        $sheet->setCellValue('D1', "Satuan Barang");
        $sheet->setCellValue('E1', "Sisa Barang");
        while ($row = $statement->fetch()) {
            $sheet->setCellValue('A'.$i, $row['id_barang']);
            $sheet->setCellValue('B'.$i, $row['nama_barang']);
            $sheet->setCellValue('C'.$i, $row['harga_satuan']);
            $sheet->setCellValue('D'.$i, $row['satuan_barang']);
            $sheet->setCellValue('E'.$i, $row['sisa_barang']);
            $i++;
        }

        // Save File
        $writer = new Xlsx($spreadsheet);
        $writer->save("test.xlsx");
    }

    public function __destruct()
    {
        $this->connection = null;
    }
}
