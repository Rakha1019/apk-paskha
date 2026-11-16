<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIMELEK PA SKH</title>
    <!-- CSS Bootstrap & Ikon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Menggunakan Font Modern */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; overflow-x: hidden; color: #2b3674; }
        
        /* === SIDEBAR === */
        #sidebar { width: 260px; background-color: #0f766e; min-height: 100vh; color: white; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; box-shadow: 4px 0 20px rgba(0,0,0,0.05); }
        .sidebar-header { padding: 25px; display: flex; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 15px; }
        .sidebar-nav { list-style: none; padding: 0; margin: 0; }
        .sidebar-nav li { margin-bottom: 8px; padding: 0 20px; }
        .sidebar-nav .nav-link { color: rgba(255, 255, 255, 0.7); padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; text-decoration: none; font-size: 0.95rem; transition: all 0.3s ease; white-space: nowrap; overflow: hidden; }
        .sidebar-nav .nav-link i { margin-right: 15px; font-size: 1.2rem; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { background-color: rgba(255, 255, 255, 0.15); color: white; font-weight: 600; transform: translateX(5px); }
        
        /* === KONTEN UTAMA === */
        #main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        .top-header { background: white; padding: 15px 30px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        
        /* === KARTU STATISTIK === */
        .stat-card { border-radius: 20px; padding: 25px; color: white; position: relative; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.08); transition: transform 0.3s; height: 100%; display: flex; flex-direction: column; justify-content: center; border: none; }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card-title { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; margin-bottom: 5px; }
        .stat-card-number { font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1; }
        .stat-watermark { position: absolute; right: -15px; bottom: -25px; font-size: 7rem; opacity: 0.15; transform: rotate(-15deg); pointer-events: none; }
        
        /* Warna Kartu Statistik */
        .bg-gradient-total { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
        .bg-gradient-baik { background: linear-gradient(135deg, #10b981 0%, #047857 100%); }
        .bg-gradient-ringan { background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%); }
        .bg-gradient-berat { background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); }
        
        /* === CARD KONTEN BAWAH === */
        .card-custom { border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; padding: 25px; }
        .card-title-custom { font-weight: 800; color: #2b3674; font-size: 1.1rem; margin-bottom: 20px; display: flex; align-items: center; }
        
        /* === DESAIN DAFTAR (LIST) BAWAH === */
        .modern-list-item { background: white; border-radius: 12px; padding: 15px; margin-bottom: 12px; display: flex; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border: 1px solid #f1f5f9; transition: all 0.2s ease; border-left: 5px solid transparent; }
        .modern-list-item:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.05); }
        .icon-circle { width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-right: 15px; }
        
        .border-left-baik { border-left-color: #10b981; }
        .border-left-ringan { border-left-color: #f59e0b; }
        .border-left-berat { border-left-color: #ef4444; }
        
        /* Tabel */
        .table-modern th { border-bottom: 2px solid #f4f7fe; color: #a3aed1; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 15px 10px; }
        .table-modern td { border-bottom: 1px solid #f4f7fe; padding: 15px 10px; vertical-align: middle; color: #2b3674; font-weight: 500; }
        .badge-soft { padding: 6px 12px; border-radius: 30px; font-weight: 600; font-size: 0.75rem; }
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
            <li>
                <a href="<?= base_url('index.php/barang/dashboard'); ?>" class="nav-link active">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= base_url('index.php/barang/index'); ?>" class="nav-link">
                    <i class="bi bi-box-seam-fill"></i> Data Barang
                </a>
            </li>
            <li>
                <a href="<?= base_url('index.php/barang/riwayat_global'); ?>" class="nav-link">
                    <i class="bi bi-tools"></i> Riwayat Pemeliharaan
                </a>
            </li>
        </ul>
    </div>

    <!-- KONTEN UTAMA -->
    <div id="main-content">
        
        <!-- HEADER ATAS -->
        <div class="top-header">
            <div>
                <h4 class="mb-0 fw-bold" style="color: #2b3674;">Dashboard Analytics</h4>
                <small class="text-muted fw-medium">Ringkasan kondisi inventaris elektronik Pengadilan Agama Sukoharjo</small>
            </div>
            
            <!-- DROPDOWN PROFIL (FIXED) -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark bg-light px-3 py-2 rounded-pill shadow-sm" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                        <?= $this->session->userdata('username') ? strtoupper(substr($this->session->userdata('username'), 0, 1)) : 'A'; ?>
                    </div>
                    <span class="me-1 fw-bold fs-6 text-primary">
                        <?= $this->session->userdata('username') ? ucfirst($this->session->userdata('username')) : 'Admin'; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" aria-labelledby="dropdownUser">
                    <li>
                        <a class="dropdown-item text-danger fw-bold py-2" href="<?= base_url('index.php/auth/logout'); ?>" onclick="return confirm('Yakin ingin keluar?');">
                            <i class="bi bi-box-arrow-right me-2"></i> Log out
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 4 KARTU STATISTIK (FIXED) -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card bg-gradient-total">
                    <div class="stat-card-title">Total Elektronik</div>
                    <div class="stat-card-number"><?= $statistik['total_barang']; ?></div>
                    <i class="bi bi-pc-display stat-watermark"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-baik">
                    <div class="stat-card-title">Kondisi Baik</div>
                    <div class="stat-card-number"><?= $statistik['baik']; ?></div>
                    <i class="bi bi-check-circle-fill stat-watermark"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-ringan">
                    <div class="stat-card-title">Rusak Ringan</div>
                    <div class="stat-card-number"><?= $statistik['rusak_ringan']; ?></div>
                    <i class="bi bi-exclamation-triangle-fill stat-watermark"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-berat">
                    <div class="stat-card-title">Rusak Berat</div>
                    <div class="stat-card-number"><?= $statistik['rusak_berat']; ?></div>
                    <i class="bi bi-x-octagon-fill stat-watermark"></i>
                </div>
            </div>
        </div>

        <!-- CHART & TABEL TERBARU -->
        <div class="row g-4 mb-4">
            <!-- DIAGRAM -->
            <div class="col-md-4">
                <div class="card-custom h-100">
                    <h5 class="card-title-custom"><i class="bi bi-pie-chart-fill text-primary me-2"></i> Rasio Kondisi Alat</h5>
                    <div style="position: relative; height: 260px; width: 100%; display: flex; justify-content: center; align-items: center;">
                        <canvas id="diagramKondisi"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- TABEL PEMELIHARAAN -->
            <div class="col-md-8">
                <div class="card-custom h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title-custom mb-0"><i class="bi bi-activity text-primary me-2"></i> Pemeliharaan Terbaru</h5>
                        <a href="<?= base_url('index.php/barang/riwayat_global'); ?>" class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3 shadow-sm">Lihat Semua</a>
                    </div>
                    
                    <?php if(empty($riwayat_terbaru)): ?>
                        <div class="text-center mt-5 mb-5">
                            <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                <i class="bi bi-journal-x text-muted fs-1"></i>
                            </div>
                            <p class="text-muted fw-medium">Belum ada riwayat pemeliharaan.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-modern table-borderless align-middle">
                                <thead>
                                    <tr>
                                        <th>TANGGAL</th>
                                        <th>NAMA ALAT</th>
                                        <th>KELUHAN</th>
                                        <th class="text-center">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($riwayat_terbaru as $rt): ?>
                                    <tr>
                                        <td class="text-muted"><?= date('d M Y', strtotime($rt['tanggal_lapor'])); ?></td>
                                        <td class="fw-bold text-dark"><?= $rt['nama']; ?></td>
                                        <td class="text-muted" style="font-size: 0.9rem;">
                                            <?= (strlen($rt['keluhan']) > 25) ? substr($rt['keluhan'], 0, 25).'...' : $rt['keluhan']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if(strtolower($rt['status']) == 'selesai'): ?>
                                                <span class="badge badge-soft bg-success bg-opacity-10 text-success border border-success border-opacity-25">Selesai</span>
                                            <?php else: ?>
                                                <span class="badge badge-soft bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Proses</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- 3 KOLOM RINCIAN ALAT (FIXED) -->
        <h5 class="fw-bold text-dark mb-3 mt-4 ms-2"><i class="bi bi-list-stars text-primary me-2"></i> Rincian Inventaris Terbaru</h5>
        <div class="row g-4 mb-5">
            
            <!-- Kondisi Baik -->
            <div class="col-md-4">
                <?php if(empty($list_baik)): ?>
                    <div class="card-custom text-center py-4 text-muted border border-light">Belum ada data.</div>
                <?php else: ?>
                    <?php foreach($list_baik as $b): ?>
                        <div class="modern-list-item border-left-baik">
                            <div class="icon-circle bg-success bg-opacity-10 text-success">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.95rem;"><?= $b['nama']; ?></h6>
                                <small class="text-muted fw-medium"><i class="bi bi-upc-scan me-1"></i><?= $b['kode_barang']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Rusak Ringan -->
            <div class="col-md-4">
                <?php if(empty($list_ringan)): ?>
                    <div class="card-custom text-center py-4 text-muted border border-light">Belum ada data.</div>
                <?php else: ?>
                    <?php foreach($list_ringan as $r): ?>
                        <div class="modern-list-item border-left-ringan">
                            <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-exclamation-lg"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.95rem;"><?= $r['nama']; ?></h6>
                                <small class="text-muted fw-medium"><i class="bi bi-upc-scan me-1"></i><?= $r['kode_barang']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Rusak Berat -->
            <div class="col-md-4">
                <?php if(empty($list_berat)): ?>
                    <div class="card-custom text-center py-4 text-muted border border-light">Belum ada data.</div>
                <?php else: ?>
                    <?php foreach($list_berat as $rb): ?>
                        <div class="modern-list-item border-left-berat">
                            <div class="icon-circle bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-x-lg"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 fw-bold text-dark text-truncate" style="font-size: 0.95rem;"><?= $rb['nama']; ?></h6>
                                <small class="text-muted fw-medium"><i class="bi bi-upc-scan me-1"></i><?= $rb['kode_barang']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <!-- Script Wajib Bootstrap (Ini yang membuat tombol Logout / Dropdown bisa turun!) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Konfigurasi Chart.js agar warnanya menyatu dengan kartu di atas
        const ctx = document.getElementById('diagramKondisi').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Kondisi Baik', 'Rusak Ringan', 'Rusak Berat'],
                datasets: [{
                    data: [<?= $statistik['baik']; ?>, <?= $statistik['rusak_ringan']; ?>, <?= $statistik['rusak_berat']; ?>],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 4, 
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                cutout: '75%', 
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { 
                            usePointStyle: true, 
                            padding: 20,
                            font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600' },
                            color: '#2b3674'
                        } 
                    } 
                } 
            }
        });
    </script>
</body>
</html>