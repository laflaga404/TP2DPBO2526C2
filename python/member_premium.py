from member import Member


class MemberPremium(Member):
    """
    Level 3 (Cucu dari Pelanggan, Anak dari Member)
    Member kelas atas: dapet voucher, limit transaksi bulanan,
    dan prioritas layanan (booking/CS didahulukan).
    Mewarisi semua atribut Pelanggan + Member.
    """

    def __init__(self, id_pelanggan, nama, email, no_telepon,
                 no_kartu_member, poin, tanggal_gabung,
                 kode_voucher: str, limit_transaksi: float, priority_support: bool):
        super().__init__(id_pelanggan, nama, email, no_telepon,
                          no_kartu_member, poin, tanggal_gabung)
        self._kode_voucher = str(kode_voucher)
        self._limit_transaksi = float(limit_transaksi)
        self._priority_support = bool(priority_support)

    # ---- Getter tambahan ----
    def get_kode_voucher(self) -> str:
        return self._kode_voucher

    def get_limit_transaksi(self) -> float:
        return self._limit_transaksi

    def get_priority_support(self) -> bool:
        return self._priority_support

    # ---- Setter tambahan ----
    def set_kode_voucher(self, kode_voucher: str) -> None:
        self._kode_voucher = str(kode_voucher)

    def set_limit_transaksi(self, limit_transaksi: float) -> None:
        self._limit_transaksi = float(limit_transaksi)

    # ---- Method tambahan khusus MemberPremium ----
    def gunakan_voucher(self) -> str:
        return f"Voucher {self._kode_voucher} berhasil dipakai!"

    # ---- Override method ----
    def get_tipe(self) -> str:
        return "Member Premium"

    def to_row(self) -> list:
        row = super().to_row()
        row[4] = self.get_tipe()
        row[8] = self._kode_voucher
        row[9] = f"{self._limit_transaksi:,.0f}"
        row[10] = "Ya" if self._priority_support else "Tidak"
        return row
