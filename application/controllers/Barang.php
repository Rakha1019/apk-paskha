<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // 1. WAJIB LOAD MODEL DI SINI AGAR TIDAK ERROR NULL
        $this->load->model('Barang_model');
        
        $this->load->library('session');
        
        // Atur zona waktu
        date_default_timezone_set('Asia/Jakarta');

        // Matikan Cache Browser untuk keamanan tombol Back
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

        // Cek apakah sudah login
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $this->load->library('pagination');

        // Tangkap keyword dan limit dari GET atau POST
        $keyword = $this->input->get('keyword_barang') ?: $this->input->post('keyword_barang');
        $limit   = $this->input->get('limit') ?: $this->input->post('limit');
        
        if (!$limit || !is_numeric($limit)) {
            $limit = 10; // Default limit 10 baris
        }

        // --- KONFIGURASI PAGING & STYLING BOOTSTRAP 5 ---
        $config['base_url'] = base_url('index.php/barang/index');
        $config['per_page'] = (int)$limit;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open']    = '<ul class="pagination pagination-md justify-content-end mb-0 shadow-sm">';
        $config['full_tag_close']   = '</ul>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link" href="#" style="background-color: #0f766e; border-color: #0f766e; color: white;">';
        $config['cur_tag_close']    = '</a></li>';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']   = '</li>';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']   = '</li>';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close']  = '</li>';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']   = '</li>';
        $config['attributes']       = ['class' => 'page-link text-success fw-bold'];

        // --- 1. HITUNG TOTAL DATA (DIFILTER KHUSUS ALAT ELEKTRONIK, KECUALIKAN KENDARAAN) ---
        $this->db->like('kode_barang', 'ELK-', 'after');
        $this->db->where('kategori !=', 'Sepeda Motor');
        $this->db->where('kategori !=', 'Mobil');
        $this->db->where('kategori !=', 'Station Wagon');
        
        if ($keyword) {
            $this->db->group_start(); 
            $this->db->like('nama', $keyword);
            $this->db->or_like('kode_barang', $keyword);
            $this->db->or_like('merk', $keyword);
            $this->db->group_end();
        }
        $config['total_rows'] = $this->db->get('g_barang')->num_rows();

        $this->pagination->initialize($config);

        // --- SIAPKAN DATA UNTUK DIKIRIM KE VIEW ---
        $data['start']   = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $data['keyword'] = $keyword ? $keyword : '';
        $data['limit']   = $limit; 

        // --- 2. AMBIL DATA BARANG (DIFILTER KHUSUS ALAT ELEKTRONIK, KECUALIKAN KENDARAAN) ---
        $this->db->like('kode_barang', 'ELK-', 'after');
        $this->db->where('kategori !=', 'Sepeda Motor');
        $this->db->where('kategori !=', 'Mobil');
        $this->db->where('kategori !=', 'Station Wagon');

        if ($keyword) {
            $this->db->group_start(); 
            $this->db->like('nama', $keyword);
            $this->db->or_like('kode_barang', $keyword);
            $this->db->or_like('merk', $keyword);
            $this->db->group_end();
        }
        $this->db->order_by('id', 'DESC');
        $data['barang'] = $this->db->get('g_barang', $config['per_page'], $data['start'])->result_array();

        $this->load->view('tampil_barang', $data);
    }

    // Fungsi tambahan untuk mereset pencarian
    public function reset_search()
    {
        $this->session->unset_userdata('keyword_barang');
        redirect('barang/index');
    }

    // Menangkap data dari form dan menyimpannya
    public function proses_simpan_riwayat()
    {
        $id_barang = $this->input->post('id_barang');

        $data = array(
            'id_barang'     => $this->input->post('id_barang'),
            'kode_barang'   => $this->input->post('kode_barang'),
            'tanggal_lapor' => $this->input->post('tanggal_lapor'),
            'keluhan'       => $this->input->post('keluhan'),
            'tindakan'      => $this->input->post('tindakan'),
            'nama_teknisi'  => $this->input->post('nama_teknisi'),
            'status'        => $this->input->post('status')
        );

        // Panggil fungsi model untuk menyimpan
        $this->Barang_model->simpan_riwayat_baru($data);

        // Kalau sukses, otomatis kembalikan ke halaman riwayat barang tersebut
        redirect('barang/riwayat/' . $id_barang);
    }

    public function hapus_riwayat($id_servis, $id_barang)
    {
        // 1. Ambil data riwayat dari database SEBELUM dihapus (untuk mencari nama fotonya)
        $riwayat = $this->db->get_where('riwayat_servis', ['id_servis' => $id_servis])->row_array();

        // 2. Hapus file foto dari folder 'assets/img/riwayat/' JIKA fotonya ada
        if (!empty($riwayat['foto_riwayat']) && file_exists('./assets/img/riwayat/' . $riwayat['foto_riwayat'])) {
            unlink('./assets/img/riwayat/' . $riwayat['foto_riwayat']); // Fungsi sakti untuk menghapus file
        }

        // 3. Setelah file fisiknya dihapus, baru hapus datanya dari database
        $this->db->where('id_servis', $id_servis);
        $this->db->delete('riwayat_servis');
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show">Riwayat pemeliharaan beserta fotonya berhasil <b>dihapus!</b><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        
        redirect('barang/riwayat_global'); 
    }

    // Membuka form edit dengan membawa data lama
    public function edit_riwayat($id_servis, $kode_barang)
    {
        $data['riwayat'] = $this->Barang_model->get_riwayat_by_id($id_servis);
        $data['kode_barang'] = $kode_barang; // Bawa kode barang untuk tombol kembali
        $this->load->view('form_edit_riwayat', $data);
    }

    // Fungsi menangkap data edit dan menyimpannya
    public function proses_edit_riwayat()
    {
        $id_servis = $this->input->post('id_servis');
        $id_barang = $this->input->post('id_barang'); // Tangkap ID untuk rute kembali

        $data = array(
            'id_barang'     => $this->input->post('id_barang'),
            'kode_barang'   => $this->input->post('kode_barang'),
            'tanggal_lapor' => $this->input->post('tanggal_lapor'),
            'keluhan'       => $this->input->post('keluhan'),
            'tindakan'      => $this->input->post('tindakan'),
            'nama_teknisi'  => $this->input->post('nama_teknisi'),
            'status'        => $this->input->post('status')
        );

        // Panggil fungsi model (pastikan nama fungsi update model-mu sesuai)
        $this->Barang_model->update_riwayat($id_servis, $data);
        
        // Kirim notifikasi berhasil diedit (warna hijau/success)
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show">Riwayat servis berhasil <b>diperbarui!</b><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        
        redirect('barang/riwayat/' . $id_barang);
    }

    public function cetak()
    {
        // Ambil semua data barang elektronik dari database
        $data['list_barang'] = $this->Barang_model->get_semua_barang_cetak();
        
        // Buka halaman khusus cetak
        $this->load->view('cetak_barang', $data);
    }

    public function tambah_barang()
    {
        $this->db->select_max('id');
        $query = $this->db->get('g_barang')->row_array();
        $id_selanjutnya = (isset($query['id'])) ? $query['id'] + 1 : 1;
        $data['kode_otomatis'] = 'ELK-' . date('ym') . '-' . sprintf('%03d', $id_selanjutnya);

        // --- KODE AJAIB: Membuat tabel kategori_elektronik otomatis jika belum ada ---
        if (!$this->db->table_exists('kategori_elektronik')) {
            $this->load->dbforge();
            $this->dbforge->add_field([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE],
                'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => 150]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('kategori_elektronik');
            
            // Pindahkan data kategori lama dari g_barang agar tidak kosong
            $kategori_lama = $this->db->select('nama')->distinct()->where('kategori', 'Elektronik')->get('g_barang')->result_array();
            foreach($kategori_lama as $k) {
                $this->db->insert('kategori_elektronik', ['nama_kategori' => $k['nama']]);
            }
        }

        // Ambil daftar kategori dari tabel baru
        $this->db->order_by('nama_kategori', 'ASC');
        $data['kategori_tersedia'] = $this->db->get('kategori_elektronik')->result_array();

        $this->load->view('form_tambah_barang', $data);
    }

    public function proses_simpan_barang()
    {
        $kode_barang = $this->input->post('kode_barang');
        $kategori    = $this->input->post('pilihan_kategori'); 
        $nama_barang = $this->input->post('nama_barang');     
        $merk        = $this->input->post('merk');            
        $kondisi     = $this->input->post('kondisi');

        $nama_foto = null; 
        
        // Buat folder otomatis jika belum ada
        $folder_path = './assets/img/barang/';
        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, TRUE);
        }

        // --- PROSES UPLOAD FOTO ---
        if (!empty($_FILES['foto']['name'])) {
            
            // 1. PENGECEKAN EKSTENSI MANUAL (Lebih canggih & aman dari error CI3)
            $nama_file_asli = $_FILES['foto']['name'];
            $ext = strtolower(pathinfo($nama_file_asli, PATHINFO_EXTENSION));
            $format_aman = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif', 'avif');

            // Jika ekstensi tidak ada di daftar format aman, tolak!
            if (!in_array($ext, $format_aman)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle-fill me-2"></i><b>Gagal Upload:</b> Format file tidak didukung! Harap gunakan format gambar (JPG, PNG, WEBP, dll).<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                redirect('barang/tambah_barang');
                return;
            }

            // 2. KONFIGURASI UPLOAD
            $config['upload_path']   = $folder_path;
            $config['allowed_types'] = '*'; // Bypass batasan CI3 karena sudah dicek manual di atas
            $config['max_size']      = 10240; // Maksimal 10 MB
            $config['file_name']     = 'Alat_' . $kode_barang . '_' . time();
            
            $this->load->library('upload');
            $this->upload->initialize($config);

            // 3. EKSEKUSI UPLOAD
            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $nama_foto = $uploadData['file_name'];
            } else {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle-fill me-2"></i><b>Gagal Upload Foto:</b> ' . $error . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                redirect('barang/tambah_barang');
                return; 
            }
        }

        // --- SIMPAN DATA KE DATABASE ---
        $data = array(
            'kode_barang' => $kode_barang,
            'nama'        => $nama_barang, 
            'merk'        => $merk,        
            'kondisi'     => $kondisi,
            'kategori'    => $kategori,    
            'foto'        => $nama_foto 
        );

        $this->Barang_model->simpan_barang_baru($data);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle-fill me-2"></i>Data alat elektronik berhasil <b>ditambahkan!</b><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        redirect('barang/index');
    }

    public function halaman_tambah_kategori()
    {
        // 1. Ambil semua data kategori dari database untuk ditampilkan di sebelah kanan
        if ($this->db->table_exists('kategori_elektronik')) {
            $this->db->order_by('nama_kategori', 'ASC');
            $data['kategori_tersedia'] = $this->db->get('kategori_elektronik')->result_array();
        } else {
            $data['kategori_tersedia'] = [];
        }

        $this->load->view('form_tambah_kategori', $data);
    }

    public function simpan_kategori()
    {
        $nama_kategori = $this->input->post('nama_kategori');
        $this->db->insert('kategori_elektronik', ['nama_kategori' => $nama_kategori]);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show">Kategori <b>' . $nama_kategori . '</b> berhasil ditambahkan!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        
        // Kembalikan ke halaman ini lagi agar user bisa melihat kategorinya langsung muncul di daftar
        redirect('barang/halaman_tambah_kategori'); 
    }

    public function hapus_kategori($id)
    {
        // 2. Fungsi untuk menghapus kategori berdasarkan ID
        $this->db->where('id', $id);
        $this->db->delete('kategori_elektronik');
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show">Kategori berhasil <b>dihapus!</b><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        redirect('barang/halaman_tambah_kategori');
    }

    public function hapus($id)
    {
        // 1. Ambil data barang dari database SEBELUM dihapus (untuk mencari nama fotonya)
        $barang = $this->db->get_where('g_barang', ['id' => $id])->row_array();

        // 2. Hapus file foto dari folder 'assets/img/barang/' JIKA fotonya ada
        if (!empty($barang['foto']) && file_exists('./assets/img/barang/' . $barang['foto'])) {
            unlink('./assets/img/barang/' . $barang['foto']); // Fungsi sakti untuk menghapus file
        }

        // 3. Setelah file fisiknya dihapus, baru hapus datanya dari database
        $this->Barang_model->hapus_barang($id);
        
        $this->load->library('session');
        $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show">Data alat elektronik beserta fotonya berhasil <b>dihapus!</b><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect('barang/index');
    }

    // Fungsi untuk membuka form edit dan membawa data lama
    public function edit($id)
    {
        // Mengambil data spesifik berdasarkan ID
        $data['barang'] = $this->db->get_where('g_barang', ['id' => $id])->row_array();
        
        // Memuat tampilan form edit
        $this->load->view('form_edit_barang', $data);
    }

    // Fungsi untuk menangkap data dari form edit dan menyimpannya ke database
    public function proses_edit()
    {
        $id = $this->input->post('id');
        $kode_barang = $this->input->post('kode_barang');
        
        $data = array(
            'kode_barang' => $kode_barang,
            'nama'        => $this->input->post('nama'),
            'merk'        => $this->input->post('merk'),
            'kondisi'     => $this->input->post('kondisi')
        );

        // Cek apakah user mengunggah file foto baru
        if (!empty($_FILES['foto']['name'])) {
            
            // --- SATPAM MANUAL (KEAMANAN MUTLAK) ---
            $nama_asli = $_FILES['foto']['name'];
            $ext = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
            $ext_aman = array('jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif', 'avif');

            if (!in_array($ext, $ext_aman)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show"><b>Gagal Upload Foto:</b> Format file .' . $ext . ' tidak diizinkan! Hanya boleh JPG/PNG/WEBP.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                redirect('barang/edit/'.$id); 
                return;
            }
            // ----------------------------------------

            // Karena sudah dicek manual, kita suruh CI3 tutup mata (pakai bintang *)
            $config['upload_path']   = './assets/img/barang/';
            $config['allowed_types'] = '*'; 
            $config['max_size']      = 10240; 
            $config['file_name']     = 'Alat_' . $kode_barang . '_' . time();
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $nama_foto = $uploadData['file_name'];

                // KOMPRESI OTOMATIS
                $config_img['image_library']  = 'gd2';
                $config_img['source_image']   = './assets/img/barang/' . $nama_foto;
                $config_img['maintain_ratio'] = TRUE;
                $config_img['width']          = 800; 
                $config_img['quality']        = '60%'; 
                
                $this->load->library('image_lib', $config_img);
                $this->image_lib->resize();

                // Hapus foto lama
                $barang_lama = $this->db->get_where('g_barang', ['id' => $id])->row_array();
                if (!empty($barang_lama['foto']) && file_exists('./assets/img/barang/' . $barang_lama['foto'])) {
                    unlink('./assets/img/barang/' . $barang_lama['foto']); 
                }

                // Masukkan nama file baru ke database
                $data['foto'] = $nama_foto;
            } else {
                $error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show"><b>Gagal Upload Foto:</b> ' . $error . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                redirect('barang/edit/'.$id);
                return;
            }
        }

        // Panggil model untuk update database
        $this->Barang_model->update_barang($id, $data);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show">Data alat elektronik berhasil <b>diperbarui!</b><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect('barang/index');
    }
    
    public function reset()
    {
        // Hapus memori pencarian agar kembali menampilkan semua data
        $this->session->unset_userdata('keyword_barang');
        redirect('barang/index');
    }

    public function dashboard()
    {
        $this->load->model('Barang_model');
        // Data statistik angka
        $data['statistik'] = $this->Barang_model->get_statistik_dashboard();
        
        // Data riwayat terbaru (grafik/tabel tengah)
        $data['riwayat_terbaru'] = $this->Barang_model->get_riwayat_terbaru(5);
        
        // Rincian Daftar Alat sesuai kondisinya (Maksimal 5 terbaru per kondisi)
        $data['list_baik']   = $this->Barang_model->get_barang_by_kondisi(1, 5);
        $data['list_ringan'] = $this->Barang_model->get_barang_by_kondisi(2, 5);
        $data['list_berat']  = $this->Barang_model->get_barang_by_kondisi(3, 5);
        
        $this->load->view('dashboard_view', $data);
    }

    // Menampilkan halaman semua riwayat servis di sidebar
    public function riwayat_global()
    {
        $data['riwayat'] = $this->Barang_model->get_semua_riwayat_global();
        $this->load->view('riwayat_global_view', $data);
    }

    public function tambah_servis_global()
    {
        // Ambil semua data barang elektronik
        $this->db->where('kategori !=', ''); // Ambil yang ada kategorinya
        $this->db->order_by('nama', 'ASC');
        $data['list_barang'] = $this->db->get('g_barang')->result_array();
        
        // Ambil kategori dari tabel master kategori_elektronik
        if ($this->db->table_exists('kategori_elektronik')) {
            $this->db->order_by('nama_kategori', 'ASC');
            $data['kategori_unik'] = $this->db->get('kategori_elektronik')->result_array();
        } else {
            $data['kategori_unik'] = [];
        }
        
        $this->load->view('form_tambah_servis_global', $data);
    }

    public function proses_simpan_servis_global()
    {
        $id_barang = $this->input->post('id_barang');
        $kondisi_baru = $this->input->post('kondisi'); 
        $status_baru = $this->input->post('status'); // <-- AMBIL DATA STATUS
        
        $barang = $this->db->get_where('g_barang', ['id' => $id_barang])->row_array();
        
        $nama_foto = null;
        if (!empty($_FILES['foto_riwayat']['name'])) {
            $nama_asli = $_FILES['foto_riwayat']['name'];
            $ext = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
            $ext_aman = array('jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif', 'avif');

            if (!in_array($ext, $ext_aman)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show"><b>Gagal Upload Foto:</b> Format file tidak diizinkan!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                redirect('barang/tambah_servis_global'); 
                return;
            }

            $config['upload_path']   = './assets/img/riwayat/';
            $config['allowed_types'] = '*'; 
            $config['max_size']      = 10240; 
            $config['file_name']     = 'Riwayat_' . $barang['kode_barang'] . '_' . time();
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_riwayat')) {
                $uploadData = $this->upload->data();
                $nama_foto = $uploadData['file_name'];

                $config_img['image_library']  = 'gd2';
                $config_img['source_image']   = './assets/img/riwayat/' . $nama_foto;
                $config_img['maintain_ratio'] = TRUE;
                $config_img['width']          = 800; 
                $config_img['quality']        = '60%'; 
                
                $this->load->library('image_lib', $config_img);
                $this->image_lib->resize();
            }
        }

        $data_servis = array(
            'id_barang'     => $id_barang,
            'kode_barang'   => $barang['kode_barang'],
            'tanggal_lapor' => $this->input->post('tanggal_lapor'),
            'keluhan'       => $this->input->post('keluhan'),
            'tindakan'      => $this->input->post('tindakan'),
            'kondisi'       => $kondisi_baru,
            'status'        => $status_baru, // <-- MASUKKAN KE ARRAY DATABASE
            'foto_riwayat'  => $nama_foto 
        );

        $this->db->insert('riwayat_servis', $data_servis);
        
        $this->db->where('id', $id_barang);
        $this->db->update('g_barang', ['kondisi' => $kondisi_baru]);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show">Riwayat pemeliharaan berhasil ditambahkan!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect('barang/riwayat_global');
    }

    // 1. Menampilkan form edit riwayat servis global
    public function edit_servis_global($id_servis)
    {
        // Ambil data riwayat berdasarkan ID Servis
        $data['servis'] = $this->db->get_where('riwayat_servis', ['id_servis' => $id_servis])->row_array();
        
        // Ambil semua data barang untuk pilihan dropdown
        $this->db->like('kode_barang', 'ELK-', 'after');
        $this->db->order_by('nama', 'ASC');
        $data['list_barang'] = $this->db->get('g_barang')->result_array();
        
        $this->load->view('form_edit_servis_global', $data);
    }

    // 2. Memproses perubahan data dari form edit riwayat servis
    public function proses_update_servis_global()
    {
        $id_servis  = $this->input->post('id_servis');
        $id_barang  = $this->input->post('id_barang');
        $kondisi_baru = $this->input->post('kondisi');
        $status_baru = $this->input->post('status'); // <-- AMBIL DATA STATUS BARU
        
        $barang = $this->db->get_where('g_barang', ['id' => $id_barang])->row_array();
        $riwayat_lama = $this->db->get_where('riwayat_servis', ['id_servis' => $id_servis])->row_array();
        
        $data_servis = array(
            'id_barang'     => $id_barang,
            'kode_barang'   => $barang['kode_barang'],
            'tanggal_lapor' => $this->input->post('tanggal_lapor'),
            'keluhan'       => $this->input->post('keluhan'),
            'tindakan'      => $this->input->post('tindakan'),
            'kondisi'       => $kondisi_baru,
            'status'        => $status_baru // <-- UPDATE JUGA KE DATABASE
        );

        if (isset($_FILES['foto_riwayat']) && $_FILES['foto_riwayat']['error'] == 0 && !empty($_FILES['foto_riwayat']['name'])) {
            $nama_asli = $_FILES['foto_riwayat']['name'];
            $ext = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
            $ext_aman = array('jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif', 'avif');

            if (!in_array($ext, $ext_aman)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show">Format file tidak diizinkan!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                redirect('barang/edit_servis_global/'.$id_servis); 
                return;
            }

            $config['upload_path']   = './assets/img/riwayat/'; 
            $config['allowed_types'] = '*'; 
            $config['max_size']      = 10240; 
            $config['file_name']     = 'Riwayat_' . preg_replace('/[^A-Za-z0-9\-]/', '', $barang['kode_barang']) . '_' . time();
            
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_riwayat')) {
                $uploadData = $this->upload->data();
                $nama_foto = $uploadData['file_name'];

                if (!empty($riwayat_lama['foto_riwayat']) && file_exists('./assets/img/riwayat/' . $riwayat_lama['foto_riwayat'])) {
                    unlink('./assets/img/riwayat/' . $riwayat_lama['foto_riwayat']); 
                }
                $data_servis['foto_riwayat'] = $nama_foto;
            }
        }

        $this->db->where('id_servis', $id_servis);
        $this->db->update('riwayat_servis', $data_servis);
        
        $this->db->where('id', $id_barang);
        $this->db->update('g_barang', ['kondisi' => $kondisi_baru]);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show">Riwayat pemeliharaan berhasil diperbarui!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect('barang/riwayat_global');
    }
}