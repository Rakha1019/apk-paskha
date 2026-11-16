<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alat - SIMELEK PA SKH</title>
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
        
        /* Tabel Modern */
        .table-modern th { border-bottom: 2px solid #f4f7fe; color: #a3aed1; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 15px 10px; }
        .table-modern td { border-bottom: 1px solid #f4f7fe; padding: 15px 10px; vertical-align: middle; color: #2b3674; font-weight: 500; }
        .badge-soft { padding: 6px 12px; border-radius: 30px; font-weight: 600; font-size: 0.75rem; }
        .btn-action { padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; transition: transform 0.2s; }
        .btn-action:hover { transform: translateY(-2px); }
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
            <div><h4 class="mb-0 fw-bold" style="color: #2b3674;">Monitoring Alat Elektronik</h4></div>
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

        <?php if($this->session->flashdata('pesan')): ?>
            <?= $this->session->flashdata('pesan'); ?>
        <?php endif; ?>

        <div class="card card-custom">
            <!-- Form Pencarian & Limit Baris -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-7">
                    <form action="<?= base_url('index.php/barang/index'); ?>" method="GET" class="d-flex w-100 shadow-sm rounded-pill overflow-hidden border border-light bg-white">
                        
                        <!-- Dropdown Pilihan Limit -->
                        <select name="limit" class="form-select border-0 border-end" style="width: auto; border-radius: 50rem 0 0 50rem; background: #f8fafc; cursor: pointer; font-weight: 600; color: #0f766e;" onchange="this.form.submit()">
                            <option value="10" <?= ($limit == 10) ? 'selected' : ''; ?>>10</option>
                            <option value="15" <?= ($limit == 15) ? 'selected' : ''; ?>>15</option>
                            <option value="20" <?= ($limit == 20) ? 'selected' : ''; ?>>20</option>
                            <option value="25" <?= ($limit == 25) ? 'selected' : ''; ?>>25</option>
                            <option value="50" <?= ($limit == 50) ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?= ($limit == 100) ? 'selected' : ''; ?>>100</option>
                        </select>
                        
                        <!-- Input Keyword -->
                        <input type="text" name="keyword_barang" class="form-control border-0 px-3 py-2" placeholder="Cari nama, kode, atau merek..." value="<?= isset($keyword) ? $keyword : ''; ?>" style="box-shadow: none;">
                        
                        <!-- Tombol Reset X -->
                        <?php if(!empty($keyword)): ?>
                            <a href="<?= base_url('index.php/barang/index?limit='.$limit); ?>" class="btn btn-light px-3 d-flex align-items-center text-secondary border-0" title="Reset Pencarian" style="background: #f1f5f9;">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        <?php endif; ?>

                        <!-- Tombol Search -->
                        <button class="btn px-4 text-white" type="submit" style="border-radius: 0 50rem 50rem 0; background-color: #0f766e;"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="<?= base_url('index.php/barang/tambah_barang'); ?>" class="btn text-white fw-bold shadow-sm" style="background-color: #0f766e; border-radius: 12px; padding: 10px 20px;"><i class="bi bi-plus-lg me-1"></i> Tambah Alat</a>
                    <a href="<?= base_url('index.php/barang/cetak'); ?>" target="_blank" class="btn btn-dark fw-bold shadow-sm ms-2" style="border-radius: 12px; padding: 10px 20px;"><i class="bi bi-printer me-1"></i> Cetak Laporan</a>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-modern align-middle">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>FOTO</th>
                            <th>KODE BARANG</th>
                            <th>NAMA BARANG</th>
                            <th>MEREK / TIPE</th>
                            <th class="text-center">KONDISI</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($barang)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-5">Data alat elektronik tidak ditemukan.</td></tr>
                        <?php else: ?>
                            <?php foreach($barang as $b): ?>
                            <tr>
                                <td class="text-muted fw-bold"><?= ++$start; ?></td>
                                <td>
                                    <?php if(!empty($b['foto'])): ?>
                                        <a href="<?= base_url('assets/img/barang/'.$b['foto']); ?>" target="_blank">
                                            <img src="<?= base_url('assets/img/barang/'.$b['foto']); ?>" alt="Foto" width="50" height="50" class="rounded-3 shadow-sm" style="object-fit: cover;">
                                        </a>
                                    <?php else: ?>
                                        <div class="bg-light text-muted d-flex justify-content-center align-items-center rounded-3 shadow-sm" style="width: 50px; height: 50px; border: 1px dashed #cbd5e1;"><i class="bi bi-camera"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td><span class="fw-bold text-primary"><?= $b['kode_barang']; ?></span></td>
                                <td class="fw-bold text-dark"><?= $b['nama']; ?></td>
                                <td class="text-muted"><?= empty($b['merk']) ? '-' : $b['merk']; ?></td>
                                <td class="text-center">
                                    <?php 
                                    if($b['kondisi'] == 1) echo '<span class="badge badge-soft bg-success bg-opacity-10 text-success border border-success border-opacity-25">Baik</span>';
                                    elseif($b['kondisi'] == 2) echo '<span class="badge badge-soft bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Rusak Ringan</span>';
                                    else echo '<span class="badge badge-soft bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Rusak Berat</span>';
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('index.php/barang/edit/'.$b['id']); ?>" class="btn btn-warning btn-sm btn-action text-dark me-1"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                                    <a href="<?= base_url('index.php/barang/hapus/'.$b['id']); ?>" class="btn btn-danger btn-sm btn-action" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="bi bi-trash me-1"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination & Info Limit -->
            <div class="mt-4 d-flex justify-content-between align-items-center border-top pt-3">
                <small class="text-muted fw-semibold">Menampilkan maksimal <span class="badge bg-light text-dark border"><?= $limit; ?></span> baris data.</small>
                <nav>
                    <?= $this->pagination->create_links(); ?>
                </nav>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>