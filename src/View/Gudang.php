<?php

namespace Dipoengoro\GudangBase\View;

use Dipoengoro\GudangBase\Service\BarangService;
use Dipoengoro\GudangBase\Util\Input;
use Dipoengoro\GudangBase\Util\Validation;
use Exception;

class GudangView
{
    private $barangService;
    private $validation;

    function __construct(BarangService $barangService, Validation $validation)
    {
        $this->barangService = $barangService;
        $this->validation = $validation;
    }

    function showBarang(): void
    {
        while (true) {
            $this->barangService->showBarang();

            Input::titleBanner("Menu");
            Input::banner("1. Tambah Barang");
            Input::banner("2. Edit Barang");
            Input::banner("3. Transaksi");
            Input::banner("4. Hapus Barang");
            Input::banner("5. Export Data");
            Input::banner("x. Keluar");

            $pilihan = Input::inputMenu("Pilih");
            if ($pilihan == "1") {
                $this->addBarang();
            } elseif ($pilihan == "2") {
                $this->updateBarang();
            } else if ($pilihan == "3") {
                $this->transaksi();
            } elseif ($pilihan == "4") {
                $this->removeBarang();
            } else if ($pilihan == "5") {
                $this->exportExcel();
            } else if ($pilihan == "x") {
                Input::exit();
            } else {
                Input::banner("Pilihan tidak dimengerti");
            }
        }
        Input::banner("Sampai jumpa lagi");
    }

    function addBarang(): void
    {
        $success = true;

        Input::titleBanner("Tambah Barang");
        $idBarang = strtoupper(Input::inputData("Kode Barang"));
        $namaBarang = Input::inputData("Nama Barang");
        $hargaSatuan = Input::inputData("Harga (Rupiah)");
        $satuanBarang = Input::inputData("Satuan Barang");

        try {
            $this->validation->validateHarga($hargaSatuan);
        } catch (Exception $e) {
            Input::banner($e->getMessage());
            $success = false;
        }

        if ($success) {
            Input::titleBanner("Konfirmasi");
            Input::banner("Kode Barang: $idBarang");
            Input::banner("Nama Barang: $namaBarang");
            Input::banner("Harga (Rupiah): $hargaSatuan");
            Input::banner("Satuan Barang: $satuanBarang");
        }

        while ($success) {
            $pilihan = Input::inputMenu("Jika sesuai ketik 'y', jika ingin batalkan ketik 'x'");
            if ($pilihan == "x") {
                Input::banner("Membatalkan penambahan barang");
                break;
            } else if ($pilihan == "y") {
                $this->barangService->addBarang(
                    $idBarang,
                    $namaBarang,
                    $hargaSatuan,
                    $satuanBarang
                );
                break;
            }
        }
    }

    function removeBarang(): void
    {
        $success = true;
        Input::titleBanner("Hapus Barang");
        $idBarang = Input::inputData("Kode Barang");

        if ($this->barangService->checkBarang($idBarang)) {
            Input::titleBanner("Konfirmasi");
            Input::barang($this->barangService->findBarang($idBarang));
        } else {
            Input::banner("Kode barang tidak ditemukan");
            $success = false;
        }
        while ($success) {
            $pilihan = Input::inputMenu("Jika sesuai ketik 'y', jika ingin batalkan ketik 'x'");
            if ($pilihan == "x") {
                Input::banner("Membatalkan penghapusan barang");
                break;
            } else if ($pilihan == "y") {
                $this->barangService->removeBarang($idBarang);
                break;
            }
        }
    }

    function updateBarang(): void
    {
        $success = true;
        Input::titleBanner("Edit Barang");
        $idBarang = Input::inputData("Kode Barang");
        if ($this->barangService->checkBarang($idBarang)) {
            $barang = $this->barangService->findBarang($idBarang);
            Input::banner("Sekarang");
            Input::barang($barang);
            Input::banner("Edit");
            $namaBaru = Input::inputData("Nama Barang");
            $hargaBaru = Input::inputData("Harga (Rupiah)");
            $satuanBaru = Input::inputData("Satuan Barang");

            if ($hargaBaru != "") {
                try {
                    $this->validation->validateHarga($hargaBaru);
                } catch (Exception $e) {
                    Input::banner($e->getMessage());
                    $success = false;
                }
            }

            if ($success) {
                Input::titleBanner("Konfirmasi");
                Input::banner("Sekarang");
                Input::barang($barang);
                Input::banner("Baru");

                if ($namaBaru != "") {
                    $barang->setNamaBarang($namaBaru);
                }
                if ($hargaBaru != "") {
                    $barang->setHargaSatuan((int) $hargaBaru);
                }
                if ($satuanBaru != "") {
                    $barang->setSatuanBarang($satuanBaru);
                }
                Input::barang($barang);
            }
        } else {
            Input::banner("Kode barang tidak ditemukan");
            $success = false;
        }

        while ($success) {
            $pilihan = Input::inputMenu("Jika sesuai ketik 'y', jika ingin batalkan ketik 'x'");
            if ($pilihan == "x") {
                Input::banner("Membatalkan update barang");
                break;
            } else if ($pilihan == "y") {
                $this->barangService->updateBarang(
                    $idBarang,
                    $barang->getNamaBarang(),
                    $barang->getHargaSatuan(),
                    $barang->getSatuanBarang()
                );
                break;
            }
        }
    }

    function transaksi(): void
    {
        $success = true;
        Input::titleBanner("Transaksi");
        $idBarang = Input::inputData("Kode Barang");
        $barang = $this->barangService->findBarang($idBarang);
        Input::banner("Sekarang");
        Input::barang($barang);
        Input::banner("Transaksi");
        $sisaBarang = $barang->getSisaBarang();
        $jumlahBarang = Input::inputData("Jumlah Barang");

        Input::titleBanner("Konfirmasi");
        Input::banner("Sekarang");
        Input::barang($barang);
        Input::banner("Baru");
        if ($jumlahBarang >= 0) {
            $barang->setSisaBarang((float) $sisaBarang + $jumlahBarang);
            Input::barang($barang);
        } else if ($jumlahBarang < 0) {
            $jumlahBarangPositif = $jumlahBarang * -1;
            if ($sisaBarang < $jumlahBarangPositif) {
                Input::banner("Sisa barang tidak cukup");
                $success = false;
            } else {
                $barang->setSisaBarang((float) $sisaBarang - $jumlahBarangPositif);
                Input::barang($barang);
            }
        }

        while ($success) {
            $pilihan = Input::inputMenu("Jika sesuai ketik 'y', jika ingin batalkan ketik 'x'");
            if ($pilihan == "x") {
                Input::banner("Membatalkan update barang");
                break;
            } else if ($pilihan == "y") {
                $this->barangService->transaksi($idBarang, $jumlahBarang);
                break;
            }
        }
    }

    function exportExcel(): void 
    {
        while (true) {
            Input::titleBanner("Export Data");
            Input::banner("1. Daftar Barang");
            Input::banner("2. Daftar Transaksi");
            Input::banner("x. Kembali");

            $pilihan = Input::inputMenu("Pilih");
            if ($pilihan == "1") {
                $this->barangService->exportToExcel(null, null);
                Input::banner("Berhasil Export");
            } elseif ($pilihan == "2") {
                $this->exportTransaksi();
                Input::banner("Memilih Daftar Transaksi");
            } else if ($pilihan == "x") {
                break;
            } else {
                Input::banner("Pilihan tidak dimengerti");
            }
        }
    }

    function exportTransaksi(): void 
    {   date_default_timezone_set("Asia/Jakarta");
        Input::titleBanner("Export Daftar Transaksi");
        Input::banner("Dari");
        $dariTahun = Input::inputData("Tahun");
        $dariBulan = Input::inputData("Bulan");
        $dariTanggal = Input::inputData("Tanggal");
        Input::banner("Sampai");
        $sampaiTahun = Input::inputData("Tahun");
        $sampaiBulan = Input::inputData("Bulan");
        $sampaiTanggal = Input::inputData("Tanggal");

        $currentDate = date('Y-m-d');
        
        if ($dariTahun == "") {
            $dariTahun = substr($currentDate, 0, 4);
        }
        if ($dariBulan == "") {
            $dariBulan = substr($currentDate, 5, 2);
        }
        if ($dariTanggal == "") {
            $dariTanggal = '01';
        }
        if ($sampaiTahun == "") {
            $sampaiTahun = substr($currentDate, 0, 4);
        }
        if ($sampaiBulan == "") {
            $sampaiBulan = substr($currentDate, 5, 2);
        }
        if ($sampaiTanggal == "") {
            $sampaiTanggal = substr($currentDate, 8, 2);
        }

        $from = "$dariTahun-$dariBulan-$dariTanggal";
        $to = "$sampaiTahun-$sampaiBulan-$sampaiTanggal";

        Input::titleBanner("Konfirmasi");
        Input::banner("dari $from sampai $to");

        while (true) {
            $pilihan = Input::inputMenu("Jika sesuai ketik 'y', jika ingin batalkan ketik 'x'");
            if ($pilihan == "x") {
                Input::banner("Membatalkan update barang");
                break;
            } else if ($pilihan == "y") {
                $this->barangService->exportToExcel($from, $to);
                break;
            }
        }
    }
}
