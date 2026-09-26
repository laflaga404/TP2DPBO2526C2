#pragma once
#include "Pelanggan.cpp"

// Level 2 (Anak dari Pelanggan)
// Pelanggan yang udah daftar jadi member, dapet kartu member & poin
// tiap nonton. Mewarisi semua atribut Pelanggan.
class Member : public Pelanggan {
protected:
    string noKartuMember;
    int poin;
    string tanggalGabung;

public:
    Member(int idPelanggan, string nama, string email, string noTelepon,
           string noKartuMember, int poin, string tanggalGabung)
        : Pelanggan(idPelanggan, nama, email, noTelepon) {
        this->noKartuMember = noKartuMember;
        this->poin = poin;
        this->tanggalGabung = tanggalGabung;
    }

    // ---- Getter tambahan ----
    string getNoKartuMember() { return noKartuMember; }
    int getPoin() { return poin; }
    string getTanggalGabung() { return tanggalGabung; }

    // ---- Setter tambahan ----
    void setPoin(int poin) { this->poin = poin; }
    void setTanggalGabung(string tanggalGabung) { this->tanggalGabung = tanggalGabung; }

    // ---- Method tambahan khusus Member ----
    void tambahPoin(int jumlah) { poin += jumlah; }

    // ---- Override method dari Pelanggan ----
    string getTipe() override {
        return "Member";
    }

    vector<string> toRow() override {
        vector<string> row = Pelanggan::toRow();
        row[4] = getTipe();
        row[5] = noKartuMember;
        row[6] = to_string(poin);
        row[7] = tanggalGabung;
        return row;
    }
};
