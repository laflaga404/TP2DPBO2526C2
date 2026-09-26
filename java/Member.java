/**
 * Level 2 (Anak dari Pelanggan)
 * Pelanggan yang udah daftar jadi member, dapet kartu member & poin
 * tiap nonton. Mewarisi semua atribut Pelanggan.
 */
public class Member extends Pelanggan {
    private String noKartuMember;
    private int poin;
    private String tanggalGabung;
    private String benefit;

    public Member(int idPelanggan, String nama, String email, String noTelepon,
                  String noKartuMember, int poin, String tanggalGabung, String benefit) {
        super(idPelanggan, nama, email, noTelepon);
        this.noKartuMember = noKartuMember;
        this.poin = poin;
        this.tanggalGabung = tanggalGabung;
        this.benefit = benefit;
    }

    // ---- Getter tambahan ----
    public String getNoKartuMember() { return noKartuMember; }
    public int getPoin() { return poin; }
    public String getTanggalGabung() { return tanggalGabung; }
    public String getBenefit() { return benefit; }

    // ---- Setter tambahan ----
    public void setPoin(int poin) { this.poin = poin; }
    public void setTanggalGabung(String tanggalGabung) { this.tanggalGabung = tanggalGabung; }
    public void setBenefit(String benefit) { this.benefit = benefit; }

    // ---- Method tambahan khusus Member ----
    public void tambahPoin(int jumlah) {
        this.poin += jumlah;
    }

    // ---- Override method dari Pelanggan ----
    @Override
    public String getTipe() {
        return "Member";
    }

    @Override
    public String[] toRow() {
        String[] row = super.toRow();
        row[4] = getTipe();
        row[5] = noKartuMember;
        row[6] = String.valueOf(poin);
        row[7] = tanggalGabung;
        row[8] = benefit;
        return row;
    }
}
