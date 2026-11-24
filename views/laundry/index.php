<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <div>
        <h2>Dashboard Manajemen Cucian</h2>
        <p class="subtitle">Kelola data cucian masuk, proses pencucian, hingga pengambilan pelanggan.</p>
    </div>
    <a href="index.php?action=create" class="btn btn-primary">+ Tambah Cucian Baru</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <span>Total Transaksi</span>
        <h3><?= $stats['total'] ?? 0 ?></h3>
    </div>
    <div class="stat-card border-warning">
        <span>Cucian Masuk</span>
        <h3><?= $stats['masuk'] ?? 0 ?></h3>
    </div>
    <div class="stat-card border-info">
        <span>Sedang Diproses</span>
        <h3><?= $stats['diproses'] ?? 0 ?></h3>
    </div>
    <div class="stat-card border-success">
        <span>Selesai</span>
        <h3><?= $stats['selesai'] ?? 0 ?></h3>
    </div>
</div>

<div class="card filter-box">
    <form method="GET" action="index.php" class="filter-form">
        <input type="hidden" name="action" value="dashboard">
        <input type="text" name="search" placeholder="Cari Kode Order / Nama Pelanggan..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <select name="status">
            <option value="">-- Semua Status --</option>
            <option value="masuk" <?= ($_GET['status'] ?? '') === 'masuk' ? 'selected' : '' ?>>Masuk</option>
            <option value="diproses" <?= ($_GET['status'] ?? '') === 'diproses' ? 'selected' : '' ?>>Diproses</option>
            <option value="selesai" <?= ($_GET['status'] ?? '') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="index.php?action=dashboard" class="btn btn-outline">Reset</a>
    </form>
</div>

<div class="card table-responsive">
    <table>
        <thead>
            <tr>
                <th>Kode Order</th>
                <th>Pelanggan</th>
                <th>Berat</th>
                <th>Layanan</th>
                <th>Total Biaya</th>
                <th>Status (Ubah Cepat)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr><td colspan="7" class="text-center">Belum ada data cucian.</td></tr>
            <?php else: ?>
                <?php foreach ($orders as $row): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['kode_order']) ?></strong><br>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($row['tanggal_masuk'])) ?></small>
                    </td>
                    <td><?= htmlspecialchars($row['nama_pelanggan']) ?><br>
                        <small class="text-muted"><?= htmlspecialchars($row['no_hp']) ?></small>
                    </td>
                    <td><?= number_format($row['berat_kg'], 1) ?> kg</td>
                    <td>
                        <span class="badge-layanan <?= $row['jenis_layanan'] ?>">
                            <?= strtoupper($row['jenis_layanan']) ?>
                        </span>
                    </td>
                    <td><strong>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></strong></td>
                    <td>
                        <form method="POST" action="index.php?action=update_status" class="inline-form">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="status-select status-<?= $row['status'] ?>">
                                <option value="masuk" <?= $row['status'] === 'masuk' ? 'selected' : '' ?>>Masuk</option>
                                <option value="diproses" <?= $row['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option value="selesai" <?= $row['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td class="action-buttons">
                        <a href="index.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data cucian ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>