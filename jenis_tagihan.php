<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Tagihan - Pondok Pesantren</title>
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
            <a class="nav-link active" href="jenis_tagihan.php">
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
                <h2><i class="fas fa-file-invoice text-primary me-2"></i>Jenis Tagihan</h2>
                <p class="text-muted mb-0">Kelola jenis-jenis tagihan untuk santri</p>
            </div>
            
        </div>

        <!-- Content Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Jenis Tagihan
                    </h5>
                    <button class="btn btn-success" onclick="showAddModal()">
                        <i class="fas fa-plus me-2"></i>Tambah Jenis Tagihan
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <div id="jenis-tagihan-table-container">
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
                        <i class="fas fa-plus me-2"></i>Tambah Jenis Tagihan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="add-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_tagihan" class="form-label">Nama Jenis Tagihan</label>
                            <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan" required>
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
                        <i class="fas fa-edit me-2"></i>Edit Jenis Tagihan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Jenis Tagihan</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
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
            loadJenisTagihanTable();
        });

        // Load Jenis Tagihan Table
        function loadJenisTagihanTable() {
            fetch('api_handler.php?action=get_jenis_tagihan')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('jenis-tagihan-table-container').innerHTML = data.html;
                    } else {
                        document.getElementById('jenis-tagihan-table-container').innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('jenis-tagihan-table-container').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>';
                });
        }

        // Show Add Modal
        function showAddModal() {
            const modal = new bootstrap.Modal(document.getElementById('addModal'));
            modal.show();
        }

        // Edit Jenis Tagihan
        function editJenisTagihan(id, nama) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        // Delete Jenis Tagihan
        function deleteJenisTagihan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus jenis tagihan ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete_jenis_tagihan');
                formData.append('id', id);
                
                fetch('api_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Jenis tagihan berhasil dihapus!');
                        loadJenisTagihanTable();
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
            formData.append('action', 'add_jenis_tagihan');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Jenis tagihan berhasil ditambahkan!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
                    modal.hide();
                    this.reset();
                    loadJenisTagihanTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });

        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'update_jenis_tagihan');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Jenis tagihan berhasil diperbarui!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                    modal.hide();
                    loadJenisTagihanTable();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    </script>
</body>
</html>
