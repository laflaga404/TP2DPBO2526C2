/**
 * Level 3 (Cucu dari Pelanggan, Anak dari Member)
 * Member kelas atas: dapet voucher, diskon transaksi,
 * dan prioritas layanan (booking/CS didahulukan).
 * Mewarisi semua atribut Pelanggan + Member.
 */
public class MemberPremium extends Member {
    private String kodeVoucher;
    private double diskonTransaksi;
    private boolean prioritySupport;

    public MemberPremium(int idPelanggan, String nama, String email, String noTelepon,
                          String noKartuMember, int poin, String tanggalGabung,
                          String kodeVoucher, double diskonTransaksi, boolean prioritySupport) {
        super(idPelanggan, nama, email, noTelepon, noKartuMember, poin, tanggalGabung);
        this.kodeVoucher = kodeVoucher;
        this.diskonTransaksi = diskonTransaksi;
        this.prioritySupport = prioritySupport;
    }

    // ---- Getter tambahan ----
    public String getKodeVoucher() { return kodeVoucher; }
    public double getdiskonTransaksi() { return diskonTransaksi; }
    public boolean isPrioritySupport() { return prioritySupport; }

    // ---- Setter tambahan ----
    public void setKodeVoucher(String kodeVoucher) { this.kodeVoucher = kodeVoucher; }
    public void setdiskonTransaksi(double diskonTransaksi) { this.diskonTransaksi = diskonTransaksi; }

    // ---- Method tambahan khusus MemberPremium ----
    public String gunakanVoucher() {
        return "Voucher " + kodeVoucher + " berhasil dipakai!";
    }

    // ---- Override method ----
    @Override
    public String getTipe() {
        return "Member Premium";
    }

    @Override
    public String[] toRow() {
        String[] row = super.toRow();
        row[4] = getTipe();
        row[8] = kodeVoucher;
        row[9] = String.format("%,.0f", diskonTransaksi);
        row[10] = prioritySupport ? "Ya" : "Tidak";
        return row;
    }
}
