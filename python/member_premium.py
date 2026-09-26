from member import Member


class MemberPremium(Member):
    """
    Level 3 (Cucu dari Pelanggan, Anak dari Member)
    Member kelas atas: dapet voucher, diskon transaksi, dan
    free upgrade seat (nonton bisa naik kelas kursi gratis).
    Mewarisi semua atribut Pelanggan + Member.
    """

    def __init__(self, id_pelanggan, nama, email, no_telepon,
                 no_kartu_member, poin, tanggal_gabung, benefit,
                 kode_voucher: str, diskon: float, free_upgrade_seat: bool):
        super().__init__(id_pelanggan, nama, email, no_telepon,
                          no_kartu_member, poin, tanggal_gabung, benefit)
        self._kode_voucher = str(kode_voucher)
        self._diskon = float(diskon)
        self._free_upgrade_seat = bool(free_upgrade_seat)

    # ---- Getter tambahan ----
    def get_kode_voucher(self) -> str:
        return self._kode_voucher

    def get_diskon(self) -> float:
        return self._diskon

    def get_free_upgrade_seat(self) -> bool:
        return self._free_upgrade_seat

    # ---- Setter tambahan ----
    def set_kode_voucher(self, kode_voucher: str) -> None:
        self._kode_voucher = str(kode_voucher)

    def set_diskon(self, diskon: float) -> None:
        self._diskon = float(diskon)

    def set_free_upgrade_seat(self, free_upgrade_seat: bool) -> None:
        self._free_upgrade_seat = bool(free_upgrade_seat)

    # ---- Method tambahan khusus MemberPremium ----
    def gunakan_voucher(self) -> str:
        return f"Voucher {self._kode_voucher} berhasil dipakai!"

    # ---- Override method ----
    def get_tipe(self) -> str:
        return "Member Premium"

    def to_row(self) -> list:
        row = super().to_row()
        row[4] = self.get_tipe()
        row[9] = self._kode_voucher
        row[10] = f"{self._diskon:.2f}"
        row[11] = "Yes" if self._free_upgrade_seat else "No"
        return row
