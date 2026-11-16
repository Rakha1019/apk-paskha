<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat - SIMELEK PA SKH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; overflow-x: hidden; color: #2b3674; }
        
        #sidebar { width: 260px; background-color: #0f766e; min-height: 100vh; color: white; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; box-shadow: 4px 0 20px rgba(0,0,0,0.05); }
        .sidebar-header { padding: 25px; display: flex; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 15px; }
        .sidebar-nav { list-style: none; padding: 0; margin: 0; }
        .sidebar-nav li { margin-bottom: 8px; padding: 0 20px; }
        .sidebar-nav .nav-link { color: rgba(255, 255, 255, 0.7); padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; text-decoration: none; font-size: 0.95rem; transition: all 0.3s ease; }
        .sidebar-nav .nav-link i { margin-right: 15px; font-size: 1.2rem; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { background-color: rgba(255, 255, 255, 0.15); color: white; font-weight: 600; transform: translateX(5px); }
        
        #main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        .card-custom { border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03); background: white; padding: 30px; }
        
        .form-label { font-weight: 700; color: #2b3674; font-size: 0.9rem; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; padding: 12px 18px; border: 1px solid #e2e8f0; background-color: #f8fafc; color: #2b3674; transition: all 0.3s ease; }
        .form-control:focus, .form-select:focus { border-color: #0f766e; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1); }
        .form-control[readonly] { background-color: #e2e8f0; font-weight: bold; color: #0f766e; cursor: not-allowed; }
        
        .btn-simpan { background-color: #0f766e; color: white; border: none; border-radius: 12px; font-weight: 600; padding: 12px 25px; transition: all 0.3s ease; }
        .btn-simpan:hover { background-color: #0d5f59; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(15, 118, 110, 0.3); color: white; }
        .btn-back { border-radius: 12px; font-weight: 600; padding: 10px 20px; background-color: white; color: #64748b; border: 1px solid #e2e8f0; transition: all 0.3s ease; }
        .btn-back:hover { background-color: #f1f5f9; color: #0f766e; }
        
        .step-box { background-color: #f8fafc; border: 2px dashed #cbd5e1; padding: 25px; border-radius: 16px; margin-bottom: 25px; }
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
        <a href="<?= base_url('index.php/barang/index'); ?>" class="btn btn-back mb-4 shadow-sm text-decoration-none">
            <i class="bi bi-arrow-left me-2"></i> Batal / Kembali
        </a>

        <div class="card card-custom" style="max-width: 800px; border-top: 5px solid #0f766e;">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-plus-square-fill me-2 text-primary"></i> Form Data Barang Baru</h5>

            <?php if($this->session->flashdata('pesan')): ?>
                <?= $this->session->flashdata('pesan'); ?>
            <?php endif; ?>
            
            <form action="<?= base_url('index.php/barang/proses_simpan_barang'); ?>" method="POST" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" value="<?= $kode_otomatis; ?>" readonly>
                </div>

                <div class="step-box shadow-sm">
                    <!-- 1. PILIH KATEGORI (PATOKAN SERVIS) -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label mb-0" style="color: #0f766e;"><i class="bi bi-1-circle-fill me-1 fs-5 align-middle"></i> Pilih Kategori Barang (Patokan Servis) <span class="text-danger">*</span></label>
                            <a href="<?= base_url('index.php/barang/halaman_tambah_kategori'); ?>" class="btn btn-sm btn-outline-primary rounded-pill fw-bold shadow-sm" style="font-size: 0.8rem; border-width: 2px;">
                                <i class="bi bi-plus-lg me-1"></i>Kategori Baru
                            </a>
                        </div>
                        <select name="pilihan_kategori" class="form-select border-primary shadow-sm" style="background-color: #ffffff; border-width: 2px;" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <?php if(!empty($kategori_tersedia)): ?>
                                <?php foreach($kategori_tersedia as $kat): ?>
                                    <option value="<?= htmlspecialchars($kat['nama_kategori']); ?>"><?= $kat['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- 2. NAMA BARANG (YANG TAMPIL DI TABEL) -->
                    <div class="mb-4">
                        <label class="form-label" style="color: #0f766e;"><i class="bi bi-2-circle-fill me-1 fs-5 align-middle"></i> Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control shadow-sm" placeholder="Contoh: AC Split / Printer LaserJet / Komputer PC" required>
                    </div>

                    <!-- 3. MEREK / TIPE SPESIFIK -->
                    <div class="mb-2">
                        <label class="form-label text-muted"><i class="bi bi-3-circle-fill me-1 fs-5 align-middle"></i> Merek / Tipe (Opsional)</label>
                        <input type="text" name="merk" class="form-control" placeholder="Contoh: Daikin 1PK / Epson L3110">
                    </div>
                </div>

                <div class="row">
                    <div class="mb-4">
                    <label class="form-label">Foto Alat (Opsional)</label>
                    <div class="mb-3 d-flex align-items-center gap-3">
                        <div>
                            <img id="preview-foto" src="#" alt="Preview" width="100" class="img-thumbnail rounded-3 shadow-sm d-none border-0">
                            <span id="teks-nofoto" class="badge bg-light text-muted border py-2 px-3"><i class="bi bi-image me-1"></i> Belum ada foto</span>
                        </div>
                        <div>
                            <!-- Tombol pemicu modal kamera -->
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 fw-bold shadow-sm mb-1" data-bs-toggle="modal" data-bs-target="#kameraModal">
                                <i class="bi bi-camera-fill me-1"></i> Ambil dari Kamera
                            </button>
                            <div class="small text-muted" style="font-size: 0.75rem;">Atau pilih file dari perangkat:</div>
                            <input type="file" name="foto" id="input-foto" class="form-control form-control-sm mt-1" accept="image/*">
                        </div>
                    </div>
                </div>

                <hr class="mb-4 text-muted opacity-25">
                <div class="text-end">
                    <button type="submit" class="btn btn-simpan shadow-sm px-5"><i class="bi bi-save me-2"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

    <!-- MODAL KAMERA LIVE -->
    <div class="modal fade" id="kameraModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-teal text-white" style="background-color: #0f766e;">
                    <h5 class="modal-title fw-bold fs-6"><i class="bi bi-camera me-2"></i> Ambil Foto Langsung</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="matikanKamera()"></button>
                </div>
                <div class="modal-body text-center bg-dark p-0 position-relative" style="min-height: 350px; display: flex; align-items: center; justify-content: center;">
                    <video id="video-kamera" autoplay playsinline style="width: 100%; max-height: 400px; object-fit: cover;"></video>
                    <canvas id="canvas-kamera" class="d-none"></canvas>
                </div>
                <div class="modal-footer bg-light justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal" onclick="matikanKamera()">Batal</button>
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-4 fw-bold" id="btn-capture" onclick="ambilFotoDariKamera()">
                        <i class="bi bi-circle-fill text-danger me-1"></i> Ambil Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let streamKamera = null;

        // Nyalakan kamera saat modal dibuka
        const modalKameraEl = document.getElementById('kameraModal');
        if(modalKameraEl) {
            modalKameraEl.addEventListener('shown.bs.modal', function () {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false })
                    .then(function(stream) {
                        streamKamera = stream;
                        document.getElementById('video-kamera').srcObject = stream;
                    })
                    .catch(function(err) {
                        alert("Gagal mengakses kamera! Pastikan izin kamera di browser sudah diaktifkan.");
                        console.error(err);
                        bootstrap.Modal.getInstance(modalKameraEl).hide();
                    });
            });
        }

        function matikanKamera() {
            if (streamKamera) {
                streamKamera.getTracks().forEach(track => track.stop());
                streamKamera = null;
            }
        }

        function ambilFotoDariKamera() {
            const video = document.getElementById('video-kamera');
            const canvas = document.getElementById('canvas-kamera');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(function(blob) {
                let file = new File([blob], "kamera_" + Date.now() + ".jpg", { type: "image/jpeg" });
                
                // Masukkan file hasil jepretan ke input file form secara otomatis
                let container = new DataTransfer();
                container.items.add(file);
                document.getElementById('input-foto').files = container.files;

                // Tampilkan preview gambar
                let img = document.getElementById('preview-foto');
                let teks = document.getElementById('teks-nofoto');
                img.src = URL.createObjectURL(file);
                img.classList.remove('d-none');
                if(teks) teks.classList.add('d-none');

                // Tutup modal & matikan kamera
                matikanKamera();
                let modalInstance = bootstrap.Modal.getInstance(modalKameraEl);
                modalInstance.hide();
            }, 'image/jpeg', 0.85);
        }

        // Preview manual jika pilih file dari galeri
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