import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class Main {

    // LIST OF OBJECT (nyimpen SEMUA tingkatan: Pelanggan, Member, MemberPremium)
    static List<Pelanggan> daftarPelanggan = new ArrayList<>();
    static Scanner scanner = new Scanner(System.in);

    static final String[] HEADER = {
        "ID", "Nama", "Email", "No Telepon", "Tipe",
        "No Kartu Member", "Poin", "Tgl Gabung", "Benefit",
        "Kode Voucher", "Diskon", "Free Upgrade Seat"
    };

    // ERROR handling biar ID/poin itu integer
    static int inputInteger(String pesan) {
        while (true) {
            System.out.print(pesan);

            if (scanner.hasNextInt()) {
                int nilai = scanner.nextInt();
                scanner.nextLine();

                if (nilai < 0) {
                    System.out.println("Input harus berupa angka 0 atau lebih!");
                } else {
                    return nilai;
                }
            } else {
                System.out.println("Input harus berupa angka hey!");
                scanner.nextLine();
            }
        }
    }

    // ERROR handling biar diskon itu angka desimal (misal 0.15)
    static double inputDesimal(String pesan) {
        while (true) {
            System.out.print(pesan);
            String baris = scanner.nextLine().trim().replace(",", ".");

            try {
                double nilai = Double.parseDouble(baris);
                if (nilai < 0) {
                    System.out.println("Input harus berupa angka 0 atau lebih!");
                } else {
                    return nilai;
                }
            } catch (NumberFormatException e) {
                System.out.println("Input harus berupa angka desimal, misal 0.15!");
            }
        }
    }

    // ISI 5 OBJEK AWAL SEBELUM ADA INPUT USER
    static void isiDataAwal() {
        daftarPelanggan.add(new Pelanggan(1, "Andi Saputra", "andi@gmail.com", "081234567890"));
        daftarPelanggan.add(new Pelanggan(2, "Budi Hartono", "budi@gmail.com", "081234567891"));
        daftarPelanggan.add(new Member(3, "Citra Dewi", "citra@gmail.com", "081234567892",
                "MBR-001", 150, "2024-01-10", "Gratis Payung"));
        daftarPelanggan.add(new Member(4, "Dewi Lestari", "dewi@gmail.com", "081234567893",
                "MBR-002", 320, "2023-11-05", "Gratis 2 Tiket Nonton"));
        daftarPelanggan.add(new MemberPremium(5, "Eka Wijaya", "eka@gmail.com", "081234567894",
                "MBR-003", 980, "2023-05-20", "Gratis Popcorn & Minuman",
                "VC-PREMIUM01", 0.15, true));
    }

    // TAMBAH DATA (satu-satunya operasi selain nampilin data)
    static void tambahData() {
        System.out.println("\n******** TAMBAH DATA PELANGGAN ********");
        System.out.println("1. Non-Member");
        System.out.println("2. Member");
        System.out.println("3. Member Premium");
        System.out.print("Pilih tipe pelanggan: ");
        String tipe = scanner.nextLine();

        if (!tipe.equals("1") && !tipe.equals("2") && !tipe.equals("3")) {
            System.out.println("Tipe pelanggan tidak valid!");
            return;
        }

        int id = inputInteger("ID Pelanggan     : ");

        // Cek ID agar unik di seluruh daftar (lintas tipe)
        for (Pelanggan p : daftarPelanggan) {
            if (p.getId() == id) {
                System.out.println("ID udah kepake itu!");
                return;
            }
        }

        System.out.print("Nama             : ");
        String nama = scanner.nextLine();
        System.out.print("Email            : ");
        String email = scanner.nextLine();
        System.out.print("No Telepon       : ");
        String noTelepon = scanner.nextLine();

        Pelanggan pelangganBaru;

        if (tipe.equals("1")) {
            pelangganBaru = new Pelanggan(id, nama, email, noTelepon);

        } else if (tipe.equals("2")) {
            System.out.print("No Kartu Member  : ");
            String noKartu = scanner.nextLine();
            int poin = inputInteger("Poin             : ");
            System.out.print("Tanggal Gabung   : ");
            String tanggalGabung = scanner.nextLine();
            System.out.print("Benefit          : ");
            String benefit = scanner.nextLine();
            pelangganBaru = new Member(id, nama, email, noTelepon, noKartu, poin, tanggalGabung, benefit);

        } else {
            System.out.print("No Kartu Member    : ");
            String noKartu = scanner.nextLine();
            int poin = inputInteger("Poin               : ");
            System.out.print("Tanggal Gabung     : ");
            String tanggalGabung = scanner.nextLine();
            System.out.print("Benefit            : ");
            String benefit = scanner.nextLine();
            System.out.print("Kode Voucher       : ");
            String kodeVoucher = scanner.nextLine();
            double diskon = inputDesimal("Diskon (misal 0.15): ");
            System.out.print("Free Upgrade Seat (y/n): ");
            String freeUpgradeInput = scanner.nextLine();
            boolean freeUpgradeSeat = freeUpgradeInput.trim().equalsIgnoreCase("y");
            pelangganBaru = new MemberPremium(id, nama, email, noTelepon,
                    noKartu, poin, tanggalGabung, benefit,
                    kodeVoucher, diskon, freeUpgradeSeat);
        }

        daftarPelanggan.add(pelangganBaru);
        System.out.println("Data pelanggan baru berhasil ditambahkan!");
    }

    // TAMPILKAN DATA (satu tabel dinamis buat SEMUA tingkatan)
    static void cetakTabel() {
        System.out.println("\n******** DAFTAR SELURUH PELANGGAN TEL AVIV XXI ********");

        if (daftarPelanggan.isEmpty()) {
            System.out.println("Belum ada data pelanggan.");
            return;
        }

        List<String[]> rows = new ArrayList<>();
        for (Pelanggan p : daftarPelanggan) {
            rows.add(p.toRow());
        }

        // Hitung lebar kolom otomatis (dinamis) berdasarkan isi terpanjang
        int[] lebar = new int[HEADER.length];
        for (int i = 0; i < HEADER.length; i++) {
            lebar[i] = HEADER[i].length();
        }
        for (String[] row : rows) {
            for (int i = 0; i < row.length; i++) {
                lebar[i] = Math.max(lebar[i], row[i].length());
            }
        }

        cetakGaris(lebar);
        cetakBaris(HEADER, lebar);
        cetakGaris(lebar);
        for (String[] row : rows) {
            cetakBaris(row, lebar);
        }
        cetakGaris(lebar);
        System.out.println("Total data: " + daftarPelanggan.size() + " pelanggan");
    }

    static void cetakGaris(int[] lebar) {
        StringBuilder sb = new StringBuilder("+");
        for (int l : lebar) {
            sb.append("-".repeat(l + 2)).append("+");
        }
        System.out.println(sb);
    }

    static void cetakBaris(String[] vals, int[] lebar) {
        StringBuilder sb = new StringBuilder("|");
        for (int i = 0; i < vals.length; i++) {
            sb.append(" ").append(String.format("%-" + lebar[i] + "s", vals[i])).append(" |");
        }
        System.out.println(sb);
    }

    // MENU UTAMA
    static void menu() {
        while (true) {
            System.out.println("\n**************************************");
            System.out.println("             Tel Aviv XXI");
            System.out.println("     Sistem Keanggotaan Pelanggan");
            System.out.println("**************************************");
            System.out.println("1. Tambah Data Pelanggan");
            System.out.println("2. Tampilkan Semua Data");
            System.out.println("3. Keluar");
            System.out.println("**************************************");

            System.out.print("Pilih menu: ");
            String pilihan = scanner.nextLine();

            switch (pilihan) {
                case "1": tambahData(); break;
                case "2": cetakTabel(); break;
                case "3":
                    System.out.println("See You Later!");
                    return;
                default: System.out.println("Nuh uh! Gaada pilihannya woy!");
            }
        }
    }

    public static void main(String[] args) {
        isiDataAwal();
        menu();
    }
}
