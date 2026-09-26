class Pelanggan:
    """
    Level 1 (Parent paling atas)
    Pelanggan biasa / non-member bioskop Tel Aviv XXI.
    Cuma modal nama & kontak, belum punya kartu member.
    """

    def __init__(self, id_pelanggan: int, nama: str, email: str, no_telepon: str):
        self._id_pelanggan = int(id_pelanggan)
        self._nama = str(nama)
        self._email = str(email)
        self._no_telepon = str(no_telepon)

    # ---- Getter ----
    def get_id(self) -> int:
        return self._id_pelanggan

    def get_nama(self) -> str:
        return self._nama

    def get_email(self) -> str:
        return self._email

    def get_no_telepon(self) -> str:
        return self._no_telepon

    # ---- Setter ----
    def set_nama(self, nama: str) -> None:
        self._nama = str(nama)

    def set_email(self, email: str) -> None:
        self._email = str(email)

    def set_no_telepon(self, no_telepon: str) -> None:
        self._no_telepon = str(no_telepon)

    # ---- Method polymorphic (bakal di-override di anak & cucu) ----
    def get_tipe(self) -> str:
        return "Non-Member"

    def to_row(self) -> list:
        """
        Ubah data jadi 1 baris tabel dengan urutan kolom yang SAMA
        buat semua tingkatan (Pelanggan, Member, MemberPremium).
        Kolom yang gak dimiliki level ini otomatis diisi strip '-'.
        """
        return [
            str(self._id_pelanggan),
            self._nama,
            self._email,
            self._no_telepon,
            self.get_tipe(),
            "-",  # No Kartu Member
            "-",  # Poin
            "-",  # Tanggal Gabung
            "-",  # Kode Voucher
            "-",  # Limit Transaksi
            "-",  # Priority Support
        ]
