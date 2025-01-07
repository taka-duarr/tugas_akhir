<?php
require_once 'Connect/Database.php';
class ModelKurir {
    private $db;

    public function __construct() {
        $this->connectDatabase();
    }

    
    
    public function connectDatabase() {
        $database = new Database(); // Membuat instance dari class Database
        $this->db = $database->connect(); // Mengambil koneksi dari class Database
    }

    

    public function getTransaksiByKurir($nama_kurir) {
        // Siapkan query dengan placeholder
        $query = "
            SELECT 
                t.id_transaksi, t.tanggal, t.total_harga AS total_all, t.alamat, t.status, t.nama_kurir, t.ongkir, t.total_afterongkir,
                d.id_barang, d.jumlah, d.total_harga ,
                b.nama_barang, b.harga_barang
            FROM db_transaksi t
            LEFT JOIN db_detail_transaksi d ON t.id_transaksi = d.id_transaksi
            LEFT JOIN db_barang b ON d.id_barang = b.id_barang
            WHERE t.nama_kurir = ?
            ORDER BY t.tanggal DESC
        ";
    
        // Siapkan prepared statement
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Failed to prepare statement: " . $this->db->error);
        }
    
        // Bind parameter
        $stmt->bind_param("s", $nama_kurir);
    
        // Eksekusi query
        $stmt->execute();
    
        // Ambil hasil
        $result = $stmt->get_result();
    
        // Konversi hasil menjadi array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        // Tutup statement
        $stmt->close();
    
        return $data;
    }
    
}
?>