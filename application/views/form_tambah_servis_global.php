<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Riwayat Pemeliharaan - SIMELEK PA SKH</title>
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
        
        /* FORM UMUM */
        .form-label { font-weight: 700; color: #2b3674; font-size: 0.85rem; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; padding: 10px 16px; border: 1px solid #e2e8f0; background-color: #f8fafc; color: #2b3674; transition: all 0.3s ease; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { border-color: #0f766e; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1); }
        
        .btn-simpan { background-color: #0f766e; color: white; border: none; border-radius: 12px; font-weight: 600; padding: 12px 25px; transition: all 0.3s ease; }
        .btn-simpan:hover { background-color: #0d5f59; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(15, 118, 110, 0.3); color: white; }
        .btn-back { border-radius: 12px; font-weight: 600; padding: 10px 20px; background-color: white; color: #64748b; border: 1px solid #e2e8f0; transition: all 0.3s ease; }
        .btn-back:hover { background-color: #f1f5f9; color: #0f766e; }

        /* --- STYLING PANEL KANAN (GRID KARTU ALAT) --- */
        .right-panel { background-color: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 25px; height: 100%; display: flex; flex-direction: column; }
        .select-premium { border: 2px solid #0f766e; background-color: #ffffff; color: #0f766e; font-weight: 600; cursor: pointer; }
        
        .radio-alat { display: none; }
        
        .card-alat { border: 2px solid #e2e8f0; border-radius: 12px; padding: 12px 15px; cursor: pointer; background: #ffffff; transition: all 0.2s ease-in-out; display: block; position: relative; }
        .card-alat:hover { border-color: #94a3b8; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .radio-alat:checked + .card-alat { border-color: #0f766e; background-color: #f0fdfa; box-shadow: 0 4px 12px rgba(15, 118, 110, 0.15); }
        
        .icon-check { opacity: 0; transform: scale(0.5); transition: all 0.2s ease-in-out; color: #0f766e; font-size: 1.3rem; }
        .radio-alat:checked + .card-alat .icon-check { opacity: 1; transform: scale(1); }
        
        /* Accordion Detail Hover */
        .card-detail-content { max-height: 0; opacity: 0; overflow: hidden; transition: all 0.3s ease; margin-top: 0; border-top: 1px dashed transparent; }
        .card-alat:hover .card-detail-content, .radio-alat:checked + .card-alat .card-detail-content { max-height: 80px; opacity: 1; margin-top: 8px; padding-top: 8px; border-top-color: #cbd5e1; }
        
        /* Area Scroll Kotak Alat - TINGGI DITAMBAH AGAR PAS 1 BARIS LAGI */
        #container_alat { max-height: 620px; overflow-y: auto; overflow-x: hidden; padding-right: 5px; }
        #container_alat::-webkit-scrollbar { width: 6px; }
        #container_alat::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
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
            <div><h4 class="mb-0 fw-bold" style="color: #2b3674;">Tambah Riwayat Pemeliharaan</h4></div>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark bg-light px-3 py-2 rounded-pill shadow-sm" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px; font-weight: bold;">
                        <?= $this->session->userdata('username') ? strtoupper(substr($this->session->userdata('username'), 0, 1)) : 'A'; ?>
                    </div>
                    <span class="me-1 fw-bold fs-6 text-primary">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                    <li><a class="dropdown-item text-danger fw-bold py-2" href="<?= base_url('index.php/auth/logout'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Log out</a></li>
                </ul>
            </div>
        </div>

        <button type="button" onclick="history.back()" class="btn btn-back mb-4 shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Batal / Kembali
        </button>

        <div class="card card-custom border-top border-5 border-success" style="border-top-color: #0f766e !important;">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-tools me-2 text-primary"></i> Form Pencatatan Pemeliharaan</h5>

            <?php if($this->session->flashdata('pesan')): ?>
                <?= $this->session->flashdata('pesan'); ?>
            <?php endif; ?>
            
            <form action="<?= base_url('index.php/barang/proses_simpan_servis_global'); ?>" method="POST" enctype="multipart/form-data">
                
                <div class="row g-4 align-items-stretch">
                    
                    <!-- ===== KOLOM KIRI ===== -->
                    <div class="col-lg-5">
                        <div class="p-3 bg-light rounded-4 border h-100">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill me-2 text-primary"></i> Informasi Laporan</h6>
                            
                            <div class="mb-3">
                                <label class="form-label" style="color: #0f766e;">Pilih Kategori Alat <span class="text-danger">*</span></label>
                                <select id="pilih_kategori" class="form-select select-premium shadow-sm" required onchange="filterAlatTerkait()">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <?php foreach($kategori_unik as $kategori): ?>
                                        <option value="<?= htmlspecialchars($kategori['nama_kategori']); ?>"><?= $kategori['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Lapor <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lapor" class="form-control" required value="<?= date('Y-m-d'); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kondisi Alat (Terkini) <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kondisi --</option>
                                    <option value="1">Baik</option>
                                    <option value="2">Rusak Ringan</option>
                                    <option value="3">Rusak Berat</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Perbaikan <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Menunggu / Antre">Menunggu / Antre</option>
                                    <option value="Proses">Sedang Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Keluhan / Kerusakan <span class="text-danger">*</span></label>
                                <textarea name="keluhan" class="form-control" rows="2" placeholder="Deskripsikan kerusakan..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tindakan (Opsional)</label>
                                <textarea name="tindakan" class="form-control" rows="2" placeholder="Tindakan perbaikan..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Bukti (Opsional)</label>
                                <div class="mb-2 d-flex align-items-center gap-3">
                                    <div>
                                        <img id="preview-foto" src="#" alt="Preview" width="80" class="img-thumbnail rounded-3 shadow-sm d-none border-0">
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 fw-bold shadow-sm mb-1" data-bs-toggle="modal" data-bs-target="#kameraModalServis">
                                            <i class="bi bi-camera-fill me-1"></i> Ambil dari Kamera
                                        </button>
                                        <input type="file" name="foto_riwayat" id="input-foto" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===== KOLOM KANAN ===== -->
                    <div class="col-lg-7">
                        <div class="right-panel shadow-sm">
                            
                            <div id="panel_kosong" class="text-center my-auto py-5">
                                <div class="display-4 text-muted opacity-50 mb-3"><i class="bi bi-arrow-left-circle"></i></div>
                                <h6 class="fw-bold text-secondary">Silakan Pilih Kategori Terlebih Dahulu</h6>
                                <p class="text-muted small px-4">Daftar kode alat spesifik berdasarkan kategori yang dipilih akan muncul secara otomatis di sebelah sini.</p>
                            </div>

                            <div id="box_alat_wrapper" class="d-none flex-column h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0" style="color: #0f766e;"><i class="bi bi-grid-3x3-gap-fill me-2"></i> Pilih Kode Alat Spesifik <span class="text-danger">*</span></h6>
                                    
                                    <div class="input-group input-group-sm" style="width: 200px;">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                        <input type="text" id="cari_alat" class="form-control border-start-0 ps-0 form-control-sm" placeholder="Cari kode..." onkeyup="cariKotakAlat()">
                                    </div>
                                </div>
                                
                                <div id="container_alat">
                                    <div id="grid_alat" class="row g-2 pb-2">
                                        <!-- Kartu alat digenerate otomatis lewat JS -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <hr class="my-4 text-muted opacity-25">
                
                <div class="text-end">
                    <button type="submit" class="btn btn-simpan shadow-sm px-5">
                        <i class="bi bi-save me-2"></i> Simpan Riwayat Pemeliharaan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const semuaAlat = [
            <?php foreach($list_barang as$brg): 
                
                // --- KODE AJAIB (DIPERBAIKI) ---
                // Kita proses logikanya di PHP dengan rapi terlebih dahulu
                $kategori_asli = '';
                if (!empty($brg['kategori']) &&$brg['kategori'] !== 'Elektronik') {
                    // Jika data BARU, ambil dari kolom kategori
                    $kategori_asli =$brg['kategori'];
                } else {
                    // Jika data LAMA (masih 'Elektronik' atau kosong), ambil dari nama
                    $kategori_asli =$brg['nama'];
                }
            ?>
                { 
                    id: "<?= $brg['id']; ?>", 
                    kategori: "<?= addslashes($kategori_asli); ?>", 
                    kode: "<?= addslashes($brg['kode_barang']); ?>",
                    nama_barang: "<?= addslashes($brg['nama']); ?>",
                    merk: "<?= addslashes(empty($brg['merk']) ? '-' :$brg['merk']); ?>",
                    kondisi_teks: "<?= $brg['kondisi'] == 1 ? 'Baik' : ($brg['kondisi'] == 2 ? 'Rusak Ringan' : 'Rusak Berat'); ?>",
                    badge: "<?= $brg['kondisi'] == 1 ? 'bg-success' : ($brg['kondisi'] == 2 ? 'bg-warning' : 'bg-danger'); ?>"
                },
            <?php endforeach; ?>
        ];

        function filterAlatTerkait() {
            const kategoriTerpilih = document.getElementById('pilih_kategori').value.trim().toLowerCase();
            const gridAlat = document.getElementById('grid_alat');
            const wrapper = document.getElementById('box_alat_wrapper');
            const panelKosong = document.getElementById('panel_kosong');
            const inputCari = document.getElementById('cari_alat');
            
            panelKosong.classList.add('d-none');
            wrapper.classList.remove('d-none');
            wrapper.classList.add('d-flex');
            
            inputCari.value = ''; 
            gridAlat.innerHTML = ''; 
            
            let elemenHTML = '';
            let jumlahData = 0;
            
            semuaAlat.forEach(alat => {
                if (alat.kategori.trim().toLowerCase() === kategoriTerpilih) {
                    jumlahData++;
                    elemenHTML += `
                    <div class="col-md-6 item-alat" data-kode="${alat.kode.toLowerCase()}">
                        <input type="radio" name="id_barang" id="alat_${alat.id}" value="${alat.id}" class="radio-alat" required>
                        <label for="alat_${alat.id}" class="card-alat w-100 m-0">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted fw-semibold" style="font-size: 0.7rem;">KODE ALAT</div>
                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">${alat.kode}</div>
                                </div>
                                <div class="icon-check">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                            
                            <div class="card-detail-content">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <div class="text-muted" style="font-size: 0.65rem;">MEREK / TIPE</div>
                                        <div class="fw-semibold text-dark text-truncate" style="font-size: 0.8rem; max-width: 120px;">${alat.merk}</div>
                                    </div>
                                    <div>
                                        <span class="badge ${alat.badge} text-white border" style="font-size: 0.65rem;">${alat.kondisi_teks}</span>
                                    </div>
                                </div>
                            </div>
                            
                        </label>
                    </div>
                    `;
                }
            });
            
            if (jumlahData === 0) {
                gridAlat.innerHTML = `<div class="col-12 text-center text-muted py-5">Belum ada data alat untuk kategori ini.</div>`;
            } else {
                gridAlat.innerHTML = elemenHTML;
            }
        }

        function cariKotakAlat() {
            let input = document.getElementById('cari_alat').value.toLowerCase();
            let kotakAlat = document.getElementsByClassName('item-alat');

            for (let i = 0; i < kotakAlat.length; i++) {
                let kode = kotakAlat[i].getAttribute('data-kode');
                if (kode.includes(input)) {
                    kotakAlat[i].style.display = ""; 
                } else {
                    kotakAlat[i].style.display = "none"; 
                }
            }
        }

        document.getElementById('input-foto').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById('preview-foto');
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <!-- MODAL KAMERA SERVIS -->
    <div class="modal fade" id="kameraModalServis" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-teal text-white" style="background-color: #0f766e;">
                    <h5 class="modal-title fw-bold fs-6"><i class="bi bi-camera me-2"></i> Ambil Foto Bukti Servis</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="matikanKameraServis()"></button>
                </div>
                <div class="modal-body text-center bg-dark p-0 position-relative" style="min-height: 350px; display: flex; align-items: center; justify-content: center;">
                    <video id="video-kamera-servis" autoplay playsinline style="width: 100%; max-height: 400px; object-fit: cover;"></video>
                    <canvas id="canvas-kamera-servis" class="d-none"></canvas>
                </div>
                <div class="modal-footer bg-light justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal" onclick="matikanKameraServis()">Batal</button>
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-4 fw-bold" onclick="ambilFotoServis()">
                        <i class="bi bi-circle-fill text-danger me-1"></i> Ambil Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let streamKameraServis = null;
        const modalServisEl = document.getElementById('kameraModalServis');

        if(modalServisEl) {
            modalServisEl.addEventListener('shown.bs.modal', function () {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false })
                    .then(function(stream) {
                        streamKameraServis = stream;
                        document.getElementById('video-kamera-servis').srcObject = stream;
                    })
                    .catch(function(err) {
                        alert("Gagal mengakses kamera! Periksa izin kamera pada browser Anda.");
                        console.error(err);
                        bootstrap.Modal.getInstance(modalServisEl).hide();
                    });
            });
        }

        function matikanKameraServis() {
            if (streamKameraServis) {
                streamKameraServis.getTracks().forEach(track => track.stop());
                streamKameraServis = null;
            }
        }

        function ambilFotoServis() {
            const video = document.getElementById('video-kamera-servis');
            const canvas = document.getElementById('canvas-kamera-servis');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(function(blob) {
                let file = new File([blob], "servis_" + Date.now() + ".jpg", { type: "image/jpeg" });
                
                let container = new DataTransfer();
                container.items.add(file);
                document.getElementById('input-foto').files = container.files;

                let img = document.getElementById('preview-foto');
                img.src = URL.createObjectURL(file);
                img.classList.remove('d-none');

                matikanKameraServis();
                bootstrap.Modal.getInstance(modalServisEl).hide();
            }, 'image/jpeg', 0.85);
        }
    </script>
</body>
</html>