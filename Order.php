<?php
class Order {
    private $conn;
    private $table = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($search = '', $status = '') {
        $query = "SELECT * FROM " . $this->table . " WHERE 1=1";
        if (!empty($search)) {
            $query .= " AND (kode_order LIKE :search OR nama_pelanggan LIKE :search)";
        }
        if (!empty($status)) {
            $query .= " AND status = :status";
        }
        $query .= " ORDER BY tanggal_masuk DESC";

        $stmt = $this->conn->prepare($query);
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam);
        }
        if (!empty($status)) {
            $stmt->bindParam(':status', $status);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY tanggal_masuk DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByKode($kode_order) {
        $query = "SELECT * FROM " . $this->table . " WHERE kode_order = :kode LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kode', $kode_order);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (kode_order, user_id, nama_pelanggan, no_hp, berat_kg, jenis_layanan, total_harga, status, catatan) 
                  VALUES (:kode_order, :user_id, :nama_pelanggan, :no_hp, :berat_kg, :jenis_layanan, :total_harga, :status, :catatan)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET user_id = :user_id,
                      nama_pelanggan = :nama_pelanggan,
                      no_hp = :no_hp,
                      berat_kg = :berat_kg,
                      jenis_layanan = :jenis_layanan,
                      total_harga = :total_harga,
                      status = :status,
                      catatan = :catatan
                  WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'masuk' THEN 1 ELSE 0 END) as masuk,
                    SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) as diproses,
                    SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai
                  FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}