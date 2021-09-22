<?php

namespace Dipoengoro\GudangBase\Service;

use Dipoengoro\GudangBase\Entity\Barang;
use Dipoengoro\GudangBase\Repository\BarangRepository;
use Dipoengoro\GudangBase\Util\Input;

interface BarangService
{
    function showBarang(): void;
    function addBarang(
        string $idBarang,
        string $namaBarang,
        int $hargaSatuan,
        string $satuanBarang
    ): void;
    function removeBarang(string $idBarang): void;
    function findBarang(string $idBarang): Barang;
    function checkBarang(string $idBarang): bool;
    function updateBarang(
        string $idBarang,
        string $namaBaru,
        string $hargaBaru,
        string $satuanBaru
    ): void;
    function transaksi(string $idBarang, float $jumlah_barang): void;
    function exportToExcel(): void;
}

class BarangServiceImpl implements BarangService
{
    private $barangRepository;

    public function __construct(BarangRepository $barangRepository)
    {
        $this->barangRepository = $barangRepository;
    }

    function showBarang(): void
    {
        Input::titleBanner("Daftar Barang");
        $barangs = $this->barangRepository->findAll();
        foreach ($barangs as $barang) {
            Input::banner($barang->getIdBarang() . " | " . $barang->getNamaBarang() . " | " .
                $barang->getHargaSatuan() . " | " . $barang->getSatuanBarang() . " | " .
                $barang->getSisaBarang());
        }
    }

    function addBarang(
        string $idBarang,
        string $namaBarang,
        int $hargaSatuan,
        string $satuanBarang
    ): void {
        $validateId = (string) $idBarang;
        $validateNama = (string) $namaBarang;
        $validateHarga = (int) $hargaSatuan;
        $validateSatuan = (string) $satuanBarang;

        $barang = new Barang(
            $validateId,
            $validateNama,
            $validateHarga,
            $validateSatuan
        );
        $this->barangRepository->add($barang);

        Input::banner("Berhasil menambahkan $namaBarang");
    }

    function removeBarang(string $idBarang): void
    {
        $this->barangRepository->remove($idBarang);
        Input::banner("Sukses menghapus barang dengan Kode Barang: $idBarang");
    }

    function findBarang(string $idBarang): Barang
    {
        $barang = $this->barangRepository->find($idBarang);
        return $barang;
    }

    function updateBarang(
        string $idBarang,
        string $namaBaru,
        string $hargaBaru,
        string $satuanBaru
    ): void {
        $this->barangRepository->updateNama($idBarang, $namaBaru);
        $this->barangRepository->updateHarga($idBarang, $hargaBaru);
        $this->barangRepository->updateSatuan($idBarang, $satuanBaru);
    }

    function checkBarang(string $idBarang): bool
    {
        return $this->barangRepository->check($idBarang);
    }

    function transaksi(string $idBarang, float $jumlah_barang): void
    {
        if ($jumlah_barang >= 0) {
            $this->barangRepository->transactionMasuk($idBarang, $jumlah_barang);
        } else {
            $jumlah_barang_positif = $jumlah_barang * -1;
            $this->barangRepository->transactionKeluar($idBarang, $jumlah_barang_positif);
        }
    }

    function exportToExcel(): void
    {
        $this->barangRepository->exportExcel();
    }
}
