<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/User.php';

class LaundryController {
    private $orderModel;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->orderModel = new Order($db);
        $this->userModel = new User($db);
    }

    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
    }

    private function requireAdmin() {
        $this->requireLogin();
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['flash_error'] = "Akses ditolak! Halaman ini hanya untuk Admin.";
            header("Location: index.php?action=track");
            exit;
        }
    }

    private function hitungTarif($berat, $layanan) {
        $hargaPerKg = ($layanan === 'kilat') ? 12000 : 7000;
        return (int) round($berat * $hargaPerKg);
    }

    public function index() {
        $this->requireAdmin();
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';

        $orders = $this->orderModel->getAll($search, $status);
        $stats  = $this->orderModel->getStats();
        require __DIR__ . '/../views/laundry/index.php';
    }

    public function create() {
        $this->requireAdmin();
        $pelangganList = $this->userModel->getAllPelanggan();
        $kodeOtomatis  = "LND-" . date("Y") . rand(100, 999);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $berat   = floatval($_POST['berat_kg']);
            $layanan = $_POST['jenis_layanan'];

            $data = [
                'kode_order'     => htmlspecialchars($_POST['kode_order']),
                'user_id'        => !empty($_POST['user_id']) ? $_POST['user_id'] : null,
                'nama_pelanggan' => htmlspecialchars($_POST['nama_pelanggan']),
                'no_hp'          => htmlspecialchars($_POST['no_hp']),
                'berat_kg'       => $berat,
                'jenis_layanan'  => $layanan,
                'total_harga'    => $this->hitungTarif($berat, $layanan),
                'status'         => 'masuk',
                'catatan'        => htmlspecialchars($_POST['catatan'])
            ];

            if ($this->orderModel->create($data)) {
                $_SESSION['flash_success'] = "Data cucian berhasil ditambahkan!";
                header("Location: index.php?action=dashboard");
                exit;
            }
        }
        require __DIR__ . '/../views/laundry/create.php';
    }

    public function edit() {
        $this->requireAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: index.php?action=dashboard");
            exit;
        }

        $order = $this->orderModel->getById($id);
        $pelangganList = $this->userModel->getAllPelanggan();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $berat   = floatval($_POST['berat_kg']);
            $layanan = $_POST['jenis_layanan'];

            $data = [
                'user_id'        => !empty($_POST['user_id']) ? $_POST['user_id'] : null,
                'nama_pelanggan' => htmlspecialchars($_POST['nama_pelanggan']),
                'no_hp'          => htmlspecialchars($_POST['no_hp']),
                'berat_kg'       => $berat,
                'jenis_layanan'  => $layanan,
                'total_harga'    => $this->hitungTarif($berat, $layanan),
                'status'         => $_POST['status'],
                'catatan'        => htmlspecialchars($_POST['catatan'])
            ];

            if ($this->orderModel->update($id, $data)) {
                $_SESSION['flash_success'] = "Data cucian berhasil diperbarui!";
                header("Location: index.php?action=dashboard");
                exit;
            }
        }
        require __DIR__ . '/../views/laundry/edit.php';
    }

    public function updateStatus() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = $_POST['id'];
            $status = $_POST['status'];
            $this->orderModel->updateStatus($id, $status);
            $_SESSION['flash_success'] = "Status cucian berhasil diubah menjadi " . strtoupper($status) . "!";
        }
        header("Location: index.php?action=dashboard");
        exit;
    }

    public function delete() {
        $this->requireAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->orderModel->delete($id);
            $_SESSION['flash_success'] = "Data cucian berhasil dihapus!";
        }
        header("Location: index.php?action=dashboard");
        exit;
    }

    public function track() {
        $this->requireLogin();
        $hasilCari = null;
        $pesanCari = '';

        if (!empty($_GET['kode'])) {
            $kode = trim($_GET['kode']);
            $hasilCari = $this->orderModel->getByKode($kode);
            if (!$hasilCari) {
                $pesanCari = "Kode order <strong>" . htmlspecialchars($kode) . "</strong> tidak ditemukan.";
            }
        }

        $myOrders = $this->orderModel->getByUserId($_SESSION['user_id']);
        require __DIR__ . '/../views/laundry/track.php';
    }
}