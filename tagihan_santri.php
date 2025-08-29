<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Santri - Pondok Pesantren</title>
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
            <a class="nav-link active" href="tagihan_santri.php">
                <i class="fas fa-file-invoice me-2"></i>
                Tagihan
            </a>
            <a class="nav-link" href="jenis_tagihan.php">
                <i class="fas fa-file-invoice me-2"></i>
                Jenis Tagihan
            </a>
            <a class="nav-link" href="sistem_diskon_new.php">
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
                <h2><i class="fas fa-file-invoice text-primary me-2"></i>Tagihan Santri</h2>
                <p class="text-muted mb-0">Kelola data tagihan santri</p>
            </div>
        </div>

        <!-- Content Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Tagihan
                    </h5>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTagihanModal">
                        <i class="fas fa-plus me-2"></i>Tambah Tagihan
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <div id="tagihan-table-container">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Tagihan Modal -->
    <div class="modal fade" id="addTagihanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Tambah Tagihan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="add-tagihan-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_tagihan" class="form-label">Nama Tagihan</label>
                            <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_tagihan_id" class="form-label">Jenis Tagihan</label>
                            <select class="form-select" id="jenis_tagihan_id" name="jenis_tagihan_id" required>
                                <!-- Opsi jenis tagihan akan diisi oleh JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                            <input type="date" class="form-control" id="tanggal_tagihan" name="tanggal_tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="deadline_tagihan" class="form-label">Deadline Tagihan</label>
                            <input type="date" class="form-control" id="deadline_tagihan" name="deadline_tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="target" class="form-label">Target</label>
                            <input type="text" class="form-control" id="target" name="target" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tagihan Modal -->
    <div class="modal fade" id="editTagihanModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Tagihan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="edit-tagihan-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_tagihan_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nama_tagihan" class="form-label">Nama Tagihan</label>
                            <input type="text" class="form-control" id="edit_nama_tagihan" name="nama_tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jenis_tagihan_id" class="form-label">Jenis Tagihan</label>
                            <select class="form-select" id="edit_jenis_tagihan_id" name="jenis_tagihan_id" required>
                                <!-- Opsi jenis tagihan akan diisi oleh JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_tagihan" class="form-label">Tanggal Tagihan</label>
                            <input type="date" class="form-control" id="edit_tanggal_tagihan" name="tanggal_tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deadline_tagihan" class="form-label">Deadline Tagihan</label>
                            <input type="date" class="form-control" id="edit_deadline_tagihan" name="deadline_tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_target" class="form-label">Target</label>
                            <input type="text" class="form-control" id="edit_target" name="target" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadTagihanTable();
            loadJenisTagihanDropdown();
        });

        function loadJenisTagihanDropdown() {
            fetch('./api_handler.php?action=get_jenis_tagihan_dropdown')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const addSelect = document.getElementById('jenis_tagihan_id');
                        const editSelect = document.getElementById('edit_jenis_tagihan_id');
                        
                        if(addSelect) {
                            addSelect.innerHTML = '<option value="">Pilih Jenis Tagihan</option>';
                            data.data.forEach(item => {
                                addSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                            });
                        }
                        
                        if(editSelect) {
                            editSelect.innerHTML = '<option value="">Pilih Jenis Tagihan</option>';
                            data.data.forEach(item => {
                                editSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                            });
                        }
                    }
                })
                .catch(error => console.error('Error loading jenis tagihan:', error));
        }

        function loadJenisTagihanDropdownEdit(selectedId = null) {
            fetch('./api_handler.php?action=get_jenis_tagihan_dropdown')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('edit_jenis_tagihan_id');
                        select.innerHTML = '<option value="">Pilih Jenis Tagihan</option>';
                        data.data.forEach(item => {
                            const selected = item.id == selectedId ? 'selected' : '';
                            select.innerHTML += `<option value="${item.id}" ${selected}>${item.nama}</option>`;
                        });
                    }
                });
        }

        function loadTagihanTable() {
            fetch('./api_handler.php?action=get_tagihan')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('tagihan-table-container').innerHTML = data.html;
                    } else {
                        document.getElementById('tagihan-table-container').innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('tagihan-table-container').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data tagihan</div>';
                });
        }

        function editTagihan(id, nama_tagihan, jenis_tagihan_id, tanggal_tagihan, deadline_tagihan, target) {
            document.getElementById('edit_tagihan_id').value = id;
            document.getElementById('edit_nama_tagihan').value = nama_tagihan;
            document.getElementById('edit_tanggal_tagihan').value = tanggal_tagihan;
            document.getElementById('edit_deadline_tagihan').value = deadline_tagihan;
            document.getElementById('edit_target').value = target;
            loadJenisTagihanDropdownEdit(jenis_tagihan_id);
            const modal = new bootstrap.Modal(document.getElementById('editTagihanModal'));
            modal.show();
        }

        function deleteTagihan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus tagihan ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete_tagihan');
                formData.append('id', id);
                
                fetch('api_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Tagihan berhasil dihapus!');
                        loadTagihanTable();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        document.getElementById('add-tagihan-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add_tagihan');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Tagihan berhasil ditambahkan!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addTagihanModal'));
                    modal.hide();
                    this.reset();
                    loadTagihanTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        document.getElementById('edit-tagihan-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_tagihan');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Tagihan berhasil diperbarui!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editTagihanModal'));
                    modal.hide();
                    loadTagihanTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    </script>
</body>
</html>