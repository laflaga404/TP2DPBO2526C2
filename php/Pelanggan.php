<?php

/**
 * Level 1 (Parent paling atas)
 * Pelanggan biasa / non-member bioskop Tel Aviv XXI.
 * Cuma modal nama & kontak, belum punya kartu member.
 */
class Pelanggan {
    protected $idPelanggan;
    protected $nama;
    protected $email;
    protected $noTelepon;
    protected $foto;

    public function __construct($idPelanggan, $nama, $email, $noTelepon) {
        $this->idPelanggan = (int) $idPelanggan;
        $this->nama = (string) $nama;
        $this->email = (string) $email;
        $this->noTelepon = (string) $noTelepon;
        $this->foto = "Pelanggan.png";
    }

    // ---- Getter ----
    public function getId() { return $this->idPelanggan; }
    public function getNama() { return $this->nama; }
    public function getEmail() { return $this->email; }
    public function getNoTelepon() { return $this->noTelepon; }
    public function getFoto() { return $this->foto; }

    // ---- Setter ----
    public function setNama($nama) { $this->nama = (string) $nama; }
    public function setEmail($email) { $this->email = (string) $email; }
    public function setNoTelepon($noTelepon) { $this->noTelepon = (string) $noTelepon; }
    public function setFoto($foto) { $this->foto = (string) $foto; }

    // ---- Method polymorphic (bakal di-override di anak & cucu) ----
    public function getTipe() {
        return "Non-Member";
    }

    // Ubah data jadi 1 baris tabel dengan urutan kolom yang SAMA
    // buat semua tingkatan (Pelanggan, Member, MemberPremium).
    // Kolom yang gak dimiliki level ini otomatis diisi strip "-".
    public function toRow() {
        return [
            (string) $this->idPelanggan,
            $this->nama,
            $this->email,
            $this->noTelepon,
            $this->getTipe(),
            $this->foto,
            "-", // No Kartu Member
            "-", // Poin
            "-", // Tanggal Gabung
            "-", // Benefit
            "-", // Kode Voucher
            "-", // Diskon
            "-", // Free Upgrade Seat
        ];
    }
}
