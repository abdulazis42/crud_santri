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
            background-color: #f8f9fa;
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
        }
        .main-content {
            margin-left: 280px;
            padding: 20px;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
        }
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .btn-close {
            filter: invert(1);
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
        .tab-content {
            background: white;
            border-radius: 0 0 15px 15px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
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
            
            <a class="nav-link" href="index.php">
                <i class="fas fa-users me-2"></i>
                Daftar Santri
            </a>
            <a class="nav-link" href="tagihan_santri.php">
                <i class="fas fa-file-invoice me-2"></i>
                Tagihan
            </a>
            <a class="nav-link" href="jenis_tagihan.php">
                <i class="fas fa-file-invoice me-2"></i>
                Jenis Tagihan
            </a>
            <a class="nav-link active" href="sistem_diskon_new.php">
                <i class="fas fa-percentage me-2"></i>
                Sistem Diskon
            </a>
            <a class="nav-link" href="setting.php">
                <i class="fas fa-cogs me-2"></i>
                Setting
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
                <p class="text-muted mb-0">Kelola kategori diskon dan aturan diskon untuk santri</p>
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
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" onclick="loadKategoriTable()">
                                <i class="fas fa-rotate-right me-2"></i>Muat Ulang
                            </button>
                            <button class="btn btn-info" onclick="testAddKategori()">
                                <i class="fas fa-bug me-2"></i>Test Add
                            </button>
                            <button class="btn btn-success" onclick="showAddKategoriModal()">
                                <i class="fas fa-plus me-2"></i>Tambah Kategori
                            </button>
                        </div>
                    </div>

				<!-- Inline Add Kategori (tepat di atas tabel) -->
				<form id="inline-add-kategori-form" class="row g-2 align-items-end mb-3">
					<div class="col-12">
						<div id="inline-add-kategori-error-message" class="alert alert-danger d-none mb-2"></div>
					</div>
					<div class="col-12 col-md-6 col-lg-5">
						<label for="inline_nama_kategori" class="form-label mb-1">Tambah Kategori Baru</label>
						<input type="text" class="form-control" id="inline_nama_kategori" name="nama" placeholder="Contoh: Anak Yatim" required>
					</div>
					<div class="col-12 col-md-auto">
						<button type="submit" class="btn btn-success mt-3 mt-md-0">
							<i class="fas fa-plus me-2"></i>Simpan
						</button>
					</div>
				</form>
                    
                    <div id="kategori-table-container">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary mb-3"></div>
                            <p class="text-muted">Memuat data kategori diskon...</p>
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
                            <div class="spinner-border text-primary mb-3"></div>
                            <p class="text-muted">Memuat data aturan diskon...</p>
                        </div>
                    </div>
                </div>

                <!-- Hitung Diskon Tab -->
                <div class="tab-pane fade" id="hitung" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-calculator text-success me-2"></i>
                                        Kalkulator Diskon
                                    </h5>
                                </div>
                                <div class="card-body">
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
                                                    <span class="badge bg-secondary" id="status-badge">
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
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-pie text-info me-2"></i>
                                        Hasil Perhitungan
                                    </h6>
                                </div>
                                <div class="card-body">
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
						<div id="add-kategori-error-message" class="alert alert-danger d-none"></div>
						<div class="mb-3">
							<label for="nama_kategori" class="form-label">
								<i class="fas fa-tag me-2"></i>Nama Kategori
							</label>
							<input type="text" class="form-control" id="nama_kategori" name="nama" required placeholder="Contoh: Anak Yatim, Prestasi">
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
						<div id="add-aturan-error-message" class="alert alert-danger d-none"></div>
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
								<input type="number" class="form-control" id="diskon_persen" name="diskon_persen" min="0" max="100" step="0.01" required placeholder="Contoh: 25.50">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label">
									<i class="fas fa-toggle-on me-2"></i>Status
								</label>
								<div class="form-check form-switch mt-2">
									<input class="form-check-input" type="checkbox" id="is_aktif" name="is_aktif" value="1" checked>
									<label class="form-check-label" for="is_aktif">Aktif</label>
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

	<!-- Modal Edit Kategori Diskon -->
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
							<label for="edit_kategori_nama" class="form-label">Nama Kategori</label>
							<input type="text" class="form-control" id="edit_kategori_nama" name="nama" required>
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

	<!-- Modal Edit Aturan Diskon -->
	<div class="modal fade" id="editAturanModal" tabindex="-1">
		<div class="modal-dialog">
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
						<div class="mb-3">
							<label for="edit_aturan_jenis_tagihan_id" class="form-label">Jenis Tagihan</label>
							<select class="form-select" id="edit_aturan_jenis_tagihan_id" name="jenis_tagihan_id" required>
								<option value="">Pilih Jenis Tagihan</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="edit_aturan_kategori_diskon_id" class="form-label">Kategori Diskon</label>
							<select class="form-select" id="edit_aturan_kategori_diskon_id" name="kategori_diskon_id" required>
								<option value="">Pilih Kategori Diskon</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="edit_aturan_diskon_persen" class="form-label">Persentase Diskon (%)</label>
							<input type="number" class="form-control" id="edit_aturan_diskon_persen" name="diskon_persen" min="0" max="100" step="0.01" required>
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="edit_aturan_is_aktif" name="is_aktif" value="1">
								<label class="form-check-label" for="edit_aturan_is_aktif">Aktif</label>
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
            console.log('DOM loaded, initializing...');
            loadKategoriTable();
            loadAturanTable();
            loadDropdownOptions();
            console.log('Initialization complete');
        });

        // Load Kategori Table
        function loadKategoriTable() {
            console.log('Loading kategori table...');
            const container = document.getElementById('kategori-table-container');
            if (!container) {
                console.error('Kategori table container not found!');
                return;
            }
            
            fetch('api_handler.php?action=get_kategori_diskon', { 
                cache: 'no-store',
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                }
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('get_kategori_diskon response:', data);
                    if (data && data.success && data.html) {
                        container.innerHTML = data.html;
                        console.log('Kategori table updated successfully, HTML length:', data.html.length);
                    } else if (data && data.success && !data.html) {
                        container.innerHTML = '<div class="alert alert-info mb-0">Belum ada kategori diskon.</div>';
                        console.log('No kategori data found');
                    } else if (data && data.message) {
                        container.innerHTML = '<div class="alert alert-danger mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Error: ' + data.message + '</div>';
                        console.error('API error:', data.message);
                    } else {
                        container.innerHTML = '<div class="alert alert-danger mb-0">Gagal memuat data kategori.</div>';
                        console.error('Unexpected response format:', data);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    if (container) {
                        container.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan saat memuat data</div>';
                    }
                });
        }

        // Load Aturan Table
        function loadAturanTable() {
            fetch('api_handler.php?action=get_diskon_rule', { cache: 'no-store' })
                .then(response => response.json())
                .then(data => {
                    console.log('get_diskon_rule response:', data);
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
            fetch('api_handler.php?action=get_santri_dropdown')
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
            fetch('api_handler.php?action=get_jenis_tagihan_dropdown')
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

            // Load kategori diskon (untuk modal tambah aturan)
            fetch('api_handler.php?action=get_kategori_diskon_dropdown')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('kategori_diskon_aturan');
                    if (select && data.success) {
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

        // Show Add Aturan Modal (hindari multi-open)
        let addAturanModalInstance = null;
        function showAddAturanModal() {
            populateAturanDropdowns();
            if (!addAturanModalInstance) {
                addAturanModalInstance = new bootstrap.Modal(document.getElementById('addAturanModal'));
            }
            addAturanModalInstance.show();
        }

		function populateAturanDropdowns() {
			console.log('Populating aturan dropdowns...');
			// jenis tagihan
			fetch('api_handler.php?action=get_jenis_tagihan_dropdown')
				.then(r => r.json())
				.then(data => {
					if (data.success) {
						const sel = document.getElementById('jenis_tagihan_aturan');
						if (sel) {
							sel.innerHTML = '<option value="">Pilih Jenis Tagihan...</option>';
							data.data.forEach(it => sel.innerHTML += `<option value="${it.id}">${it.nama}</option>`);
							console.log('Jenis tagihan dropdown updated');
						}
						
						// Juga populate dropdown edit aturan
						const editSel = document.getElementById('edit_aturan_jenis_tagihan_id');
						if (editSel) {
							editSel.innerHTML = '<option value="">Pilih Jenis Tagihan...</option>';
							data.data.forEach(it => editSel.innerHTML += `<option value="${it.id}">${it.nama}</option>`);
						}
					}
				})
				.catch(error => console.error('Error loading jenis tagihan dropdown:', error));
				
			// kategori diskon
			fetch('api_handler.php?action=get_kategori_diskon_dropdown')
				.then(r => r.json())
				.then(data => {
					if (data.success) {
						const sel = document.getElementById('kategori_diskon_aturan');
						if (sel) {
							sel.innerHTML = '<option value="">Pilih Kategori Diskon...</option>';
							(data.data || []).forEach(it => sel.innerHTML += `<option value="${it.id}">${it.nama}</option>`);
							console.log('Kategori diskon dropdown updated with', data.data.length, 'items');
						}
						
						// Juga populate dropdown edit aturan
						const editSel = document.getElementById('edit_aturan_kategori_diskon_id');
						if (editSel) {
							editSel.innerHTML = '<option value="">Pilih Kategori Diskon...</option>';
							(data.data || []).forEach(it => editSel.innerHTML += `<option value="${it.id}">${it.nama}</option>`);
						}
					}
				})
				.catch(error => console.error('Error loading kategori diskon dropdown:', error));
		}

        // Calculate Diskon Form
        document.getElementById('hitung-diskon-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Update status badge
            document.getElementById('status-badge').innerHTML = 
                '<i class="fas fa-spinner fa-spin me-2"></i>Menghitung...';
            document.getElementById('status-badge').className = 'badge bg-warning';
            
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
                    document.getElementById('status-badge').className = 'badge bg-success';
                    
                    const payload = data.data || {};
                    const jumlahTagihan = Number(document.getElementById('jumlah_tagihan').value || 0);
                    const diskonPersen = Number(payload.diskon_persen || 0);
                    const jumlahDiskon = Number(payload.jumlah_diskon || 0);
                    const totalBayar = Number(payload.jumlah_setelah_diskon || (jumlahTagihan - jumlahDiskon));
                    
                    const hasilDiv = document.getElementById('hasil-diskon');
                    hasilDiv.innerHTML = `
                        <div class="alert alert-success mb-0">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Hasil Perhitungan:</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Jumlah Tagihan</small>
                                        <strong class="text-dark fs-6">Rp ${jumlahTagihan.toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Diskon</small>
                                        <strong class="text-success fs-6">${diskonPersen}%</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Jumlah Diskon</small>
                                        <strong class="text-success fs-6">Rp ${jumlahDiskon.toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">Total Bayar</small>
                                        <strong class="text-primary fs-6">Rp ${totalBayar.toLocaleString()}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    // Update status badge
                    document.getElementById('status-badge').innerHTML = 
                        '<i class="fas fa-exclamation-triangle me-2"></i>Error';
                    document.getElementById('status-badge').className = 'badge bg-danger';
                    
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
                document.getElementById('status-badge').className = 'badge bg-danger';
                
                document.getElementById('hasil-diskon').innerHTML = `
                    <div class="alert alert-danger mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Terjadi kesalahan saat menghitung diskon
                    </div>
                `;
            });

		// Handle submit: Tambah Kategori
		document.getElementById('add-kategori-form').addEventListener('submit', function(e) {
			e.preventDefault();
			const formData = new FormData(this);
			formData.append('action', 'add_kategori_diskon');
			fetch('api_handler.php', { method: 'POST', body: formData })
				.then(r => r.json())
				.then(data => {
					if (data.success) {
						bootstrap.Modal.getInstance(document.getElementById('addKategoriModal')).hide();
						this.reset();
						loadKategoriTable();
                    // Refresh dropdown pada modal aturan agar kategori baru muncul
                    populateAturanDropdowns();
						alert('Kategori diskon berhasil ditambahkan');
					} else {
						const errorMessageDiv = document.getElementById('add-kategori-error-message');
						errorMessageDiv.textContent = 'Gagal menambah kategori: ' + data.message;
						errorMessageDiv.classList.remove('d-none');
					}
				})
				.catch(error => {
					console.error('Fetch error (add-kategori-form):', error); // Tambahkan logging
					const errorMessageDiv = document.getElementById('add-kategori-error-message');
					errorMessageDiv.textContent = 'Terjadi kesalahan saat menambah kategori: ' + error.message; // Tampilkan pesan error
					errorMessageDiv.classList.remove('d-none');
				});
		});

		// Handle submit: Tambah Kategori (inline) - dengan loading state dan feedback
		const inlineKategoriForm = document.getElementById('inline-add-kategori-form');
		let isSubmittingKategori = false;
		
		if (inlineKategoriForm) {
			console.log('Inline kategori form found, adding event listener');
			inlineKategoriForm.addEventListener('submit', function(e) {
				e.preventDefault();
				console.log('Inline form submitted');
				
				if (isSubmittingKategori) {
					console.log('Already submitting, ignoring');
					return; // cegah submit berulang
				}
				
				const input = document.getElementById('inline_nama_kategori');
				const submitBtn = inlineKategoriForm.querySelector('button[type="submit"]');
				const nama = (input.value || '').trim();
				
				console.log('Nama kategori:', nama);
				
				if (!nama) { 
					console.log('Nama kosong, focusing input');
					input.focus(); 
					return; 
				}
				
				// Set loading state
				isSubmittingKategori = true;
				const originalText = submitBtn.innerHTML;
				submitBtn.disabled = true;
				submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
				
				console.log('Sending request to API...');
				const formData = new FormData();
				formData.append('action', 'add_kategori_diskon');
				formData.append('nama', nama);
				
				fetch('api_handler.php', { method: 'POST', body: formData })
					.then(r => {
						console.log('Response status:', r.status);
						return r.json();
					})
					.then(data => {
						console.log('API response:', data);
						if (data.success) {
							console.log('Success! Refreshing table...');
							// Clear input dan refresh tabel
							input.value = '';
							
							// Refresh tabel dengan delay kecil untuk memastikan data sudah tersimpan
							setTimeout(() => {
								loadKategoriTable();
								populateAturanDropdowns();
							}, 100);
							
							// Show success feedback
							submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Berhasil!';
							submitBtn.className = 'btn btn-success';
							setTimeout(() => {
								submitBtn.innerHTML = originalText;
								submitBtn.className = 'btn btn-primary';
							}, 2000);
						} else {
							console.log('API error:', data.message);
							// Show error feedback
							const inlineErrorMessageDiv = document.getElementById('inline-add-kategori-error-message');
							inlineErrorMessageDiv.textContent = 'Gagal menambah kategori: ' + (data.message || 'Terjadi kesalahan.');
							inlineErrorMessageDiv.classList.remove('d-none');
							submitBtn.innerHTML = originalText;
							submitBtn.className = 'btn btn-primary';
						}
					})
					.catch(error => {
						console.error('Fetch error (inline-add-kategori-form):', error); // Tambahkan logging
						const inlineErrorMessageDiv = document.getElementById('inline-add-kategori-error-message');
						inlineErrorMessageDiv.textContent = 'Terjadi kesalahan saat menambah kategori: ' + error.message; // Tampilkan pesan error
						inlineErrorMessageDiv.classList.remove('d-none');
						submitBtn.innerHTML = originalText;
						submitBtn.className = 'btn btn-primary';
					})
					.finally(() => {
						isSubmittingKategori = false;
						submitBtn.disabled = false;
					});
			});
		} else {
			console.error('Inline kategori form not found!');
		}

		// Handle submit: Tambah Aturan
		// Submit Tambah Aturan (hindari multiple submit)
		const addAturanForm = document.getElementById('add-aturan-form');
		let isSubmittingAturan = false;
		addAturanForm.addEventListener('submit', function(e) {
		    e.preventDefault();
		    if (isSubmittingAturan) return; // cegah klik berulang
		    isSubmittingAturan = true;
		    const submitBtn = addAturanForm.querySelector('button[type="submit"]');
		    const originalText = submitBtn.innerHTML;
		    submitBtn.disabled = true;
		    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
		    const formData = new FormData(addAturanForm);
		    formData.append('action', 'add_diskon_rule');
		    if (!formData.has('is_aktif')) { formData.append('is_aktif', '0'); }

		    // Sembunyikan pesan error sebelumnya
		    document.getElementById('add-aturan-error-message').classList.add('d-none');

		    fetch('api_handler.php', { method: 'POST', body: formData })
		        .then(r => r.json())
		        .then(data => {
		            if (data.success) {
		                addAturanModalInstance && addAturanModalInstance.hide();
		                addAturanForm.reset();
		                loadAturanTable();
		                alert('Aturan diskon berhasil ditambahkan!'); // Notifikasi sukses
		            } else {
		                const errorMessageDiv = document.getElementById('add-aturan-error-message');
		                errorMessageDiv.textContent = 'Gagal menambah aturan: ' + (data.message || 'Terjadi kesalahan.');
		                errorMessageDiv.classList.remove('d-none');
		            }
		        })
		        .catch(error => {
		            console.error('Fetch error (add-aturan-form):', error); // Tambahkan logging
		            const errorMessageDiv = document.getElementById('add-aturan-error-message');
		            errorMessageDiv.textContent = 'Terjadi kesalahan saat menambah aturan: ' + error.message; // Tampilkan pesan error
		            errorMessageDiv.classList.remove('d-none');
		        })
		        .finally(() => {
		            isSubmittingAturan = false;
		            submitBtn.disabled = false;
		            submitBtn.innerHTML = originalText;
		        });
		});

        // Handle submit: Edit Kategori
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
                    // Refresh dropdown pada modal aturan
                    populateAturanDropdowns();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Fetch error (edit-kategori-form):', error); // Tambahkan logging
                alert('Terjadi kesalahan saat memperbarui kategori diskon: ' + error.message); // Tampilkan pesan error
            });
        });

        // Handle submit: Edit Aturan
        document.getElementById('edit-aturan-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_diskon_rule');
            if (!formData.has('is_aktif')) { formData.append('is_aktif', '0'); }
            
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
            })
            .catch(error => {
                console.error('Fetch error (edit-aturan-form):', error); // Tambahkan logging
                alert('Terjadi kesalahan saat memperbarui aturan diskon: ' + error.message); // Tampilkan pesan error
            });
        });
        });

        // Form validation and status update
        document.getElementById('santri_id').addEventListener('change', updateStatus);
        document.getElementById('jenis_tagihan_id').addEventListener('change', updateStatus);
        document.getElementById('jumlah_tagihan').addEventListener('input', updateStatus);

        // Muat Ulang button event listener
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('button') && e.target.closest('button').textContent.includes('Muat Ulang')) {
                e.preventDefault();
                console.log('Muat Ulang button clicked');
                loadKategoriTable();
            }
        });

        // Test function untuk debugging
        function testAddKategori() {
            console.log('Test add kategori function called');
            const formData = new FormData();
            formData.append('action', 'add_kategori_diskon');
            formData.append('nama', 'TestKategori_' + Date.now());
            
            fetch('api_handler.php', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    console.log('Test API response:', data);
                    if (data.success) {
                        alert('Test berhasil! ID: ' + data.id);
                        loadKategoriTable();
                    } else {
                        alert('Test gagal: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error (testAddKategori):', error); // Tambahkan logging
                    alert('Test error: ' + error.message);
                });
        }

        // Fungsi Edit Kategori Diskon
        function editKategori(id, nama) {
            document.getElementById('edit_kategori_id').value = id;
            document.getElementById('edit_kategori_nama').value = nama;
            const modal = new bootstrap.Modal(document.getElementById('editKategoriModal'));
            modal.show();
        }

        // Fungsi Delete Kategori Diskon
        function deleteKategori(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus kategori diskon "${nama}"?`)) {
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
                })
                .catch(error => {
                    console.error('Fetch error (deleteKategori):', error); // Tambahkan logging
                    alert('Terjadi kesalahan saat menghapus kategori diskon: ' + error.message); // Tampilkan pesan error
                });
            }
        }

        // Fungsi Edit Aturan Diskon
        function editAturan(id, jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) {
            document.getElementById('edit_aturan_id').value = id;
            document.getElementById('edit_aturan_jenis_tagihan_id').value = jenis_tagihan_id;
            document.getElementById('edit_aturan_kategori_diskon_id').value = kategori_diskon_id;
            document.getElementById('edit_aturan_diskon_persen').value = diskon_persen;
            document.getElementById('edit_aturan_is_aktif').checked = is_aktif == 1;
            const modal = new bootstrap.Modal(document.getElementById('editAturanModal'));
            modal.show();
        }

        // Fungsi Delete Aturan Diskon
        function deleteAturan(id, jenis_tagihan_nama, kategori_diskon_nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus aturan diskon untuk "${jenis_tagihan_nama}" - "${kategori_diskon_nama}"?`)) {
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
                })
                .catch(error => {
                    console.error('Fetch error (deleteAturan):', error); // Tambahkan logging
                    alert('Terjadi kesalahan saat menghapus aturan diskon: ' + error.message); // Tampilkan pesan error
                });
            }
        }

        function updateStatus() {
            const santri = document.getElementById('santri_id').value;
            const jenisTagihan = document.getElementById('jenis_tagihan_id').value;
            const jumlah = document.getElementById('jumlah_tagihan').value;
            
            if (santri && jenisTagihan && jumlah) {
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-check me-2"></i>Siap Hitung';
                document.getElementById('status-badge').className = 'badge bg-success';
            } else if (santri || jenisTagihan || jumlah) {
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-clock me-2"></i>Lengkapi Data';
                document.getElementById('status-badge').className = 'badge bg-warning';
            } else {
                document.getElementById('status-badge').innerHTML = 
                    '<i class="fas fa-clock me-2"></i>Menunggu Input';
                document.getElementById('status-badge').className = 'badge bg-secondary';
            }
        }
    </script>
</body>
</html>