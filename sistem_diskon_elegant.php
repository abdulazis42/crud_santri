<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Diskon - Pondok Pesantren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            color: white;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        .main-content {
            margin-left: 280px;
            padding: 30px;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(255,255,255,0.2);
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 25px 30px;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 18px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .discount-calculator {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
        }
        .result-card {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-radius: 20px;
            padding: 25px;
            border-left: 5px solid #28a745;
        }
        .status-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .table th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            font-weight: 600;
            padding: 18px 15px;
            color: #495057;
        }
        .table td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 25px 30px;
        }
        .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }
        .btn-close:hover {
            opacity: 1;
        }
        .tab-content {
            background: white;
            border-radius: 0 0 20px 20px;
            padding: 30px;
        }
        .nav-tabs {
            border: none;
            margin-bottom: 0;
        }
        .nav-tabs .nav-link {
            color: #667eea;
            border: none;
            border-radius: 15px 15px 0 0;
            margin-right: 8px;
            padding: 15px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
        }
        .alert {
            border: none;
            border-radius: 15px;
            padding: 20px 25px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 5px solid #28a745;
        }
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border-left: 5px solid #ffc107;
        }
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 5px solid #dc3545;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .card-header {
                padding: 20px;
            }
            .tab-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <i class="fas fa-mosque fa-3x mb-3"></i>
            <h4>Pondok Pesantren</h4>
            <p class="text-muted">Sistem Manajemen</p>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a class="nav-link" href="index.php">
                <i class="fas fa-users me-2"></i>
                Daftar Santri
            </a>
            <a class="nav-link" href="jenis_tagihan.php">
                <i class="fas fa-file-invoice me-2"></i>
                Jenis Tagihan
            </a>
            <a class="nav-link active" href="sistem_diskon_elegant.php">
                <i class="fas fa-percentage me-2"></i>
                Sistem Diskon
            </a>
        </nav>
        
        <div class="mt-auto pt-4">
            <div class="text-center">
                <small class="text-muted">© 2024 Pondok Pesantren</small>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-2">
                    <i class="fas fa-percentage text-primary me-3"></i>
                    Sistem Diskon
                </h2>
                <p class="text-muted mb-0 fs-5">Kelola kategori diskon dan aturan diskon untuk santri</p>
            </div>
            <div>
                <a href="dashboard.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="diskontabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="kategori-tab" data-bs-toggle="tab" data-bs-target="#kategori" type="button" role="tab">
                            <i class="fas fa-tags me-2"></i>Kategori Diskon
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="aturan-tab" data-bs-toggle="tab" data-bs-target="#aturan" type="button" role="tab">
                            <i class="fas fa-cogs me-2"></i>Aturan Diskon
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="hitung-tab" data-bs-toggle="tab" data-bs-target="#hitung" type="button" role="tab">
                            <i class="fas fa-calculator me-2"></i>Hitung Diskon
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="tab-content" id="diskontabsContent">
                <!-- Kategori Diskon Tab -->
                <div class="tab-pane fade show active" id="kategori" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">
                            <i class="fas fa-tags text-primary me-2"></i>
                            Daftar Kategori Diskon
                        </h5>
                        <button class="btn btn-success" onclick="showAddKategoriModal()">
                            <i class="fas fa-plus me-2"></i>Tambah Kategori
                        </button>
                    </div>
                    
                    <div id="kategori-table-container">
                        <div class="text-center py-5">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted mt-3">Memuat data kategori diskon...</p>
                        </div>
                    </div>
                </div>

                <!-- Aturan Diskon Tab -->
                <div class="tab-pane fade" id="aturan" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs text-warning me-2"></i>
                            Daftar Aturan Diskon
                        </h5>
                        <button class="btn btn-primary" onclick="showAddAturanModal()">
                            <i class="fas fa-plus me-2"></i>Tambah Aturan
                        </button>
                    </div>
                    
                    <div id="aturan-table-container">
                        <div class="text-center py-5">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted mt-3">Memuat data aturan diskon...</p>
                        </div>
                    </div>
                </div>

                <!-- Hitung Diskon Tab -->
                <div class="tab-pane fade" id="hitung" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="discount-calculator">
                                <h5 class="mb-4">
                                    <i class="fas fa-calculator text-success me-2"></i>
                                    Kalkulator Diskon
                                </h5>
                                <form id="hitung-diskon-form">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="santri_id" class="form-label">
                                                <i class="fas fa-user-graduate me-2"></i>Pilih Santri
                                            </label>
                                            <select class="form-select" id="santri_id" name="santri_id" required>
                                                <option value="">Pilih Santri...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="jenis_tagihan_id" class="form-label">
                                                <i class="fas fa-file-invoice me-2"></i>Jenis Tagihan
                                            </label>
                                            <select class="form-select" id="jenis_tagihan_id" name="jenis_tagihan_id" required>
                                                <option value="">Pilih Jenis Tagihan...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="jumlah_tagihan" class="form-label">
                                                <i class="fas fa-money-bill-wave me-2"></i>Jumlah Tagihan (Rp)
                                            </label>
                                            <input type="number" class="form-control" id="jumlah_tagihan" name="jumlah_tagihan" 
                                                   min="0" step="1000" required placeholder="Masukkan jumlah tagihan">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-info-circle me-2"></i>Status
                                            </label>
                                            <div class="d-flex align-items-center h-100">
                                                <span class="status-badge" id="status-badge">
                                                    <i class="fas fa-clock me-2"></i>Menunggu Input
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success btn-lg px-5">
                                            <i class="fas fa-calculator me-2"></i>Hitung Diskon
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="result-card">
                                <h6 class="mb-3">
                                    <i class="fas fa-chart-pie text-info me-2"></i>
                                    Hasil Perhitungan
                                </h6>
                                <div id="hasil-diskon">
                                    <div class="text-muted text-center py-4">
                                        <i class="fas fa-calculator fa-3x mb-3 text-muted"></i>
                                        <p class="mb-0">Masukkan data di sebelah kiri untuk menghitung diskon</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Kategori Modal -->
    <div class="modal fade" id="addKategoriModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Tambah Kategori Diskon
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="add-kategori-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nama Kategori
                            </label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama" 
                                   required placeholder="Contoh: Anak Yatim, Prestasi Akademik">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Kategori Modal -->
    <div class="modal fade" id="editKategoriModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Kategori Diskon
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="edit-kategori-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_kategori_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nama_kategori" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nama Kategori
                            </label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama" 
                                   required placeholder="Contoh: Anak Yatim, Prestasi Akademik">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Aturan Modal -->
    <div class="modal fade" id="addAturanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Tambah Aturan Diskon
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="add-aturan-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_tagihan_aturan" class="form-label">
                                    <i class="fas fa-file-invoice me-2"></i>Jenis Tagihan
                                </label>
                                <select class="form-select" id="jenis_tagihan_aturan" name="jenis_tagihan_id" required>
                                    <option value="">Pilih Jenis Tagihan...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kategori_diskon_aturan" class="form-label">
                                    <i class="fas fa-tags me-2"></i>Kategori Diskon
                                </label>
                                <select class="form-select" id="kategori_diskon_aturan" name="kategori_diskon_id" required>
                                    <option value="">Pilih Kategori Diskon...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="diskon_persen" class="form-label">
                                    <i class="fas fa-percentage me-2"></i>Persentase Diskon (%)
                                </label>
                                <input type="number" class="form-control" id="diskon_persen" name="diskon_persen" 
                                       min="0" max="100" step="0.01" required placeholder="Contoh: 25.50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on me-2"></i>Status
                                </label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_aktif" name="is_aktif" value="1" checked>
                                    <label class="form-check-label" for="is_aktif">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Aturan Modal -->
    <div class="modal fade" id="editAturanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Aturan Diskon
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="edit-aturan-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_aturan_id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_jenis_tagihan" class="form-label">
                                    <i class="fas fa-file-invoice me-2"></i>Jenis Tagihan
                                </label>
                                <select class="form-select" id="edit_jenis_tagihan" name="jenis_tagihan_id" required>
                                    <option value="">Pilih Jenis Tagihan...</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori_diskon" class="form-label">
                                    <i class="fas fa-tags me-2"></i>Kategori Diskon
                                </label>
                                <select class="form-select" id="edit_kategori_diskon" name="kategori_diskon_id" required>
                                    <option value="">Pilih Kategori Diskon...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_diskon_persen" class="form-label">
                                    <i class="fas fa-percentage me-2"></i>Persentase Diskon (%)
                                </label>
                                <input type="number" class="form-control" id="edit_diskon_persen" name="diskon_persen" 
                                       min="0" max="100" step="0.01" required placeholder="Contoh: 25.50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on me-2"></i>Status
                                </label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="edit_is_aktif" name="is_aktif" value="1">
                                    <label class="form-check-label" for="edit_is_aktif">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadKategoriTable();
            loadAturanTable();
            loadDropdownOptions();
        });

        // Load Kategori Table
        function loadKategoriTable() {
            fetch('api_handler.php?action=get_kategori_diskon')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('kategori-table-container').innerHTML = data.html;
                    } else {
                        document.getElementById('kategori-table-container').innerHTML = 
                            '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('kategori-table-container').innerHTML = 
                        '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan saat memuat data</div>';
                });
        }

        // Load Aturan Table
        function loadAturanTable() {
            fetch('api_handler.php?action=get_diskon_rule')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('aturan-table-container').innerHTML = data.html;
                    } else {
                        document.getElementById('aturan-table-container').innerHTML = 
                            '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('aturan-table-container').innerHTML = 
                        '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan saat memuat data</div>';
                });
        }

        // Load Dropdown Options
        function loadDropdownOptions() {
            // Load santri
            fetch('api_handler.php?action=get_santri')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('santri_id');
                        select.innerHTML = '<option value="">Pilih Santri...</option>';
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
                        const select = document.getElementById('jenis_tagihan_id');
                        select.innerHTML = '<option value="">Pilih Jenis Tagihan...</option>';
                        data.data.forEach(item => {
                            select.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                        });
                    }
                });

            // Load kategori diskon
            fetch('api_handler.php?action=get_kategori_diskon')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('kategori_diskon_aturan');
                        select.innerHTML = '<option value="">Pilih Kategori Diskon...</option>';
                        data.data.forEach(item => {
                            select.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                        });
                    }
                });
        }

        // Show Add Kategori Modal
        function showAddKategoriModal() {
            const modal = new bootstrap.Modal(document.getElementById('addKategoriModal'));
            modal.show();
        }

        // Show Add Aturan Modal
        function showAddAturanModal() {
            const modal = new bootstrap.Modal(document.getElementById('addAturanModal'));
            modal.show();
        }

        // Edit Kategori
        function editKategori(id, nama) {
            document.getElementById('edit_kategori_id').value = id;
            document.getElementById('edit_nama_kategori').value = nama;
            const modal = new bootstrap.Modal(document.getElementById('editKategoriModal'));
            modal.show();
        }

        // Edit Aturan
        function editAturan(id, jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) {
            document.getElementById('edit_aturan_id').value = id;
            document.getElementById('edit_jenis_tagihan').value = jenis_tagihan_id;
            document.getElementById('edit_kategori_diskon').value = kategori_diskon_id;
            document.getElementById('edit_diskon_persen').value = diskon_persen;
            document.getElementById('edit_is_aktif').checked = is_aktif == 1;
            const modal = new bootstrap.Modal(document.getElementById('editAturanModal'));
            modal.show();
        }

        // Delete Kategori
        function deleteKategori(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori diskon ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete_kategori_diskon');
                formData.append('id', id);
                
                fetch('api_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Kategori diskon berhasil dihapus!');
                        loadKategoriTable();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        // Delete Aturan
        function deleteAturan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus aturan diskon ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete_diskon_rule');
                formData.append('id', id);
                
                fetch('api_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Aturan diskon berhasil dihapus!');
                        loadAturanTable();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        // Form Handlers
        document.getElementById('add-kategori-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add_kategori_diskon');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Kategori diskon berhasil ditambahkan!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addKategoriModal'));
                    modal.hide();
                    this.reset();
                    loadKategoriTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        document.getElementById('edit-kategori-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_kategori_diskon');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Kategori diskon berhasil diperbarui!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editKategoriModal'));
                    modal.hide();
                    loadKategoriTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        document.getElementById('add-aturan-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add_diskon_rule');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Aturan diskon berhasil ditambahkan!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addAturanModal'));
                    modal.hide();
                    this.reset();
                    loadAturanTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        document.getElementById('edit-aturan-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_diskon_rule');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Aturan diskon berhasil diperbarui!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editAturanModal'));
                    modal.hide();
                    loadAturanTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        // Calculate Diskon Form
        document.getElementById('hitung-diskon-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Update status badge
            document.getElementById('status-badge').innerHTML = 
                '<i class="fas fa-spinner fa-spin me-2"></i>Menghitung...';
            
            const formData = new FormData(this);
            formData.append('action', 'calculate_diskon');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update status badge
                    document.getElementById('status-badge').innerHTML = 
                        '<i class="fas fa-check-circle me-2"></i>Berhasil';
                    
                    const hasilDiv = document.getElementById('hasil-diskon');
                    hasilDiv.innerHTML = `
                        <div class="alert alert-success mb-0">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Hasil Perhitungan:</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Jumlah Tagihan</small>
                                        <strong class="text-dark fs-6">Rp ${data.jumlah_tagihan.toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Diskon</small>
                                        <strong class="text-success fs-6">${data.diskon_persen}%</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Jumlah Diskon</small>
                                        <strong class="text-success fs-6">Rp ${data.jumlah_diskon.toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Total Bayar</small>
                                        <strong class="text-primary fs-6">Rp ${data.total_setelah_diskon.toLocaleString()}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Update status badge
                    document.getElementById('status-badge').innerHTML = 
                        '<i class="fas fa-exclamation-triangle me-2"></i>Error';
                    
                    document.getElementById('hasil-diskon').innerHTML = `
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            ${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                // Update status badge
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-exclamation-triangle me-2"></i>Error';
                
                document.getElementById('hasil-diskon').innerHTML = `
                    <div class="alert alert-danger mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Terjadi kesalahan saat menghitung diskon
                    </div>
                `;
            });
        });

        // Tab change event to load data
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(e) {
                if (e.target.getAttribute('data-bs-target') === '#kategori') {
                    loadKategoriTable();
                } else if (e.target.getAttribute('data-bs-target') === '#aturan') {
                    loadAturanTable();
                }
            });
        });

        // Form validation and status update
        document.getElementById('santri_id').addEventListener('change', updateStatus);
        document.getElementById('jenis_tagihan_id').addEventListener('change', updateStatus);
        document.getElementById('jumlah_tagihan').addEventListener('input', updateStatus);

        function updateStatus() {
            const santri = document.getElementById('santri_id').value;
            const jenisTagihan = document.getElementById('jenis_tagihan_id').value;
            const jumlah = document.getElementById('jumlah_tagihan').value;
            
            if (santri && jenisTagihan && jumlah) {
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-check me-2"></i>Siap Hitung';
            } else if (santri || jenisTagihan || jumlah) {
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-clock me-2"></i>Lengkapi Data';
            } else {
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-clock me-2"></i>Menunggu Input';
            }
        }
    </script>
</body>
</html>
