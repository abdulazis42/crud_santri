<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Sistem Diskon - Pondok Pesantren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .demo-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 15px;
        }
        .status-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }
        .demo-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="demo-card p-4 text-center mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h1 class="display-4 mb-3">💰 Sistem Diskon Pondok Pesantren</h1>
                    <p class="lead text-muted">Demo Fitur Baru v2.0 - Sistem Manajemen Diskon Terintegrasi</p>
                    <div class="mt-3">
                        <span class="badge bg-success status-badge">✅ Database Terintegrasi</span>
                        <span class="badge bg-primary status-badge">🆕 Fitur Baru</span>
                        <span class="badge bg-info status-badge">📱 Responsive</span>
                    </div>
                </div>

                <!-- Database Status -->
                <div class="demo-card p-4">
                    <h3><i class="fas fa-database me-2"></i>Status Database</h3>
                    <div id="database-status">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fitur Baru -->
                <div class="demo-card p-4">
                    <h3><i class="fas fa-star me-2"></i>Fitur Baru yang Tersedia</h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="demo-section">
                                <h5><i class="fas fa-tags text-primary me-2"></i>Kategori Diskon</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Anak Yatim</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Anak Piatu</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Yatim Piatu</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Keluarga Tidak Mampu</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Prestasi Akademik</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Prestasi Non-Akademik</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Keluarga Guru/Staff</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Saudara Kandung</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Beasiswa Khusus</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Diskon Umum</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="demo-section">
                                <h5><i class="fas fa-calculator text-success me-2"></i>Kalkulator Diskon</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Perhitungan Otomatis</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Berdasarkan Kategori Santri</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Berdasarkan Jenis Tagihan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Persentase Fleksibel</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Hasil Real-time</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="demo-section">
                        <h5><i class="fas fa-cogs text-warning me-2"></i>Aturan Diskon</h5>
                        <p>Buat aturan diskon berdasarkan kombinasi:</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-graduate text-primary mb-2" style="font-size: 2rem;"></i>
                                        <h6>Kategori Santri</h6>
                                        <small class="text-muted">Pilih kategori diskon santri</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-invoice text-success mb-2" style="font-size: 2rem;"></i>
                                        <h6>Jenis Tagihan</h6>
                                        <small class="text-muted">Pilih jenis tagihan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-info">
                                    <div class="card-body text-center">
                                        <i class="fas fa-percentage text-info mb-2" style="font-size: 2rem;"></i>
                                        <h6>Persentase Diskon</h6>
                                        <small class="text-muted">Set persentase diskon</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo Kalkulator -->
                <div class="demo-card p-4">
                    <h3><i class="fas fa-calculator me-2"></i>Demo Kalkulator Diskon</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="demo-calculator-form">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Santri</label>
                                    <select class="form-select" id="demo-santri" required>
                                        <option value="">Pilih Santri...</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Tagihan</label>
                                    <select class="form-select" id="demo-jenis-tagihan" required>
                                        <option value="">Pilih Jenis Tagihan...</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Tagihan (Rp)</label>
                                    <input type="number" class="form-control" id="demo-jumlah" min="0" step="1000" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calculator me-2"></i>Hitung Diskon
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div id="demo-hasil" class="demo-section">
                                <div class="text-center text-muted">
                                    <i class="fas fa-calculator fa-3x mb-3"></i>
                                    <p>Masukkan data di sebelah kiri untuk melihat hasil perhitungan diskon</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="demo-card p-4 text-center">
                    <h3><i class="fas fa-rocket me-2"></i>Mulai Menggunakan Sistem</h3>
                    <p class="text-muted mb-4">Klik tombol di bawah untuk mengakses sistem lengkap</p>
                    <div class="d-grid gap-2 d-md-block">
                        <a href="setup_database.php" class="btn btn-success btn-lg me-md-2">
                            <i class="fas fa-database me-2"></i>Setup Database
                        </a>
                        <a href="dashboard.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Akses Dashboard
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="demo-card p-4 text-center">
                    <p class="text-muted mb-0">
                        <i class="fas fa-code me-2"></i>
                        Sistem Diskon Pondok Pesantren v2.0 - Dibuat dengan ❤️
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load database status
        function loadDatabaseStatus() {
            fetch('api_handler.php?action=get_kategori_diskon')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('database-status').innerHTML = `
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Database Terhubung!</strong> Sistem diskon siap digunakan.
                                <br><small class="text-muted">${data.data.length} kategori diskon tersedia</small>
                            </div>
                        `;
                    } else {
                        document.getElementById('database-status').innerHTML = `
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Database Belum Siap</strong> Silakan jalankan setup database terlebih dahulu.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('database-status').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Error Koneksi Database</strong> Periksa konfigurasi database.
                        </div>
                    `;
                });
        }

        // Load demo data
        function loadDemoData() {
            // Load santri
            fetch('api_handler.php?action=get_santri')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('demo-santri');
                        data.data.forEach(item => {
                            select.innerHTML += `<option value="${item.id}">${item.nama} (${item.kelas})</option>`;
                        });
                    }
                });

            // Load jenis tagihan
            fetch('api_handler.php?action=get_jenis_tagihan')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('demo-jenis-tagihan');
                        data.data.forEach(item => {
                            select.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                        });
                    }
                });
        }

        // Demo calculator form
        document.getElementById('demo-calculator-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'calculate_diskon');
            formData.append('santri_id', document.getElementById('demo-santri').value);
            formData.append('jenis_tagihan_id', document.getElementById('demo-jenis-tagihan').value);
            formData.append('jumlah_tagihan', document.getElementById('demo-jumlah').value);
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('demo-hasil').innerHTML = `
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Hasil Perhitungan:</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Jumlah Tagihan:</small><br>
                                    <strong>Rp ${data.jumlah_tagihan.toLocaleString()}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Diskon:</small><br>
                                    <strong>${data.diskon_persen}%</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Jumlah Diskon:</small><br>
                                    <strong class="text-success">Rp ${data.jumlah_diskon.toLocaleString()}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Total Bayar:</small><br>
                                    <strong class="text-primary">Rp ${data.total_setelah_diskon.toLocaleString()}</strong>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    document.getElementById('demo-hasil').innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            ${data.message}
                        </div>
                    `;
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadDatabaseStatus();
            loadDemoData();
        });
    </script>
</body>
</html>
