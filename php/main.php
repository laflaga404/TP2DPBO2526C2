<?php

require_once 'MemberPremium.php';

// Catatan: sesuai ketentuan tugas, khusus PHP boleh hardcode ATAU interaktif.
// Versi ini dibuat INTERAKTIF lewat CLI (php main.php) supaya alurnya
// konsisten dan bisa dites pakai testcase.txt yang sama kayak Python/Java/C++.
// Jalankan dengan: php main.php < testcase.txt

// LIST OF OBJECT (nyimpen SEMUA tingkatan: Pelanggan, Member, MemberPremium)
$daftarPelanggan = [];

$HEADER = [
    "ID", "Nama", "Email", "No Telepon", "Tipe",
    "No Kartu Member", "Poin", "Tgl Gabung",
    "Kode Voucher", "Limit Transaksi", "Priority"
];

// Helper baca 1 baris dari STDIN (trim newline)
function bacaInput($pesan) {
    echo $pesan;
    $baris = fgets(STDIN);
    if ($baris === false) {
        return "";
    }
    return trim($baris);
}

// ERROR handling biar ID, poin, limit itu integer
function inputInteger($pesan) {
    while (true) {
        $nilai = bacaInput($pesan);

        if (!ctype_digit($nilai) && !(substr($nilai, 0, 1) === '-' && ctype_digit(substr($nilai, 1)))) {
            echo "Input harus berupa angka hey!\n";
            continue;
        }

        $nilai = (int) $nilai;

        if ($nilai < 0) {
            echo "Input harus berupa angka 0 atau lebih!\n";
        } else {
            return $nilai;
        }
    }
}

// ISI 5 OBJEK AWAL SEBELUM ADA INPUT USER
function isiDataAwal(&$daftarPelanggan) {
    $daftarPelanggan[] = new Pelanggan(1, "Andi Saputra", "andi@gmail.com", "081234567890");
    $daftarPelanggan[] = new Pelanggan(2, "Budi Hartono", "budi@gmail.com", "081234567891");
    $daftarPelanggan[] = new Member(3, "Citra Dewi", "citra@gmail.com", "081234567892",
        "MBR-001", 150, "2024-01-10");
    $daftarPelanggan[] = new Member(4, "Dewi Lestari", "dewi@gmail.com", "081234567893",
        "MBR-002", 320, "2023-11-05");
    $daftarPelanggan[] = new MemberPremium(5, "Eka Wijaya", "eka@gmail.com", "081234567894",
        "MBR-003", 980, "2023-05-20",
        "VC-PREMIUM01", 2000000, true);
}

// TAMBAH DATA (satu-satunya operasi selain nampilin data)
function tambahData(&$daftarPelanggan) {
    echo "\n******** TAMBAH DATA PELANGGAN ********\n";
    echo "1. Non-Member\n";
    echo "2. Member\n";
    echo "3. Member Premium\n";
    $tipe = bacaInput("Pilih tipe pelanggan: ");

    if ($tipe !== "1" && $tipe !== "2" && $tipe !== "3") {
        echo "Tipe pelanggan tidak valid!\n";
        return;
    }

    $id = inputInteger("ID Pelanggan     : ");

    // Cek ID agar unik di seluruh daftar (lintas tipe)
    foreach ($daftarPelanggan as $p) {
        if ($p->getId() === $id) {
            echo "ID udah kepake itu!\n";
            return;
        }
    }

    $nama = bacaInput("Nama             : ");
    $email = bacaInput("Email            : ");
    $noTelepon = bacaInput("No Telepon       : ");

    if ($tipe === "1") {
        $pelangganBaru = new Pelanggan($id, $nama, $email, $noTelepon);

    } elseif ($tipe === "2") {
        $noKartu = bacaInput("No Kartu Member  : ");
        $poin = inputInteger("Poin             : ");
        $tanggalGabung = bacaInput("Tanggal Gabung   : ");

        $pelangganBaru = new Member($id, $nama, $email, $noTelepon,
            $noKartu, $poin, $tanggalGabung);

    } else {
        $noKartu = bacaInput("No Kartu Member    : ");
        $poin = inputInteger("Poin               : ");
        $tanggalGabung = bacaInput("Tanggal Gabung     : ");
        $kodeVoucher = bacaInput("Kode Voucher       : ");
        $limitTransaksi = inputInteger("Limit Transaksi    : ");
        $prioritasInput = bacaInput("Priority Support (y/n): ");
        $prioritySupport = (strtolower($prioritasInput) === "y");

        $pelangganBaru = new MemberPremium($id, $nama, $email, $noTelepon,
            $noKartu, $poin, $tanggalGabung,
            $kodeVoucher, $limitTransaksi, $prioritySupport);
    }

    $daftarPelanggan[] = $pelangganBaru;
    echo "Data pelanggan baru berhasil ditambahkan!\n";
}

// TAMPILKAN DATA (satu tabel dinamis buat SEMUA tingkatan)
function cetakTabel($daftarPelanggan, $HEADER) {
    echo "\n******** DAFTAR SELURUH PELANGGAN TEL AVIV XXI ********\n";

    if (empty($daftarPelanggan)) {
        echo "Belum ada data pelanggan.\n";
        return;
    }

    $rows = [];
    foreach ($daftarPelanggan as $p) {
        $rows[] = $p->toRow();
    }

    // Hitung lebar kolom otomatis (dinamis) berdasarkan isi terpanjang
    $lebar = [];
    foreach ($HEADER as $i => $h) {
        $lebar[$i] = strlen($h);
    }
    foreach ($rows as $row) {
        foreach ($row as $i => $val) {
            $lebar[$i] = max($lebar[$i], strlen((string) $val));
        }
    }

    $cetakGaris = function () use ($lebar) {
        $garis = "+";
        foreach ($lebar as $l) {
            $garis .= str_repeat("-", $l + 2) . "+";
        }
        echo $garis . "\n";
    };

    $cetakBaris = function ($vals) use ($lebar) {
        $baris = "|";
        foreach ($vals as $i => $v) {
            $baris .= " " . str_pad((string) $v, $lebar[$i]) . " |";
        }
        echo $baris . "\n";
    };

    $cetakGaris();
    $cetakBaris($HEADER);
    $cetakGaris();
    foreach ($rows as $row) {
        $cetakBaris($row);
    }
    $cetakGaris();
    echo "Total data: " . count($daftarPelanggan) . " pelanggan\n";
}

// MENU UTAMA
function menu() {
    global $daftarPelanggan, $HEADER;

    while (true) {
        echo "\n**************************************\n";
        echo "             Tel Aviv XXI\n";
        echo "     Sistem Keanggotaan Pelanggan\n";
        echo "**************************************\n";
        echo "1. Tambah Data Pelanggan\n";
        echo "2. Tampilkan Semua Data\n";
        echo "3. Keluar\n";
        echo "**************************************\n";

        $pilihan = bacaInput("Pilih menu: ");

        if ($pilihan === "1") {
            tambahData($daftarPelanggan);
        } elseif ($pilihan === "2") {
            cetakTabel($daftarPelanggan, $HEADER);
        } elseif ($pilihan === "3") {
            echo "See You Later!\n";
            break;
        } else {
            echo "Nuh uh! Gaada pilihannya woy!\n";
        }
    }
}

isiDataAwal($daftarPelanggan);
menu();
