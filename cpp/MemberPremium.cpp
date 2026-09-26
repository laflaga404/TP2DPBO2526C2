#pragma once
#include "Member.cpp"
#include <sstream>
#include <iomanip>

// Level 3 (Cucu dari Pelanggan, Anak dari Member)
// Member kelas atas: dapet voucher, diskon transaksi, dan
// free upgrade seat (nonton bisa naik kelas kursi gratis).
// Mewarisi semua atribut Pelanggan + Member.
class MemberPremium : public Member {
private:
    string kodeVoucher;
    double diskon;
    bool freeUpgradeSeat;

public:
    MemberPremium(int idPelanggan, string nama, string email, string noTelepon,
                  string noKartuMember, int poin, string tanggalGabung, string benefit,
                  string kodeVoucher, double diskon, bool freeUpgradeSeat)
        : Member(idPelanggan, nama, email, noTelepon, noKartuMember, poin, tanggalGabung, benefit) {
        this->kodeVoucher = kodeVoucher;
        this->diskon = diskon;
        this->freeUpgradeSeat = freeUpgradeSeat;
    }

    // ---- Getter tambahan ----
    string getKodeVoucher() { return kodeVoucher; }
    double getDiskon() { return diskon; }
    bool getFreeUpgradeSeat() { return freeUpgradeSeat; }

    // ---- Setter tambahan ----
    void setKodeVoucher(string kodeVoucher) { this->kodeVoucher = kodeVoucher; }
    void setDiskon(double diskon) { this->diskon = diskon; }
    void setFreeUpgradeSeat(bool freeUpgradeSeat) { this->freeUpgradeSeat = freeUpgradeSeat; }

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
        row[9] = kodeVoucher;

        ostringstream oss;
        oss << fixed << setprecision(2) << diskon;
        row[10] = oss.str();

        row[11] = freeUpgradeSeat ? "Yes" : "No";
        return row;
    }
};
