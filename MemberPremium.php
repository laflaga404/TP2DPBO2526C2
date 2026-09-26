<?php

require_once 'Member.php';

/**
 * Level 3 (Cucu dari Pelanggan, Anak dari Member)
 * Member kelas atas: dapet voucher, diskon transaksi, dan
 * free upgrade seat (nonton bisa naik kelas kursi gratis).
 * Mewarisi semua atribut Pelanggan + Member.
 */
class MemberPremium extends Member {
    private $kodeVoucher;
    private $diskon;
    private $freeUpgradeSeat;

    public function __construct($idPelanggan, $nama, $email, $noTelepon,
                                 $noKartuMember, $poin, $tanggalGabung, $benefit,
                                 $kodeVoucher, $diskon, $freeUpgradeSeat) {
        parent::__construct($idPelanggan, $nama, $email, $noTelepon,
                             $noKartuMember, $poin, $tanggalGabung, $benefit);
        $this->kodeVoucher = (string) $kodeVoucher;
        $this->diskon = (float) $diskon;
        $this->freeUpgradeSeat = (bool) $freeUpgradeSeat;
        $this->foto = "MemberPremium.png";
    }

    // ---- Getter tambahan ----
    public function getKodeVoucher() { return $this->kodeVoucher; }
    public function getDiskon() { return $this->diskon; }
    public function getFreeUpgradeSeat() { return $this->freeUpgradeSeat; }

    // ---- Setter tambahan ----
    public function setKodeVoucher($kodeVoucher) { $this->kodeVoucher = (string) $kodeVoucher; }
    public function setDiskon($diskon) { $this->diskon = (float) $diskon; }
    public function setFreeUpgradeSeat($freeUpgradeSeat) { $this->freeUpgradeSeat = (bool) $freeUpgradeSeat; }

    // ---- Method tambahan khusus MemberPremium ----
    public function gunakanVoucher() {
        return "Voucher " . $this->kodeVoucher . " berhasil dipakai!";
    }

    // ---- Override method ----
    public function getTipe() {
        return "Member Premium";
    }

    public function toRow() {
        $row = parent::toRow();
        $row[4] = $this->getTipe();
        // $row[5] (Foto) sudah otomatis "MemberPremium.png" lewat $this->foto
        $row[10] = $this->kodeVoucher;
        $row[11] = number_format($this->diskon, 2, '.', '');
        $row[12] = $this->freeUpgradeSeat ? "Yes" : "No";
        return $row;
    }
}
