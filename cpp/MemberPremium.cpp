#pragma once
#include "Member.cpp"
#include <sstream>
#include <iomanip>

// Level 3 (Cucu dari Pelanggan, Anak dari Member)
// Member kelas atas: dapet voucher, limit transaksi bulanan,
// dan prioritas layanan (booking/CS didahulukan).
// Mewarisi semua atribut Pelanggan + Member.
class MemberPremium : public Member {
private:
    string kodeVoucher;
    double limitTransaksi;
    bool prioritySupport;

public:
    MemberPremium(int idPelanggan, string nama, string email, string noTelepon,
                  string noKartuMember, int poin, string tanggalGabung,
                  string kodeVoucher, double limitTransaksi, bool prioritySupport)
        : Member(idPelanggan, nama, email, noTelepon, noKartuMember, poin, tanggalGabung) {
        this->kodeVoucher = kodeVoucher;
        this->limitTransaksi = limitTransaksi;
        this->prioritySupport = prioritySupport;
    }

    // ---- Getter tambahan ----
    string getKodeVoucher() { return kodeVoucher; }
    double getLimitTransaksi() { return limitTransaksi; }
    bool getPrioritySupport() { return prioritySupport; }

    // ---- Setter tambahan ----
    void setKodeVoucher(string kodeVoucher) { this->kodeVoucher = kodeVoucher; }
    void setLimitTransaksi(double limitTransaksi) { this->limitTransaksi = limitTransaksi; }

    // ---- Method tambahan khusus MemberPremium ----
    string gunakanVoucher() {
        return "Voucher " + kodeVoucher + " berhasil dipakai!";
    }

    // ---- Override method ----
    string getTipe() override {
        return "Member Premium";
    }

    vector<string> toRow() override {
        vector<string> row = Member::toRow();
        row[4] = getTipe();
        row[8] = kodeVoucher;
        row[9] = formatRibuan(limitTransaksi);
        row[10] = prioritySupport ? "Ya" : "Tidak";
        return row;
    }
};
