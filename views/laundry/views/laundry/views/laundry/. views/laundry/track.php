<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <div>
        <h2>Lacak Status Cucian Anda</h2>
        <p class="subtitle">Pantau perkembangan cucian Anda secara real-time berdasarkan Kode Order atau riwayat akun.</p>
    </div>
</div>

<div class="card track-box">
    <form method="GET" action="index.php" class="filter-form">
        <input type="hidden" name="action" value="track">
        <input type="text" name="kode" placeholder="Masukkan Kode Order (Contoh: LND-2026001)..." value="<?= htmlspecialchars($_GET['kode'] ?? '') ?>" required>
        <button type="submit" class="btn btn-primary">🔍 Cek Status</button>
    </form>

    <?php if (!empty($pesanCari)): ?>
        <div class="alert alert-danger" style="margin-top: 15px;"><?= $pesanCari ?></div>
    <?php endif; ?>

    <?php if ($hasilCari): ?>
        <div class="track-result">
            <div class="track-header">
                <h3>Kode: <?= htmlspecialchars($hasilCari['kode_order']) ?></h3>
                <span class="badge-status status-<?= $hasilCari['status'] ?>">
                    <?= strtoupper($hasilCari['status']) ?>
                </span>
            </div>
            <p><strong>Pelanggan:</strong> <?= htmlspecialchars($hasilCari['nama_pelanggan']) ?> | 
               <strong>Berat:</strong> <?= $hasilCari['berat_kg'] ?> kg | 
               <strong>Layanan:</strong> <?= ucfirst($hasilCari['jenis_layanan']) ?> | 
               <strong>Total:</strong> Rp <?= number_format($hasilCari['total_harga'], 0, ',', '.') ?></p>

            <div class="stepper">
                <div class="step active">1. Cucian Masuk</div>
                <div class="step <?= in_array($hasilCari['status'], ['diproses', 'selesai']) ? 'active' : '' ?>">2. Sedang Diproses</div>
                <div class="step <?= $hasilCari['status'] === 'selesai' ? 'active' : '' ?>">3. Selesai & Siap Diambil</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="card table-responsive" style="margin-top: 24px;">
    <h3 style="margin-bottom: 15px;">Riwayat Cucian Saya (<?= htmlspecialchars($_SESSION['nama']) ?>)</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Order</th>
                <th>Tanggal Masuk</th>
                <th>Berat</th>
                <th>Layanan</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($myOrders)): ?>
                <tr><td colspan="6" class="text-center">Belum ada riwayat cucian yang terhubung dengan akun Anda.</td></tr>
            <?php else: ?>
                <?php foreach ($myOrders as $item): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($item['kode_order']) ?></strong></td>
                    <td><?= date('d M Y, H:i', strtotime($item['tanggal_masuk'])) ?></td>
                    <td><?= $item['berat_kg'] ?> kg</td>
                    <td><?= ucfirst($item['jenis_layanan']) ?></td>
                    <td>Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge-status status-<?= $item['status'] ?>">
                            <?= strtoupper($item['status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>