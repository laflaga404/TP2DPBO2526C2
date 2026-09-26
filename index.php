<?php

require_once 'MemberPremium.php';

// =========================================================================
// Tel Aviv XXI — Sistem Keanggotaan Pelanggan (versi WEBSITE)
// -------------------------------------------------------------------------
// Versi ini TIDAK interaktif (tidak ada form input) — cukup menampilkan
// data pelanggan (Non-Member, Member, Member Premium) dalam satu halaman
// web yang rapi, lengkap dengan foto tiap tipe pelanggan.
//
// Hanya ada 3 foto (ditentukan otomatis oleh tipe pelanggan, bukan per
// orang), sesuai atribut `foto` yang di-override tiap level:
//   - Non-Member       -> foto/Pelanggan.png
//   - Member           -> foto/Member.png
//   - Member Premium   -> foto/MemberPremium.png
//
// Jalankan dengan PHP built-in server, misalnya:
//   cd PHP && php -S localhost:8000
// lalu buka http://localhost:8000 di browser.
// =========================================================================

// LIST OF OBJECT (nyimpen SEMUA tingkatan: Pelanggan, Member, MemberPremium)
// Data hardcode (5 data awal + 3 contoh tambahan), sama seperti versi CLI.
$daftarPelanggan = [
    new Pelanggan(1, "Andi Saputra", "andi@gmail.com", "081234567890"),
    new Pelanggan(2, "Budi Hartono", "budi@gmail.com", "081234567891"),
    new Member(3, "Citra Dewi", "citra@gmail.com", "081234567892",
        "MBR-001", 150, "2024-01-10", "Gratis Payung"),
    new Member(4, "Dewi Lestari", "dewi@gmail.com", "081234567893",
        "MBR-002", 320, "2023-11-05", "Gratis 2 Tiket Nonton"),
    new MemberPremium(5, "Eka Wijaya", "eka@gmail.com", "081234567894",
        "MBR-003", 980, "2023-05-20", "Gratis Popcorn & Minuman",
        "VC-PREMIUM01", 0.15, true),
    new Pelanggan(6, "Fajar Nugroho", "fajar@gmail.com", "081211112222"),
    new Member(7, "Gita Ayu", "gita@gmail.com", "081233334444",
        "MBR-004", 50, "2024-06-01", "Gratis Popcorn"),
    new MemberPremium(8, "Hana Permata", "hana@gmail.com", "081255556666",
        "MBR-005", 1200, "2022-09-15", "Gratis 2 Tiket Nonton",
        "VC-PREMIUM02", 0.20, true),
];

$HEADER = [
    "Foto", "ID", "Nama", "Email", "No Telepon", "Tipe",
    "No Kartu Member", "Poin", "Tgl Gabung", "Benefit",
    "Kode Voucher", "Diskon", "Free Upgrade Seat",
];

// Ambil toRow() tiap objek (polymorphic), lalu pindahkan kolom Foto
// (index 5 di toRow) ke posisi paling depan biar enak dilihat di web.
$rows = [];
foreach ($daftarPelanggan as $p) {
    $r = $p->toRow();
    $foto = $r[5];
    unset($r[5]);
    $rows[] = array_merge([$foto], array_values($r));
}

function badgeClass($tipe) {
    if ($tipe === "Member Premium") return "badge badge-premium";
    if ($tipe === "Member") return "badge badge-member";
    return "badge badge-non";
}

$totalNonMember = count(array_filter($daftarPelanggan, fn($p) => $p->getTipe() === "Non-Member"));
$totalMember = count(array_filter($daftarPelanggan, fn($p) => $p->getTipe() === "Member"));
$totalPremium = count(array_filter($daftarPelanggan, fn($p) => $p->getTipe() === "Member Premium"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tel Aviv XXI — Sistem Keanggotaan Pelanggan</title>
<style>
    :root {
        --bg: #0f172a;
        --panel: #ffffff;
        --ink: #1e293b;
        --muted: #64748b;
        --accent: #dc2626;
        --accent-dark: #991b1b;
        --member: #2563eb;
        --premium: #b8860b;
        --border: #e2e8f0;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: "Segoe UI", Roboto, Arial, sans-serif;
        background: linear-gradient(180deg, #0f172a 0%, #1e293b 320px, #f1f5f9 320px);
        color: var(--ink);
    }
    header {
        max-width: 1100px;
        margin: 0 auto;
        padding: 48px 24px 24px;
        text-align: center;
        color: #f8fafc;
    }
    header .kicker {
        letter-spacing: 4px;
        text-transform: uppercase;
        font-size: 12px;
        color: var(--accent);
        font-weight: 700;
    }
    header h1 {
        margin: 8px 0 6px;
        font-size: 34px;
    }
    header p {
        margin: 0;
        color: #cbd5e1;
    }

    .stats {
        max-width: 1100px;
        margin: -30px auto 0;
        padding: 0 24px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .stat-card {
        background: var(--panel);
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        text-align: center;
    }
    .stat-card .num { font-size: 28px; font-weight: 800; }
    .stat-card .lbl { color: var(--muted); font-size: 13px; margin-top: 4px; }
    .stat-card.non .num { color: var(--muted); }
    .stat-card.member .num { color: var(--member); }
    .stat-card.premium .num { color: var(--premium); }

    main {
        max-width: 1100px;
        margin: 32px auto 64px;
        padding: 0 24px;
    }

    .panel {
        background: var(--panel);
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }
    .panel-head {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }
    .panel-head h2 { margin: 0; font-size: 18px; }
    .panel-head span { color: var(--muted); font-size: 13px; }

    .table-wrap { overflow-x: auto; }
    table { border-collapse: collapse; width: 100%; min-width: 1000px; }
    thead th {
        background: #f8fafc;
        text-align: left;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--muted);
        padding: 12px 16px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
        white-space: nowrap;
    }
    tbody tr:hover { background: #f8fafc; }
    tbody tr:last-child td { border-bottom: none; }

    .foto-cell img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border);
        display: block;
    }

    .dash { color: #cbd5e1; }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }
    .badge-non { background: #f1f5f9; color: var(--muted); }
    .badge-member { background: #dbeafe; color: var(--member); }
    .badge-premium { background: #fef3c7; color: var(--premium); }

    footer {
        text-align: center;
        color: var(--muted);
        font-size: 13px;
        padding: 0 24px 40px;
    }
</style>
</head>
<body>

<header>
    <div class="kicker">Bioskop</div>
    <h1>Tel Aviv XXI</h1>
    <p>Sistem Keanggotaan Pelanggan — versi Website (PHP, non-interaktif)</p>
</header>

<div class="stats">
    <div class="stat-card non">
        <div class="num"><?= $totalNonMember ?></div>
        <div class="lbl">Non-Member</div>
    </div>
    <div class="stat-card member">
        <div class="num"><?= $totalMember ?></div>
        <div class="lbl">Member</div>
    </div>
    <div class="stat-card premium">
        <div class="num"><?= $totalPremium ?></div>
        <div class="lbl">Member Premium</div>
    </div>
</div>

<main>
    <div class="panel">
        <div class="panel-head">
            <h2>Daftar Seluruh Pelanggan</h2>
            <span>Total: <?= count($daftarPelanggan) ?> pelanggan</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <?php foreach ($HEADER as $h): ?>
                            <th><?= htmlspecialchars($h) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <?php foreach ($row as $i => $val): ?>
                                <?php if ($i === 0): ?>
                                    <td class="foto-cell">
                                        <img src="foto/<?= htmlspecialchars($val) ?>"
                                             alt="Foto <?= htmlspecialchars($row[5]) ?>">
                                    </td>
                                <?php elseif ($i === 5): ?>
                                    <td><span class="<?= badgeClass($val) ?>"><?= htmlspecialchars($val) ?></span></td>
                                <?php elseif ($val === "-"): ?>
                                    <td class="dash">-</td>
                                <?php else: ?>
                                    <td><?= htmlspecialchars($val) ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer>
    Foto ditentukan otomatis berdasarkan tipe pelanggan
    (Pelanggan.png / Member.png / MemberPremium.png) — bukan per orang.
</footer>

</body>
</html>
