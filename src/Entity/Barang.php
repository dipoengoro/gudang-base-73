<?php

namespace Dipoengoro\GudangBase\Entity;

class Barang
{
    private $idBarang;
    private $namaBarang;
    private $hargaSatuan;
    private $satuanBarang;
    private $sisaBarang;

    public function __construct(
        string $idBarang = "",
        string $namaBarang = "",
        int $hargaSatuan = 1,
        string $satuanBarang = "pcs",
        float $sisaBarang = 0
    ) {
        $this->idBarang = $idBarang;
        $this->namaBarang = $namaBarang;
        $this->hargaSatuan = $hargaSatuan;
        $this->satuanBarang = $satuanBarang;
        $this->sisaBarang = $sisaBarang;
    }



    /**
     * Get the value of idBarang
     */
    public function getIdBarang()
    {
        return $this->idBarang;
    }

    /**
     * Set the value of idBarang
     *
     * @return  self
     */
    public function setIdBarang($idBarang)
    {
        $this->idBarang = $idBarang;

        return $this;
    }

    /**
     * Get the value of namaBarang
     */
    public function getNamaBarang()
    {
        return $this->namaBarang;
    }

    /**
     * Set the value of namaBarang
     *
     * @return  self
     */
    public function setNamaBarang($namaBarang)
    {
        $this->namaBarang = $namaBarang;

        return $this;
    }

    /**
     * Get the value of satuanBarang
     */
    public function getSatuanBarang()
    {
        return $this->satuanBarang;
    }

    /**
     * Set the value of satuanBarang
     *
     * @return  self
     */
    public function setSatuanBarang($satuanBarang)
    {
        $this->satuanBarang = $satuanBarang;

        return $this;
    }

    /**
     * Get the value of sisaBarang
     */
    public function getSisaBarang()
    {
        return $this->sisaBarang;
    }

    /**
     * Set the value of sisaBarang
     *
     * @return  self
     */
    public function setSisaBarang($sisaBarang)
    {
        $this->sisaBarang = $sisaBarang;

        return $this;
    }

    /**
     * Get the value of hargaSatuan
     */
    public function getHargaSatuan()
    {
        return $this->hargaSatuan;
    }

    /**
     * Set the value of hargaSatuan
     *
     * @return  self
     */
    public function setHargaSatuan($hargaSatuan)
    {
        $this->hargaSatuan = $hargaSatuan;

        return $this;
    }
}
