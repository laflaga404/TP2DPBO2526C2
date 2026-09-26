/**
 * Level 3 (Cucu dari Pelanggan, Anak dari Member)
 * Member kelas atas: dapet voucher, diskon transaksi, dan
 * free upgrade seat (nonton bisa naik kelas kursi gratis).
 * Mewarisi semua atribut Pelanggan + Member.
 */
public class MemberPremium extends Member {
    private String kodeVoucher;
    private double diskon;
    private boolean freeUpgradeSeat;

    public MemberPremium(int idPelanggan, String nama, String email, String noTelepon,
                          String noKartuMember, int poin, String tanggalGabung, String benefit,
                          String kodeVoucher, double diskon, boolean freeUpgradeSeat) {
        super(idPelanggan, nama, email, noTelepon, noKartuMember, poin, tanggalGabung, benefit);
        this.kodeVoucher = kodeVoucher;
        this.diskon = diskon;
        this.freeUpgradeSeat = freeUpgradeSeat;
    }

    // ---- Getter tambahan ----
    public String getKodeVoucher() { return kodeVoucher; }
    public double getDiskon() { return diskon; }
    public boolean isFreeUpgradeSeat() { return freeUpgradeSeat; }

    // ---- Setter tambahan ----
    public void setKodeVoucher(String kodeVoucher) { this.kodeVoucher = kodeVoucher; }
    public void setDiskon(double diskon) { this.diskon = diskon; }
    public void setFreeUpgradeSeat(boolean freeUpgradeSeat) { this.freeUpgradeSeat = freeUpgradeSeat; }

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
        row[9] = kodeVoucher;
        row[10] = String.format("%.2f", diskon);
        row[11] = freeUpgradeSeat ? "Yes" : "No";
        return row;
    }
}
