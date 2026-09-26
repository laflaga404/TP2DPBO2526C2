#include <iostream>
#include <vector>
#include <string>
#include <memory>
#include <limits>
#include "MemberPremium.cpp"

using namespace std;

// LIST OF OBJECT (nyimpen SEMUA tingkatan: Pelanggan, Member, MemberPremium)
// Pakai shared_ptr<Pelanggan> biar polymorphism jalan (gak ke-slice)
// dan memori otomatis dibersihin.
vector<shared_ptr<Pelanggan>> daftarPelanggan;

const vector<string> HEADER = {
    "ID", "Nama", "Email", "No Telepon", "Tipe",
    "No Kartu Member", "Poin", "Tgl Gabung", "Benefit",
    "Kode Voucher", "Diskon", "Free Upgrade Seat"
};

// ERROR handling biar ID/poin itu integer
int inputInteger(string pesan) {
    int nilai;

    while (true) {
        cout << pesan;

        if (cin >> nilai) {
            if (nilai < 0) {
                cout << "Input harus berupa angka 0 atau lebih!" << endl;
            } else {
                cin.ignore(numeric_limits<streamsize>::max(), '\n');
                return nilai;
            }
        } else {
            cout << "Input harus berupa angka hey!" << endl;
            cin.clear();
            cin.ignore(numeric_limits<streamsize>::max(), '\n');
        }
    }
}

// ERROR handling biar diskon itu angka desimal (misal 0.15)
double inputDesimal(string pesan) {
    double nilai;

    while (true) {
        cout << pesan;

        if (cin >> nilai) {
            if (nilai < 0) {
                cout << "Input harus berupa angka 0 atau lebih!" << endl;
            } else {
                cin.ignore(numeric_limits<streamsize>::max(), '\n');
                return nilai;
            }
        } else {
            cout << "Input harus berupa angka desimal, misal 0.15!" << endl;
            cin.clear();
            cin.ignore(numeric_limits<streamsize>::max(), '\n');
        }
    }
}

// ISI 5 OBJEK AWAL SEBELUM ADA INPUT USER
void isiDataAwal() {
    daftarPelanggan.push_back(make_shared<Pelanggan>(
        1, "Andi Saputra", "andi@gmail.com", "081234567890"));
    daftarPelanggan.push_back(make_shared<Pelanggan>(
        2, "Budi Hartono", "budi@gmail.com", "081234567891"));
    daftarPelanggan.push_back(make_shared<Member>(
        3, "Citra Dewi", "citra@gmail.com", "081234567892",
        "MBR-001", 150, "2024-01-10", "Gratis Payung"));
    daftarPelanggan.push_back(make_shared<Member>(
        4, "Dewi Lestari", "dewi@gmail.com", "081234567893",
        "MBR-002", 320, "2023-11-05", "Gratis 2 Tiket Nonton"));
    daftarPelanggan.push_back(make_shared<MemberPremium>(
        5, "Eka Wijaya", "eka@gmail.com", "081234567894",
        "MBR-003", 980, "2023-05-20", "Gratis Popcorn & Minuman",
        "VC-PREMIUM01", 0.15, true));
}

// TAMBAH DATA (satu-satunya operasi selain nampilin data)
void tambahData() {
    cout << "\n******** TAMBAH DATA PELANGGAN ********" << endl;
    cout << "1. Non-Member" << endl;
    cout << "2. Member" << endl;
    cout << "3. Member Premium" << endl;
    cout << "Pilih tipe pelanggan: ";
    string tipe;
    getline(cin, tipe);

    if (tipe != "1" && tipe != "2" && tipe != "3") {
        cout << "Tipe pelanggan tidak valid!" << endl;
        return;
    }

    int id = inputInteger("ID Pelanggan     : ");

    // Cek ID agar unik di seluruh daftar (lintas tipe)
    for (auto &p : daftarPelanggan) {
        if (p->getId() == id) {
            cout << "ID udah kepake itu!" << endl;
            return;
        }
    }

    string nama, email, noTelepon;
    cout << "Nama             : "; getline(cin, nama);
    cout << "Email            : "; getline(cin, email);
    cout << "No Telepon       : "; getline(cin, noTelepon);

    if (tipe == "1") {
        daftarPelanggan.push_back(make_shared<Pelanggan>(id, nama, email, noTelepon));

    } else if (tipe == "2") {
        string noKartu, tanggalGabung, benefit;
        cout << "No Kartu Member  : "; getline(cin, noKartu);
        int poin = inputInteger("Poin             : ");
        cout << "Tanggal Gabung   : "; getline(cin, tanggalGabung);
        cout << "Benefit          : "; getline(cin, benefit);

        daftarPelanggan.push_back(make_shared<Member>(
            id, nama, email, noTelepon, noKartu, poin, tanggalGabung, benefit));

    } else {
        string noKartu, tanggalGabung, benefit, kodeVoucher, freeUpgradeInput;
        cout << "No Kartu Member    : "; getline(cin, noKartu);
        int poin = inputInteger("Poin               : ");
        cout << "Tanggal Gabung     : "; getline(cin, tanggalGabung);
        cout << "Benefit            : "; getline(cin, benefit);
        cout << "Kode Voucher       : "; getline(cin, kodeVoucher);
        double diskon = inputDesimal("Diskon (misal 0.15): ");
        cout << "Free Upgrade Seat (y/n): "; getline(cin, freeUpgradeInput);
        bool freeUpgradeSeat = (freeUpgradeInput == "y" || freeUpgradeInput == "Y");

        daftarPelanggan.push_back(make_shared<MemberPremium>(
            id, nama, email, noTelepon, noKartu, poin, tanggalGabung, benefit,
            kodeVoucher, diskon, freeUpgradeSeat));
    }

    cout << "Data pelanggan baru berhasil ditambahkan!" << endl;
}

// TAMPILKAN DATA (satu tabel dinamis buat SEMUA tingkatan)
void cetakTabel() {
    cout << "\n******** DAFTAR SELURUH PELANGGAN TEL AVIV XXI ********" << endl;

    if (daftarPelanggan.empty()) {
        cout << "Belum ada data pelanggan." << endl;
        return;
    }

    vector<vector<string>> rows;
    for (auto &p : daftarPelanggan) {
        rows.push_back(p->toRow());
    }

    // Hitung lebar kolom otomatis (dinamis) berdasarkan isi terpanjang
    vector<size_t> lebar(HEADER.size());
    for (size_t i = 0; i < HEADER.size(); i++) {
        lebar[i] = HEADER[i].size();
    }
    for (auto &row : rows) {
        for (size_t i = 0; i < row.size(); i++) {
            lebar[i] = max(lebar[i], row[i].size());
        }
    }

    auto cetakGaris = [&]() {
        cout << "+";
        for (size_t l : lebar) {
            cout << string(l + 2, '-') << "+";
        }
        cout << endl;
    };

    auto cetakBaris = [&](const vector<string> &vals) {
        cout << "|";
        for (size_t i = 0; i < vals.size(); i++) {
            cout << " " << vals[i] << string(lebar[i] - vals[i].size(), ' ') << " |";
        }
        cout << endl;
    };

    cetakGaris();
    cetakBaris(HEADER);
    cetakGaris();
    for (auto &row : rows) {
        cetakBaris(row);
    }
    cetakGaris();
    cout << "Total data: " << daftarPelanggan.size() << " pelanggan" << endl;
}

// MENU UTAMA
void menu() {
    while (true) {
        cout << "\n**************************************" << endl;
        cout << "             Tel Aviv XXI" << endl;
        cout << "     Sistem Keanggotaan Pelanggan" << endl;
        cout << "**************************************" << endl;
        cout << "1. Tambah Data Pelanggan" << endl;
        cout << "2. Tampilkan Semua Data" << endl;
        cout << "3. Keluar" << endl;
        cout << "**************************************" << endl;

        cout << "Pilih menu: ";
        string pilihan;
        getline(cin, pilihan);

        if (pilihan == "1") {
            tambahData();
        } else if (pilihan == "2") {
            cetakTabel();
        } else if (pilihan == "3") {
            cout << "See You Later!" << endl;
            break;
        } else {
            cout << "Nuh uh! Gaada pilihannya woy!" << endl;
        }
    }
}

int main() {
    isiDataAwal();
    menu();
    return 0;
}
