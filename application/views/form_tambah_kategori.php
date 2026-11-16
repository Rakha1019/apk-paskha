<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - SIMELEK PA SKH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; overflow-x: hidden; color: #2b3674; }
        
        /* SIDEBAR MODERN */
        #sidebar { width: 260px; background-color: #0f766e; min-height: 100vh; color: white; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; box-shadow: 4px 0 20px rgba(0,0,0,0.05); }
        .sidebar-header { padding: 25px; display: flex; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 15px; }
        .sidebar-nav { list-style: none; padding: 0; margin: 0; }
        .sidebar-nav li { margin-bottom: 8px; padding: 0 20px; }
        .sidebar-nav .nav-link { color: rgba(255, 255, 255, 0.7); padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; text-decoration: none; font-size: 0.95rem; transition: all 0.3s ease; white-space: nowrap; overflow: hidden; }
        .sidebar-nav .nav-link i { margin-right: 15px; font-size: 1.2rem; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { background-color: rgba(255, 255, 255, 0.15); color: white; font-weight: 600; transform: translateX(5px); }
        
        /* KONTEN UTAMA */
        #main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        .top-header { background: white; padding: 15px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .card-custom { border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; padding: 35px; }
        
        /* FORM & BUTTON STYLING */
        .form-label { font-weight: 700; color: #2b3674; font-size: 0.9rem; margin-bottom: 10px; }
        .form-control { border-radius: 12px; padding: 12px 18px; border: 1px solid #e2e8f0; background-color: #f8fafc; color: #2b3674; transition: all 0.3s ease; }
        .form-control:focus { border-color: #0f766e; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1); }
        .btn-simpan { background-color: #0f766e; color: white; border: none; border-radius: 12px; font-weight: 600; padding: 12px 25px; transition: all 0.3s ease; }
        .btn-simpan:hover { background-color: #0d5f59; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(15, 118, 110, 0.3); color: white; }
        .btn-back { border-radius: 12px; font-weight: 600; padding: 10px 20px; background-color: white; color: #64748b; border: 1px solid #e2e8f0; transition: all 0.3s ease; }
        .btn-back:hover { background-color: #f1f5f9; color: #0f766e; }

        /* LIST KATEGORI */
        .list-kategori { max-height: 350px; overflow-y: auto; padding-right: 5px; }
        .list-kategori::-webkit-scrollbar { width: 6px; }
        .list-kategori::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        .kategori-item { border-radius: 10px; transition: all 0.2s; border: 1px solid #e2e8f0; margin-bottom: 8px; }
        .kategori-item:hover { border-color: #0f766e; background-color: #f0fdfa; }
        .btn-hapus { opacity: 0.7; transition: all 0.2s; }
        .kategori-item:hover .btn-hapus { opacity: 1; }
    </style>
</head>
<body>

    <div id="sidebar">
        <a href="<?= base_url('index.php/barang/dashboard'); ?>" class="sidebar-header text-decoration-none text-white">
            <img src="<?= base_url('assets/img/PA SKH Glossy.png'); ?>" alt="Logo" width="40" class="me-3 shadow-sm rounded-circle">
            <h5 class="mb-0 fw-bold" style="letter-spacing: 1px;">SIMELEK</h5>
        </a>
        <ul class="sidebar-nav mt-2">
            <li><a href="<?= base_url('index.php/barang/dashboard'); ?>" class="nav-link"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
            <li><a href="<?= base_url('index.php/barang/index'); ?>" class="nav-link active"><i class="bi bi-box-seam-fill"></i> Data Barang</a></li>
            <li><a href="<?= base_url('index.php/barang/riwayat_global'); ?>" class="nav-link"><i class="bi bi-tools"></i> Riwayat Pemeliharaan</a></li>
        </ul>
    </div>

    <div id="main-content">
        
        <div class="top-header">
            <div><h4 class="mb-0 fw-bold" style="color: #2b3674;">Kelola Kategori Alat</h4></div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark bg-light px-3 py-2 rounded-pill shadow-sm" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                        <?= $this->session->userdata('username') ? strtoupper(substr($this->session->userdata('username'), 0, 1)) : 'A'; ?>
                    </div>
                    <span class="me-1 fw-bold fs-6 text-primary">
                        <?= $this->session->userdata('username') ? ucfirst($this->session->userdata('username')) : 'Admin'; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                    <li><a class="dropdown-item text-danger fw-bold py-2" href="<?= base_url('index.php/auth/logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Log out</a></li>
                </ul>
            </div>
        </div>

        <a href="<?= base_url('index.php/barang/tambah_barang'); ?>" class="btn btn-back mb-4 shadow-sm text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Form Tambah Alat
        </a>

        <?php if($this->session->flashdata('pesan')): ?>
            <?= $this->session->flashdata('pesan'); ?>
        <?php endif; ?>

        <div class="card card-custom border-top border-5 border-success" style="max-width: 950px; border-top-color: #0f766e !important;">
            
            <div class="row g-5">
                <!-- KOLOM KIRI: FORM TAMBAH -->
                <div class="col-md-5 border-end">
                    <h5 class="fw-bold mb-2 text-dark"><i class="bi bi-plus-circle-fill me-2 text-primary"></i> Kategori Baru</h5>
                    <p class="text-muted small mb-4">Tambahkan nama kategori alat elektronik baru di sini.</p>

                    <form action="<?= base_url('index.php/barang/simpan_kategori'); ?>" method="POST">
                        <div class="mb-4">
                            <label class="form-label" style="color: #0f766e;">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kategori" class="form-control border-primary" style="background-color: #f0f9ff; border-width: 2px;" placeholder="Cth: Mesin Penghancur Kertas" required autofocus>
                        </div>
                        
                        <button type="submit" class="btn btn-simpan shadow-sm w-100">
                            <i class="bi bi-save me-2"></i> Simpan Kategori
                        </button>
                    </form>
                </div>

                <!-- KOLOM KANAN: DAFTAR KATEGORI & HAPUS -->
                <div class="col-md-7">
                    <h5 class="fw-bold mb-2 text-dark"><i class="bi bi-list-check me-2 text-primary"></i> Daftar Kategori Tersedia</h5>
                    <p class="text-muted small mb-3">Berikut adalah kategori yang bisa dipilih. Hapus yang tidak terpakai.</p>
                    
                    <div class="p-3 bg-light rounded-4 border">
                        <div class="list-kategori">
                            <?php if(empty($kategori_tersedia)): ?>
                                <div class="text-center text-muted py-4"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada kategori</div>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach($kategori_tersedia as $kat): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center kategori-item bg-white">
                                        
                                        <!-- Nama Kategori: Diberi flex-grow-1 agar memenuhi sisa ruang dan tidak menabrak tombol -->
                                        <span class="fw-semibold text-dark flex-grow-1 pe-3" style="word-break: break-word;">
                                            <i class="bi bi-tag text-muted me-2"></i> <?= htmlspecialchars($kat['nama_kategori']); ?>
                                        </span>
                                        
                                        <!-- Tombol Hapus: Diberi flex-shrink-0 dan white-space: nowrap agar bentuknya terkunci mati -->
                                        <a href="<?= base_url('index.php/barang/hapus_kategori/'.$kat['id']); ?>" 
                                           class="btn btn-sm btn-outline-danger btn-hapus rounded-pill px-3 py-1 flex-shrink-0" style="white-space: nowrap;"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus kategori <?= htmlspecialchars($kat['nama_kategori']); ?> ini?');">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </a>
                                        
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>