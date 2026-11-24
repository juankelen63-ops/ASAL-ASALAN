<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h1>🧺 Clean<span>Wash</span></h1>
            <p>Sistem Informasi & Manajemen Layanan Laundry</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username..." required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Masuk ke Sistem</button>
        </form>

        <div class="demo-info">
            <small><strong>Akun Demo:</strong><br>
            Admin: <code>admin</code> / <code>123456</code><br>
            Pelanggan: <code>budi</code> / <code>123456</code></small>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>