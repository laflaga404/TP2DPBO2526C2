from pelanggan import Pelanggan
from member import Member
from member_premium import MemberPremium


# LIST OF OBJECT (nyimpen SEMUA tingkatan: Pelanggan, Member, MemberPremium)
daftar_pelanggan = [
    Pelanggan(1, "Andi Saputra", "andi@gmail.com", "081234567890"),
    Pelanggan(2, "Budi Hartono", "budi@gmail.com", "081234567891"),
    Member(3, "Citra Dewi", "citra@gmail.com", "081234567892",
           "MBR-001", 150, "2024-01-10", "Gratis Payung"),
    Member(4, "Dewi Lestari", "dewi@gmail.com", "081234567893",
           "MBR-002", 320, "2023-11-05", "Gratis 2 Tiket Nonton"),
    MemberPremium(5, "Eka Wijaya", "eka@gmail.com", "081234567894",
                   "MBR-003", 980, "2023-05-20", "Gratis Popcorn & Minuman",
                   "VC-PREMIUM01", 0.15, True),
]

HEADER = ["ID", "Nama", "Email", "No Telepon", "Tipe",
          "No Kartu Member", "Poin", "Tgl Gabung", "Benefit",
          "Kode Voucher", "Diskon", "Free Upgrade Seat"]


# ERROR handling biar ID/poin itu integer
def input_integer(pesan):
    while True:
        try:
            nilai = int(input(pesan))
            if nilai < 0:
                print("Input harus berupa angka 0 atau lebih!")
            else:
                return nilai
        except ValueError:
            print("Input harus berupa angka hey!")


# ERROR handling biar diskon itu angka desimal (misal 0.15)
def input_desimal(pesan):
    while True:
        try:
            nilai = float(input(pesan).strip().replace(",", "."))
            if nilai < 0:
                print("Input harus berupa angka 0 atau lebih!")
            else:
                return nilai
        except ValueError:
            print("Input harus berupa angka desimal, misal 0.15!")


# TAMBAH DATA (satu-satunya operasi selain nampilin data)

def tambah_data():
    print("\n******** TAMBAH DATA PELANGGAN ********")
    print("1. Non-Member")
    print("2. Member")
    print("3. Member Premium")
    tipe = input("Pilih tipe pelanggan: ")

    if tipe not in ("1", "2", "3"):
        print("Tipe pelanggan tidak valid!")
        return

    id_pelanggan = input_integer("ID Pelanggan     : ")

    # Cek ID agar unik di seluruh daftar (lintas tipe)
    for p in daftar_pelanggan:
        if p.get_id() == id_pelanggan:
            print("ID udah kepake itu!")
            return

    nama = input("Nama             : ")
    email = input("Email            : ")
    no_telepon = input("No Telepon       : ")

    if tipe == "1":
        pelanggan_baru = Pelanggan(id_pelanggan, nama, email, no_telepon)

    elif tipe == "2":
        no_kartu = input("No Kartu Member  : ")
        poin = input_integer("Poin             : ")
        tanggal_gabung = input("Tanggal Gabung   : ")
        benefit = input("Benefit          : ")
        pelanggan_baru = Member(
            id_pelanggan, nama, email, no_telepon,
            no_kartu, poin, tanggal_gabung, benefit
        )

    else:  # tipe == "3"
        no_kartu = input("No Kartu Member    : ")
        poin = input_integer("Poin               : ")
        tanggal_gabung = input("Tanggal Gabung     : ")
        benefit = input("Benefit            : ")
        kode_voucher = input("Kode Voucher       : ")
        diskon = input_desimal("Diskon (misal 0.15): ")
        free_upgrade_input = input("Free Upgrade Seat (y/n): ")
        free_upgrade_seat = free_upgrade_input.strip().lower() == "y"
        pelanggan_baru = MemberPremium(
            id_pelanggan, nama, email, no_telepon,
            no_kartu, poin, tanggal_gabung, benefit,
            kode_voucher, diskon, free_upgrade_seat
        )

    daftar_pelanggan.append(pelanggan_baru)
    print("Data pelanggan baru berhasil ditambahkan!")


# TAMPILKAN DATA (satu tabel dinamis buat SEMUA tingkatan)

def cetak_tabel():
    print("\n******** DAFTAR SELURUH PELANGGAN TEL AVIV XXI ********")

    if len(daftar_pelanggan) == 0:
        print("Belum ada data pelanggan.")
        return

    rows = [p.to_row() for p in daftar_pelanggan]

    # Hitung lebar kolom otomatis (dinamis) berdasarkan isi terpanjang
    lebar = [len(h) for h in HEADER]
    for row in rows:
        for i, val in enumerate(row):
            lebar[i] = max(lebar[i], len(str(val)))

    def garis():
        print("+" + "+".join("-" * (l + 2) for l in lebar) + "+")

    def baris(vals):
        sel = []
        for i, v in enumerate(vals):
            sel.append(" " + str(v).ljust(lebar[i]) + " ")
        print("|" + "|".join(sel) + "|")

    garis()
    baris(HEADER)
    garis()
    for row in rows:
        baris(row)
    garis()
    print(f"Total data: {len(daftar_pelanggan)} pelanggan")


# MENU UTAMA

def menu():
    while True:
        print("\n**************************************")
        print("             Tel Aviv XXI")
        print("     Sistem Keanggotaan Pelanggan")
        print("**************************************")
        print("1. Tambah Data Pelanggan")
        print("2. Tampilkan Semua Data")
        print("3. Keluar")
        print("**************************************")

        pilihan = input("Pilih menu: ")

        if pilihan == "1":
            tambah_data()
        elif pilihan == "2":
            cetak_tabel()
        elif pilihan == "3":
            print("See You Later!")
            break
        else:
            print("Nuh uh! Gaada pilihannya woy!")


menu()
