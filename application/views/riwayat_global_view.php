<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Riwayat Pemeliharaan - SIMELEK PA SKH</title>
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
            <li><a href="<?= base_url('index.php/barang/index'); ?>" class="nav-link"><i class="bi bi-box-seam-fill"></i> Data Barang</a></li>
            <li><a href="<?= base_url('index.php/barang/riwayat_global'); ?>" class="nav-link active"><i class="bi bi-tools"></i> Riwayat Pemeliharaan</a></li>
        </ul>
    </div>

    <div id="main-content">
        <div class="top-header">
            <div><h4 class="mb-0 fw-bold" style="color: #2b3674;">Log Riwayat Pemeliharaan Keseluruhan</h4></div>
            
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-journal-text me-2 text-primary"></i> Semua Riwayat Pemeliharaan</h5>
                <a href="<?= base_url('index.php/barang/tambah_servis_global'); ?>" class="btn text-white fw-bold shadow-sm" style="background-color: #0f766e; border-radius: 12px; padding: 10px 20px;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pemeliharaan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-modern align-middle">
                    <thead>
                        <tr>
                            <th>TANGGAL</th>
                            <th>FOTO</th>
                            <th>NAMA ALAT</th>
                            <th>KELUHAN</th>
                            <th>TINDAKAN</th>
                            <th class="text-center">KONDISI</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($riwayat)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-5">Belum ada data riwayat pemeliharaan.</td></tr>
                        <?php else: ?>
                            <?php foreach($riwayat as $r): ?>
                            <tr>
                                <td class="text-muted"><?= date('d-m-Y', strtotime($r['tanggal_lapor'])); ?></td>
                                
                                <td>
                                    <?php if(!empty($r['foto_riwayat'])): ?>
                                        <a href="<?= base_url('assets/img/riwayat/'.$r['foto_riwayat']); ?>" target="_blank">
                                            <img src="<?= base_url('assets/img/riwayat/'.$r['foto_riwayat']); ?>" alt="Foto" width="50" height="50" class="rounded-3 shadow-sm" style="object-fit: cover;">
                                        </a>
                                    <?php else: ?>
                                        <div class="bg-light text-muted d-flex justify-content-center align-items-center rounded-3 shadow-sm" style="width: 50px; height: 50px; border: 1px dashed #cbd5e1;"><i class="bi bi-camera"></i></div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark"><?= isset($r['nama']) ? $r['nama'] : 'Alat'; ?></div>
                                    <small class="text-muted"><?= $r['kode_barang']; ?></small>
                                </td>
                                
                                <!-- KOLOM KELUHAN TERPISAH -->
                                <td>
                                    <span class="text-danger fw-semibold" style="font-size: 0.9rem;"><?= $r['keluhan']; ?></span>
                                </td>

                                <!-- KOLOM TINDAKAN TERPISAH -->
                                <td>
                                    <?php if(!empty($r['tindakan'])): ?>
                                        <span class="text-success fw-semibold" style="font-size: 0.9rem;"><?= $r['tindakan']; ?></span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic" style="font-size: 0.85rem;">Belum ada tindakan</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- KONDISI ALAT -->
                                <td class="text-center">
                                    <?php 
                                    $kondisi_val = isset($r['kondisi']) ? $r['kondisi'] : 1;
                                    if($kondisi_val == 1) {
                                        echo '<span class="badge badge-soft bg-success bg-opacity-10 text-success border border-success border-opacity-25">Baik</span>';
                                    } elseif($kondisi_val == 2) {
                                        echo '<span class="badge badge-soft bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Rusak Ringan</span>';
                                    } else {
                                        echo '<span class="badge badge-soft bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Rusak Berat</span>';
                                    }
                                    ?>
                                </td>

                                <!-- STATUS PERBAIKAN -->
                                <td class="text-center">
                                    <?php 
                                    $status_val = strtolower($r['status']);
                                    if($status_val == 'selesai'): ?>
                                        <span class="badge badge-soft bg-success bg-opacity-10 text-success border border-success border-opacity-25">Selesai</span>
                                    <?php elseif($status_val == 'proses' || $status_val == 'sedang diproses'): ?>
                                        <span class="badge badge-soft bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Proses</span>
                                    <?php else: ?>
                                        <span class="badge badge-soft bg-secondary bg-opacity-10 text-secondary border"><?= $r['status']; ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= base_url('index.php/barang/edit_servis_global/'.$r['id_servis']); ?>" class="btn btn-warning btn-sm btn-action text-dark me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="<?= base_url('index.php/barang/hapus_riwayat/'.$r['id_servis'].'/'.$r['id_barang']); ?>" class="btn btn-danger btn-sm btn-action" title="Hapus" onclick="return confirm('Yakin ingin menghapus riwayat ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>