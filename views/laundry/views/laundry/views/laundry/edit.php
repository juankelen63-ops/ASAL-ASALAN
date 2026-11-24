<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2>Edit Data Cucian: <?= htmlspecialchars($order['kode_order']) ?></h2>
    <a href="index.php?action=dashboard" class="btn btn-outline">&larr; Kembali</a>
</div>

<div class="card form-card">
    <form method="POST" action="index.php?action=edit&id=<?= $order['id'] ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Kode Order</label>
                <input type="text" value="<?= htmlspecialchars($order['kode_order']) ?>" readonly class="readonly-input">
            </div>

            <div class="form-group">
                <label>Status Cucian *</label>
                <select name="status" required>
                    <option value="masuk" <?= $order['status'] === 'masuk' ? 'selected' : '' ?>>Masuk</option>
                    <option value="diproses" <?= $order['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="selesai" <?= $order['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label>Akun Pelanggan</label>
                <select name="user_id">
                    <option value="">-- Pelanggan Umum --</option>
                    <?php foreach ($pelangganList as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $order['user_id'] == $p['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Nama Pelanggan *</label>
                <input type="text" name="nama_pelanggan" value="<?= htmlspecialchars($order['nama_pelanggan']) ?>" required>
            </div>

            <div class="form-group">
                <label>Nomor HP *</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($order['no_hp']) ?>" required>
            </div>

            <div class="form-group">
                <label>Berat Pakaian (Kg) *</label>
                <input type="number" step="0.1" min="0.1" name="berat_kg" id="berat_kg" value="<?= $order['berat_kg'] ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Layanan *</label>
                <select name="jenis_layanan" id="jenis_layanan" required>
                    <option value="reguler" <?= $order['jenis_layanan'] === 'reguler' ? 'selected' : '' ?>>Reguler (Rp 7.000 / kg)</option>
                    <option value="kilat" <?= $order['jenis_layanan'] === 'kilat' ? 'selected' : '' ?>>Kilat / Express (Rp 12.000 / kg)</option>
                </select>
            </div>
        </div>

        <div class="estimasi-box">
            <span>Estimasi Total Biaya:</span>
            <h2 id="tampil_harga">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></h2>
            <small id="rincian_harga">Harga otomatis terhitung ulang saat berat/layanan diubah.</small>
        </div>

        <div class="form-group">
            <label>Catatan</label>
            <textarea name="catatan" rows="3"><?= htmlspecialchars($order['catatan']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>