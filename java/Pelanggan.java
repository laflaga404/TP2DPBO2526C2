/**
 * Level 1 (Parent paling atas)
 * Pelanggan biasa / non-member bioskop Tel Aviv XXI.
 * Cuma modal nama & kontak, belum punya kartu member.
 */
public class Pelanggan {
    private int idPelanggan;
    private String nama;
    private String email;
    private String noTelepon;

    public Pelanggan(int idPelanggan, String nama, String email, String noTelepon) {
        this.idPelanggan = idPelanggan;
        this.nama = nama;
        this.email = email;
        this.noTelepon = noTelepon;
    }

    // ---- Getter ----
    public int getId() { return idPelanggan; }
    public String getNama() { return nama; }
    public String getEmail() { return email; }
    public String getNoTelepon() { return noTelepon; }

    // ---- Setter ----
    public void setNama(String nama) { this.nama = nama; }
    public void setEmail(String email) { this.email = email; }
    public void setNoTelepon(String noTelepon) { this.noTelepon = noTelepon; }

    // ---- Method polymorphic (bakal di-override di anak & cucu) ----
    public String getTipe() {
        return "Non-Member";
    }

    /**
     * Ubah data jadi 1 baris tabel dengan urutan kolom yang SAMA
     * buat semua tingkatan (Pelanggan, Member, MemberPremium).
     * Kolom yang gak dimiliki level ini otomatis diisi strip "-".
     */
    public String[] toRow() {
        return new String[] {
            String.valueOf(idPelanggan),
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
}
