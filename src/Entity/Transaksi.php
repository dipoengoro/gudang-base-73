<?php

namespace Dipoengoro\GudangBase\Entity;

class Tansaksi
{
    private $id_transaksi;
    private $id_barang;
    private $nama_barang;
    private $transaksi_type;
    private $satuan_barang;
    private $jumlah_barang;
    private $tanggal_transaksi;

    public function __construct(
        int $id_transaksi,
        string $id_barang,
        string $nama_barang,
        string $transaksi_type,
        string $satuan_barang,
        float $jumlah_barang,
        string $tanggal_transaksi
    ) {
        $this->id_transaksi = $id_transaksi;
        $this->id_barang = $id_barang;
        $this->nama_barang = $nama_barang;
        $this->transaksi_type = $transaksi_type;
        $this->satuan_barang = $satuan_barang;
        $this->jumlah_barang = $jumlah_barang;
        $this->tanggal_transaksi = $tanggal_transaksi;
    }

    

    /**
     * Get the value of id_transaksi
     */ 
    public function getId_transaksi()
    {
        return $this->id_transaksi;
    }

    /**
     * Set the value of id_transaksi
     *
     * @return  self
     */ 
    public function setId_transaksi($id_transaksi)
    {
        $this->id_transaksi = $id_transaksi;

        return $this;
    }

    /**
     * Get the value of id_barang
     */ 
    public function getId_barang()
    {
        return $this->id_barang;
    }

    /**
     * Set the value of id_barang
     *
     * @return  self
     */ 
    public function setId_barang($id_barang)
    {
        $this->id_barang = $id_barang;

        return $this;
    }

    /**
     * Get the value of nama_barang
     */ 
    public function getNama_barang()
    {
        return $this->nama_barang;
    }

    /**
     * Set the value of nama_barang
     *
     * @return  self
     */ 
    public function setNama_barang($nama_barang)
    {
        $this->nama_barang = $nama_barang;

        return $this;
    }

    /**
     * Get the value of transaksi_type
     */ 
    public function getTransaksi_type()
    {
        return $this->transaksi_type;
    }

    /**
     * Set the value of transaksi_type
     *
     * @return  self
     */ 
    public function setTransaksi_type($transaksi_type)
    {
        $this->transaksi_type = $transaksi_type;

        return $this;
    }

    /**
     * Get the value of satuan_barang
     */ 
    public function getSatuan_barang()
    {
        return $this->satuan_barang;
    }

    /**
     * Set the value of satuan_barang
     *
     * @return  self
     */ 
    public function setSatuan_barang($satuan_barang)
    {
        $this->satuan_barang = $satuan_barang;

        return $this;
    }

    /**
     * Get the value of jumlah_barang
     */ 
    public function getJumlah_barang()
    {
        return $this->jumlah_barang;
    }

    /**
     * Set the value of jumlah_barang
     *
     * @return  self
     */ 
    public function setJumlah_barang($jumlah_barang)
    {
        $this->jumlah_barang = $jumlah_barang;

        return $this;
    }

    /**
     * Get the value of tanggal_transaksi
     */ 
    public function getTanggal_transaksi()
    {
        return $this->tanggal_transaksi;
    }

    /**
     * Set the value of tanggal_transaksi
     *
     * @return  self
     */ 
    public function setTanggal_transaksi($tanggal_transaksi)
    {
        $this->tanggal_transaksi = $tanggal_transaksi;

        return $this;
    }
}
