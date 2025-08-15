<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Santri - Pondok Pesantren</title>
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
            
            <a class="nav-link active" href="index.php">
                <i class="fas fa-users me-2"></i>
                Daftar Santri
            </a>
            <a class="nav-link" href="jenis_tagihan.php">
                <i class="fas fa-file-invoice me-2"></i>
                Jenis Tagihan
            </a>
            <a class="nav-link" href="sistem_diskon_new.php">
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
                <h2><i class="fas fa-users text-primary me-2"></i>Daftar Santri</h2>
                <p class="text-muted mb-0">Kelola data santri pondok pesantren</p>
            </div>
            
        </div>

        <!-- Content Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Santri
                    </h5>
                    <button class="btn btn-success" onclick="showAddModal()">
                        <i class="fas fa-plus me-2"></i>Tambah Santri
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <div id="santri-table-container">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Tambah Santri
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="add-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Santri</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" checked>
                                <label class="form-check-label" for="aktif">
                                    Aktif
                                </label>
                            </div>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Santri
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Santri</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="edit_kelas" name="kelas" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="edit_nomor_hp" name="nomor_hp" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_aktif" name="aktif" value="1">
                                <label class="form-check-label" for="edit_aktif">
                                    Aktif
                                </label>
                            </div>
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
        // Load data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadSantriTable();
        });

        // Load Santri Table
        function loadSantriTable() {
            fetch('api_handler.php?action=get_santri')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('santri-table-container').innerHTML = data.html;
                    } else {
                        document.getElementById('santri-table-container').innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('santri-table-container').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>';
                });
        }

        // Show Add Modal
        function showAddModal() {
            const modal = new bootstrap.Modal(document.getElementById('addModal'));
            modal.show();
        }

        // Edit Santri
        function editSantri(id, nama, kelas, nomor_hp, is_aktif) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kelas').value = kelas;
            document.getElementById('edit_nomor_hp').value = nomor_hp;
            document.getElementById('edit_aktif').checked = is_aktif == 1;
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        // Delete Santri
        function deleteSantri(id) {
            if (confirm('Apakah Anda yakin ingin menghapus santri ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete_santri');
                formData.append('id', id);
                
                fetch('api_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Santri berhasil dihapus!');
                        loadSantriTable();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        // Form Handlers
        document.getElementById('add-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'add_santri');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Santri berhasil ditambahkan!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
                    modal.hide();
                    this.reset();
                    loadSantriTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_santri');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Santri berhasil diperbarui!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                    modal.hide();
                    loadSantriTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    </script>
</body>
</html> 