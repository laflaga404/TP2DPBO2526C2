#pragma once
#include <string>
#include <vector>
using namespace std;

// Level 1 (Parent paling atas)
// Pelanggan biasa / non-member bioskop Tel Aviv XXI.
// Cuma modal nama & kontak, belum punya kartu member.
class Pelanggan {
protected:
    int idPelanggan;
    string nama;
    string email;
    string noTelepon;

public:
    Pelanggan(int idPelanggan, string nama, string email, string noTelepon) {
        this->idPelanggan = idPelanggan;
        this->nama = nama;
        this->email = email;
        this->noTelepon = noTelepon;
    }

    virtual ~Pelanggan() {}

    // ---- Getter ----
    int getId() { return idPelanggan; }
    string getNama() { return nama; }
    string getEmail() { return email; }
    string getNoTelepon() { return noTelepon; }

    // ---- Setter ----
    void setNama(string nama) { this->nama = nama; }
    void setEmail(string email) { this->email = email; }
    void setNoTelepon(string noTelepon) { this->noTelepon = noTelepon; }

    // ---- Method polymorphic (bakal di-override di anak & cucu) ----
    virtual string getTipe() {
        return "Non-Member";
    }

    // Ubah data jadi 1 baris tabel dengan urutan kolom yang SAMA
    // buat semua tingkatan (Pelanggan, Member, MemberPremium).
    // Kolom yang gak dimiliki level ini otomatis diisi strip "-".
    virtual vector<string> toRow() {
        return {
            to_string(idPelanggan),
            nama,
            email,
            noTelepon,
            getTipe(),
            "-", // No Kartu Member
            "-", // Poin
            "-", // Tanggal Gabung
            "-", // Benefit
            "-", // Kode Voucher
            "-", // Diskon
            "-"  // Free Upgrade Seat
        };
    }
};
