<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Alat - SIMELEK PA SKH</title>
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
        .card-custom { border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; padding: 30px; }
        
        /* FORM STYLING */
        .form-label { font-weight: 700; color: #2b3674; font-size: 0.9rem; margin-bottom: 10px; }
        .form-control, .form-select { border-radius: 12px; padding: 12px 18px; border: 1px solid #e2e8f0; background-color: #f8fafc; color: #2b3674; transition: all 0.3s ease; }
        .form-control:focus, .form-select:focus { border-color: #0f766e; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1); }
        .btn-simpan { background-color: #0f766e; color: white; border: none; border-radius: 12px; font-weight: 600; padding: 12px 25px; transition: all 0.3s ease; }
        .btn-simpan:hover { background-color: #0d5f59; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(15, 118, 110, 0.3); color: white; }
        .btn-back { border-radius: 12px; font-weight: 600; padding: 10px 20px; background-color: white; color: #64748b; border: 1px solid #e2e8f0; transition: all 0.3s ease; }
        .btn-back:hover { background-color: #f1f5f9; color: #0f766e; }
    </style>
</head>
<body>

    <!-- SIDEBAR KIRI -->
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

    <!-- KONTEN UTAMA -->
    <div id="main-content">
        <!-- HEADER ATAS -->
        <div class="top-header">
            <div><h4 class="mb-0 fw-bold" style="color: #2b3674;">Edit Data Alat Elektronik</h4></div>
            
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark bg-light px-3 py-2 rounded-pill shadow-sm" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                        <?= $this->session->userdata('username') ? strtoupper(substr($this->session->userdata('username'), 0, 1)) : 'A'; ?>
                    </div>
                    <span class="me-1 fw-bold fs-6 text-primary">
                        <?= $this->session->userdata('username') ? ucfirst($this->session->userdata('username')) : 'Admin'; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                    <li><a class="dropdown-item text-danger fw-bold py-2" href="<?= base_url('index.php/auth/logout'); ?>" onclick="return confirm('Yakin ingin keluar?');"><i class="bi bi-box-arrow-right me-2"></i> Log out</a></li>
                </ul>
            </div>
        </div>

        <button type="button" onclick="history.back()" class="btn btn-back mb-4 shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Batal / Kembali
        </button>

        <!-- KARTU FORM -->
        <div class="card card-custom" style="max-width: 800px; border-top: 5px solid #f59e0b;">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i> Form Edit Barang</h5>

            <?php if($this->session->flashdata('pesan')): ?>
                <?= $this->session->flashdata('pesan'); ?>
            <?php endif; ?>
            
            <!-- Pastikan action ini mengarah ke fungsi update milikmu -->
            <form action="<?= base_url('index.php/barang/proses_edit/'.$barang['id']); ?>" method="POST" enctype="multipart/form-data">
                
                <!-- ID tersembunyi sebagai pengaman ganda -->
                <input type="hidden" name="id" value="<?= $barang['id']; ?>">
                
                <div class="mb-4">
                    <label class="form-label">Foto Alat Saat Ini</label>
                    <div class="mb-3">
                        <?php if(!empty($barang['foto']) && file_exists('./assets/img/barang/'.$barang['foto'])): ?>
                            <img id="preview-foto" src="<?= base_url('assets/img/barang/'.$barang['foto']); ?>" alt="Foto" width="120" class="img-thumbnail rounded-3 shadow-sm border-0">
                            <span id="teks-nofoto" class="badge bg-light text-muted border py-2 px-3 d-none"><i class="bi bi-image me-1"></i> Belum ada foto</span>
                        <?php else: ?>
                            <img id="preview-foto" src="#" alt="Preview" width="120" class="img-thumbnail rounded-3 shadow-sm d-none border-0">
                            <span id="teks-nofoto" class="badge bg-light text-muted border py-2 px-3"><i class="bi bi-image me-1"></i> Belum ada foto</span>
                        <?php endif; ?>
                    </div>
                    
                    <label class="form-label">Ganti Foto Baru (Opsional)</label>
                    <input type="file" name="foto" id="input-foto" class="form-control" accept="image/*">
                    <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengganti foto.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" value="<?= $barang['kode_barang']; ?>" readonly style="background-color: #e2e8f0; cursor: not-allowed; font-weight: bold; color: #0f766e;">
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= $barang['nama']; ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Merek / Tipe (Opsional)</label>
                    <input type="text" name="merk" class="form-control" value="<?= $barang['merk']; ?>">
                </div>

                <div class="mb-5">
                    <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                    <select name="kondisi" class="form-select" required>
                        <option value="1" <?= ($barang['kondisi'] == 1) ? 'selected' : ''; ?>>Baik</option>
                        <option value="2" <?= ($barang['kondisi'] == 2) ? 'selected' : ''; ?>>Rusak Ringan</option>
                        <option value="3" <?= ($barang['kondisi'] == 3) ? 'selected' : ''; ?>>Rusak Berat</option>
                    </select>
                </div>

                <hr class="mb-4 text-muted opacity-25">
                
                <div class="text-end">
                    <button type="submit" class="btn btn-simpan shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script Live Preview Gambar
        document.getElementById('input-foto').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById('preview-foto');
                    var teks = document.getElementById('teks-nofoto');
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                    if(teks) teks.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>