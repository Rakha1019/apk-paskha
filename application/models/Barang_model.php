<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    public function hitung_jumlah_barang($keyword = null)
    {
        $this->db->where('kategori', 'Elektronik');
        
        // Jika ada pencarian
        if ($keyword) {
            $this->db->group_start(); // Buka kurung query
            $this->db->like('nama', $keyword);
            $this->db->or_like('kode_barang', $keyword);
            $this->db->or_like('merk', $keyword);
            $this->db->group_end(); // Tutup kurung query
        }
        
        return $this->db->get('g_barang')->num_rows();
    }

    // Mengambil data barang, dilengkapi pencarian
    public function get_semua_barang($limit, $start, $keyword = null)
    {
        $this->db->where('kategori', 'Elektronik');
        
        // Jika ada pencarian
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama', $keyword);
            $this->db->or_like('kode_barang', $keyword);
            $this->db->or_like('merk', $keyword);
            $this->db->group_end();
        }
        
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get('g_barang')->result_array();
    }
    // Fungsi mengambil 1 barang berdasarkan kodenya
    public function get_barang_by_kode($kode_barang)
    {
        $this->db->where('kode_barang', $kode_barang);
        return $this->db->get('g_barang')->row_array();
    }

    // Fungsi mengambil daftar riwayat servis berdasarkan kode barang
    public function get_riwayat_by_kode($kode_barang)
    {
        $this->db->where('kode_barang', $kode_barang);
        $this->db->order_by('tanggal_lapor', 'DESC'); // Mengurutkan dari yang terbaru
        return $this->db->get('riwayat_servis')->result_array();
    }

        public function simpan_riwayat_baru($data)
    {
        $this->db->insert('riwayat_servis', $data);
    }
    // Fungsi untuk menghapus riwayat servis
    public function hapus_riwayat($id_servis)
    {
        $this->db->where('id_servis', $id_servis);
        $this->db->delete('riwayat_servis');
    }
    // Fungsi mengambil 1 riwayat spesifik berdasarkan ID
    public function get_riwayat_by_id($id_servis)
    {
        $this->db->where('id_servis', $id_servis);
        return $this->db->get('riwayat_servis')->row_array();
    }

    // Fungsi menyimpan perubahan data (Update)
    public function update_riwayat($id_servis, $data)
    {
        $this->db->where('id_servis', $id_servis);
        $this->db->update('riwayat_servis', $data);
    }
    // Menghitung total barang elektronik
    public function hitung_elektronik()
    {
        $this->db->where('kategori', 'Elektronik');
        return $this->db->count_all_results('g_barang');
    }

    // Menghitung total riwayat servis berdasarkan statusnya
    public function hitung_status_servis($status)
    {
        $this->db->where('status', $status);
        return $this->db->count_all_results('riwayat_servis');
    }

    public function simpan_barang_baru($data)
    {
        $this->db->insert('g_barang', $data);
    }
    // Fungsi menghapus barang berdasarkan kodenya
    public function hapus_barang($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('g_barang');
    }

    // Menghitung statistik untuk Diagram Dashboard
    public function get_statistik_kondisi()
    {
        $query = $this->db->query("
            SELECT 
                SUM(CASE WHEN kondisi = 1 THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN kondisi = 2 THEN 1 ELSE 0 END) as rusak_ringan,
                SUM(CASE WHEN kondisi = 3 THEN 1 ELSE 0 END) as rusak_berat,
                COUNT(id) as total_barang
            FROM g_barang
        ");
        return $query->row_array();
    }
    public function update_barang($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('g_barang', $data);
    }
    // Fungsi khusus untuk menghitung statistik Dashboard (Hanya kategori Elektronik)
    public function get_statistik_dashboard()
    {
        // Hitung Total Alat Elektronik
        $this->db->where('kategori', 'Elektronik');
        $total = $this->db->get('g_barang')->num_rows();

        // Hitung Kondisi Baik (Angka 1)
        $this->db->where('kategori', 'Elektronik');
        $this->db->where('kondisi', 1);
        $baik = $this->db->get('g_barang')->num_rows();

        // Hitung Rusak Ringan (Angka 2)
        $this->db->where('kategori', 'Elektronik');
        $this->db->where('kondisi', 2);
        $rusak_ringan = $this->db->get('g_barang')->num_rows();

        // Hitung Rusak Berat (Angka 3)
        $this->db->where('kategori', 'Elektronik');
        $this->db->where('kondisi', 3);
        $rusak_berat = $this->db->get('g_barang')->num_rows();

        // Kembalikan semua data dalam bentuk array
        return array(
            'total_barang' => $total,
            'baik'         => $baik,
            'rusak_ringan' => $rusak_ringan,
            'rusak_berat'  => $rusak_berat
        );
    }

    // Fungsi untuk mengambil 5 riwayat servis terbaru khusus kategori Elektronik
    public function get_riwayat_terbaru($limit = 5)
    {
        $this->db->select('riwayat_servis.*, g_barang.nama');
        $this->db->from('riwayat_servis');
        
        // UBAH BARIS INI: Hubungkan ID dari g_barang ke id_barang milik riwayat_servis
        $this->db->join('g_barang', 'g_barang.id = riwayat_servis.id_barang');
        
        $this->db->where('g_barang.kategori', 'Elektronik');
        $this->db->order_by('riwayat_servis.tanggal_lapor', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
    // Fungsi khusus untuk mencetak SEMUA data tanpa pagination (limit)
    public function get_semua_barang_cetak()
    {
        $this->db->where('kategori', 'Elektronik');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('g_barang')->result_array();
    }

    // Fungsi untuk mengambil SEMUA riwayat servis (Global)
    public function get_semua_riwayat_global()
    {
        // Pastikan kita mengambil SEMUA kolom dari riwayat_servis (menggunakan riwayat_servis.*)
        $this->db->select('riwayat_servis.*, g_barang.nama');
        $this->db->from('riwayat_servis');
        // Join ke tabel barang agar nama alatnya muncul
        $this->db->join('g_barang', 'riwayat_servis.id_barang = g_barang.id', 'left');
        $this->db->order_by('riwayat_servis.id_servis', 'DESC'); // Urutkan dari yang terbaru
        
        return $this->db->get()->result_array();
    }
    // Mengambil daftar barang berdasarkan status kondisinya (1=Baik, 2=Ringan, 3=Berat)
    public function get_barang_by_kondisi($kondisi, $limit = 5)
    {
        $this->db->where('kategori', 'Elektronik');
        $this->db->where('kondisi', $kondisi);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('g_barang', $limit)->result_array();
    }
}