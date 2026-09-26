from pelanggan import Pelanggan


class Member(Pelanggan):
    """
    Level 2 (Anak dari Pelanggan)
    Pelanggan yang udah daftar jadi member, dapet kartu member & poin
    tiap nonton. Mewarisi semua atribut Pelanggan.
    """

    def __init__(self, id_pelanggan, nama, email, no_telepon,
                 no_kartu_member: str, poin: int, tanggal_gabung: str, benefit: str):
        super().__init__(id_pelanggan, nama, email, no_telepon)
        self._no_kartu_member = str(no_kartu_member)
        self._poin = int(poin)
        self._tanggal_gabung = str(tanggal_gabung)
        self._benefit = str(benefit)

    # ---- Getter tambahan ----
    def get_no_kartu_member(self) -> str:
        return self._no_kartu_member

    def get_poin(self) -> int:
        return self._poin

    def get_tanggal_gabung(self) -> str:
        return self._tanggal_gabung

    def get_benefit(self) -> str:
        return self._benefit

    # ---- Setter tambahan ----
    def set_poin(self, poin: int) -> None:
        self._poin = int(poin)

    def set_tanggal_gabung(self, tanggal_gabung: str) -> None:
        self._tanggal_gabung = str(tanggal_gabung)

    def set_benefit(self, benefit: str) -> None:
        self._benefit = str(benefit)

    # ---- Method tambahan khusus Member ----
    def tambah_poin(self, jumlah: int) -> None:
        """Nambahin poin reward, misal abis nonton film."""
        self._poin += int(jumlah)

    # ---- Override method dari Pelanggan ----
    def get_tipe(self) -> str:
        return "Member"

    def to_row(self) -> list:
        row = super().to_row()
        row[4] = self.get_tipe()
        row[5] = self._no_kartu_member
        row[6] = str(self._poin)
        row[7] = self._tanggal_gabung
        row[8] = self._benefit
        return row
