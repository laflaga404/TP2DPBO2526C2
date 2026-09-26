<?php

require_once 'Member.php';

/**
 * Level 3 (Cucu dari Pelanggan, Anak dari Member)
 * Member kelas atas: dapet voucher, limit transaksi bulanan,
 * dan prioritas layanan (booking/CS didahulukan).
 * Mewarisi semua atribut Pelanggan + Member.
 */
class MemberPremium extends Member {
    private $kodeVoucher;
    private $limitTransaksi;
    private $prioritySupport;

    public function __construct($idPelanggan, $nama, $email, $noTelepon,
                                 $noKartuMember, $poin, $tanggalGabung,
                                 $kodeVoucher, $limitTransaksi, $prioritySupport) {
        parent::__construct($idPelanggan, $nama, $email, $noTelepon,
                             $noKartuMember, $poin, $tanggalGabung);
        $this->kodeVoucher = (string) $kodeVoucher;
        $this->limitTransaksi = (float) $limitTransaksi;
        $this->prioritySupport = (bool) $prioritySupport;
    }

    // ---- Getter tambahan ----
    public function getKodeVoucher() { return $this->kodeVoucher; }
    public function getLimitTransaksi() { return $this->limitTransaksi; }
    public function getPrioritySupport() { return $this->prioritySupport; }

    // ---- Setter tambahan ----
    public function setKodeVoucher($kodeVoucher) { $this->kodeVoucher = (string) $kodeVoucher; }
    public function setLimitTransaksi($limitTransaksi) { $this->limitTransaksi = (float) $limitTransaksi; }

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
        $row[8] = $this->kodeVoucher;
        $row[9] = number_format($this->limitTransaksi, 0, '.', ',');
        $row[10] = $this->prioritySupport ? "Ya" : "Tidak";
        return $row;
    }
}
