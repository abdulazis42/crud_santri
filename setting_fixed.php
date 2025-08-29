<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Pondok Pesantren</title>
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
        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            border-radius: 8px;
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .setting-key {
            font-family: 'Courier New', monospace;
            background-color: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .setting-value {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .setting-description {
            color: #6c757d;
            font-size: 0.9em;
            font-style: italic;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-active {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        .empty-state h5 {
            margin-bottom: 0.5rem;
            color: #495057;
        }
        .empty-state p {
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            font-family: monospace;
            font-size: 0.9em;
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
            <a class="nav-link" href="jenis_tagihan.php">
                <i class="fas fa-file-invoice me-2"></i>
                Jenis Tagihan
            </a>
            <a class="nav-link" href="sistem_diskon_new.php">
                <i class="fas fa-percentage me-2"></i>
                Sistem Diskon
            </a>
            <a class="nav-link active" href="setting_fixed.php">
                <i class="fas fa-cogs me-2"></i>
                Pengaturan Sistem
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
                <h2><i class="fas fa-cogs text-primary me-2"></i>Pengaturan Sistem</h2>
                <p class="text-muted mb-0">Kelola konfigurasi sistem pondok pesantren</p>
            </div>
        </div>

        <!-- Debug Info -->
        <div class="debug-info">
            <h6><i class="fas fa-bug me-2"></i>Debug Information</h6>
            <p><strong>Current URL:</strong> <span id="current-url"></span></p>
            <p><strong>API Endpoint:</strong> <span id="api-endpoint"></span></p>
            <p><strong>Status:</strong> <span id="debug-status">Ready</span></p>
            <button class="btn btn-sm btn-outline-primary" onclick="testAPI()">Test API</button>
            <button class="btn btn-sm btn-outline-success" onclick="loadSettingTable()">Load Data</button>
        </div>

        <!-- Content Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Pengaturan
                    </h5>
                    <button class="btn btn-success" onclick="showAddModal()">
                        <i class="fas fa-plus me-2"></i>Tambah Pengaturan
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <div id="setting-table-container">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data pengaturan...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Tambah Pengaturan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="add-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="key" class="form-label">
                                    <i class="fas fa-key me-2"></i>Kunci Pengaturan
                                </label>
                                <input type="text" class="form-control" id="key" name="key" required 
                                       placeholder="Contoh: app_name, max_students">
                                <div class="form-text">Kunci unik untuk pengaturan (hanya huruf, angka, dan underscore)</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Nilai
                                </label>
                                <input type="text" class="form-control" id="value" name="value" required 
                                       placeholder="Contoh: Pondok Pesantren Al-Hikmah">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Deskripsi
                            </label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required
                                      placeholder="Jelaskan fungsi dari pengaturan ini"></textarea>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Pengaturan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_key" class="form-label">
                                    <i class="fas fa-key me-2"></i>Kunci Pengaturan
                                </label>
                                <input type="text" class="form-control" id="edit_key" name="key" required readonly>
                                <div class="form-text">Kunci tidak dapat diubah setelah dibuat</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_value" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Nilai
                                </label>
                                <input type="text" class="form-control" id="edit_value" name="value" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Deskripsi
                            </label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
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
        // Debug information
        document.getElementById('current-url').textContent = window.location.href;
        document.getElementById('api-endpoint').textContent = 'api_handler.php?action=get_setting';
        
        // Load data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing...');
            updateDebugStatus('Page loaded, ready to load data');
            loadSettingTable();
        });

        // Update debug status
        function updateDebugStatus(message) {
            document.getElementById('debug-status').textContent = message;
            console.log('Debug Status:', message);
        }

        // Test API function
        async function testAPI() {
            updateDebugStatus('Testing API...');
            try {
                const response = await fetch('api_handler.php?action=get_setting');
                console.log('API Response Status:', response.status);
                console.log('API Response Headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('API Response Data:', data);
                
                if (data.success) {
                    updateDebugStatus(`API Test Success - HTML Length: ${data.html ? data.html.length : 'No HTML'}`);
                    alert('API Test Success! Check console for details.');
                } else {
                    updateDebugStatus(`API Test Failed - ${data.message || 'Unknown error'}`);
                    alert('API Test Failed: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('API Test Error:', error);
                updateDebugStatus(`API Test Error - ${error.message}`);
                alert('API Test Error: ' + error.message);
            }
        }

        // Load Setting Table
        async function loadSettingTable() {
            updateDebugStatus('Loading setting table...');
            console.log('Loading setting table...');
            
            try {
                const response = await fetch('api_handler.php?action=get_setting');
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Response data:', data);
                
                if (data.success) {
                    document.getElementById('setting-table-container').innerHTML = data.html;
                    updateDebugStatus(`Data loaded successfully - ${data.html ? data.html.length : 'No'} characters`);
                    console.log('Setting table updated successfully');
                } else {
                    document.getElementById('setting-table-container').innerHTML = 
                        '<div class="alert alert-danger">Error: ' + data.message + '</div>';
                    updateDebugStatus(`Data load failed - ${data.message || 'Unknown error'}`);
                    console.error('API error:', data.message);
                }
            } catch (error) {
                console.error('Load error:', error);
                document.getElementById('setting-table-container').innerHTML = 
                    '<div class="alert alert-danger">Terjadi kesalahan saat memuat data: ' + error.message + '</div>';
                updateDebugStatus(`Load error - ${error.message}`);
            }
        }

        // Show Add Modal
        function showAddModal() {
            const modal = new bootstrap.Modal(document.getElementById('addModal'));
            modal.show();
        }

        // Edit Setting
        function editSetting(id, key, value, deskripsi) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_key').value = key;
            document.getElementById('edit_value').value = value;
            document.getElementById('edit_deskripsi').value = deskripsi;
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        // Delete Setting
        function deleteSetting(id, key) {
            if (confirm(`Apakah Anda yakin ingin menghapus pengaturan "${key}"?`)) {
                updateDebugStatus('Deleting setting...');
                const formData = new FormData();
                formData.append('action', 'delete_setting');
                formData.append('id', id);
                
                fetch('api_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pengaturan berhasil dihapus!');
                        updateDebugStatus('Setting deleted successfully');
                        loadSettingTable();
                    } else {
                        alert('Error: ' + data.message);
                        updateDebugStatus(`Delete failed - ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus pengaturan');
                    updateDebugStatus(`Delete error - ${error.message}`);
                });
            }
        }

        // Form Handlers
        document.getElementById('add-form').addEventListener('submit', function(e) {
            e.preventDefault();
            updateDebugStatus('Adding new setting...');
            const formData = new FormData(this);
            formData.append('action', 'add_setting');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pengaturan berhasil ditambahkan!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
                    modal.hide();
                    this.reset();
                    updateDebugStatus('Setting added successfully');
                    loadSettingTable();
                } else {
                    alert('Error: ' + data.message);
                    updateDebugStatus(`Add failed - ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan pengaturan');
                updateDebugStatus(`Add error - ${error.message}`);
            });
        });

        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            updateDebugStatus('Updating setting...');
            const formData = new FormData(this);
            formData.append('action', 'update_setting');
            
            fetch('api_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pengaturan berhasil diperbarui!');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                    modal.hide();
                    updateDebugStatus('Setting updated successfully');
                    loadSettingTable();
                } else {
                    alert('Error: ' + data.message);
                    updateDebugStatus(`Update failed - ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui pengaturan');
                updateDebugStatus(`Update error - ${error.message}`);
            });
        });
    </script>
</body>
</html>
