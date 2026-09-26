<?php

require_once 'Pelanggan.php';

/**
 * Level 2 (Anak dari Pelanggan)
 * Pelanggan yang udah daftar jadi member, dapet kartu member & poin
 * tiap nonton. Mewarisi semua atribut Pelanggan.
 */
class Member extends Pelanggan {
    protected $noKartuMember;
    protected $poin;
    protected $tanggalGabung;
    protected $benefit;

    public function __construct($idPelanggan, $nama, $email, $noTelepon,
                                 $noKartuMember, $poin, $tanggalGabung, $benefit) {
        parent::__construct($idPelanggan, $nama, $email, $noTelepon);
        $this->noKartuMember = (string) $noKartuMember;
        $this->poin = (int) $poin;
        $this->tanggalGabung = (string) $tanggalGabung;
        $this->benefit = (string) $benefit;
    }

    // ---- Getter tambahan ----
    public function getNoKartuMember() { return $this->noKartuMember; }
    public function getPoin() { return $this->poin; }
    public function getTanggalGabung() { return $this->tanggalGabung; }
    public function getBenefit() { return $this->benefit; }

    // ---- Setter tambahan ----
    public function setPoin($poin) { $this->poin = (int) $poin; }
    public function setTanggalGabung($tanggalGabung) { $this->tanggalGabung = (string) $tanggalGabung; }
    public function setBenefit($benefit) { $this->benefit = (string) $benefit; }

    // ---- Method tambahan khusus Member ----
    public function tambahPoin($jumlah) {
        $this->poin += (int) $jumlah;
    }

    // ---- Override method dari Pelanggan ----
    public function getTipe() {
        return "Member";
    }

    public function toRow() {
        $row = parent::toRow();
        $row[4] = $this->getTipe();
        $row[5] = $this->noKartuMember;
        $row[6] = (string) $this->poin;
        $row[7] = $this->tanggalGabung;
        $row[8] = $this->benefit;
        return $row;
    }
}
