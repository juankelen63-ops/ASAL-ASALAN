<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h2>Input Data Cucian Baru</h2>
    <a href="index.php?action=dashboard" class="btn btn-outline">&larr; Kembali</a>
</div>

<div class="card form-card">
    <form method="POST" action="index.php?action=create">
        <div class="form-grid">
            <div class="form-group">
                <label>Kode Order</label>
                <input type="text" name="kode_order" value="<?= $kodeOtomatis ?>" readonly class="readonly-input">
            </div>

            <div class="form-group">
                <label>Tautkan Akun Pelanggan (Opsional)</label>
                <select name="user_id" id="pilih_akun" onchange="isiOtomatisPelanggan(this)">
                    <option value="">-- Pelanggan Non-Akun / Umum --</option>
                    <?php foreach ($pelangganList as $p): ?>
                        <option value="<?= $p['id'] ?>" data-nama="<?= htmlspecialchars($p['nama']) ?>">
                            <?= htmlspecialchars($p['nama']) ?> (@<?= htmlspecialchars($p['username']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Nama Pelanggan *</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" required placeholder="Nama lengkap pelanggan">
            </div>

            <div class="form-group">
                <label>Nomor WhatsApp / HP *</label>
                <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label>Berat Pakaian (Kg) *</label>
                <input type="number" step="0.1" min="0.1" name="berat_kg" id="berat_kg" required placeholder="Contoh: 2.5">
            </div>

            <div class="form-group">
                <label>Jenis Layanan *</label>
                <select name="jenis_layanan" id="jenis_layanan" required>
                    <option value="reguler">Reguler (Rp 7.000 / kg - 2 Hari)</option>
                    <option value="kilat">Kilat / Express (Rp 12.000 / kg - 6 Jam)</option>
                </select>
            </div>
        </div>

        <div class="estimasi-box">
            <span>Estimasi Total Biaya:</span>
            <h2 id="tampil_harga">Rp 0</h2>
            <small id="rincian_harga">Masukkan berat pakaian untuk menghitung estimasi otomatis.</small>
        </div>

        <div class="form-group">
            <label>Catatan Khusus (Opsional)</label>
            <textarea name="catatan" rows="3" placeholder="Contoh: Baju luntur dipisah, lipat rapi..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Simpan Transaksi Cucian</button>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>