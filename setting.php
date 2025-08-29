<?php
require_once "db.php";

$alert = "";

// ====== PROSES SIMPAN / UPDATE ======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'] ?? '';
    $key       = trim($_POST['key'] ?? '');
    $val       = $_POST['value'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';

    // Cek apakah key sudah ada
    if ($id) {
        $cek = $conn->prepare("SELECT id FROM setting WHERE `key`=? AND id<>? AND is_deleted=0");
        $cek->bind_param("si", $key, $id);
    } else {
        $cek = $conn->prepare("SELECT id FROM setting WHERE `key`=? AND is_deleted=0");
        $cek->bind_param("s", $key);
    }
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $alert = "<div class='alert alert-danger alert-dismissible fade show'>
                    <i class='fas fa-exclamation-triangle me-2'></i>
                    Key <strong>$key</strong> sudah ada, gunakan nama lain!
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
    } else {
        if ($id) {
            // Update
            $stmt = $conn->prepare("UPDATE setting 
                                    SET `key`=?, `value`=?, `deskripsi`=?, updated_at=NOW()
                                    WHERE id=?");
            $stmt->bind_param("sssi", $key, $val, $deskripsi, $id);
        } else {
            // Insert baru
            $stmt = $conn->prepare("INSERT INTO setting (`key`, `value`, `deskripsi`, updated_at)
                                    VALUES (?,?,?,NOW())");
            $stmt->bind_param("sss", $key, $val, $deskripsi);
        }

        if ($stmt->execute()) {
            $alert = "<div class='alert alert-success alert-dismissible fade show'>
                        <i class='fas fa-check-circle me-2'></i>
                        Data berhasil disimpan!
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                      </div>";
        }
    }
}

// ====== PROSES HAPUS (SOFT DELETE) ======
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("UPDATE setting SET is_deleted=1, updated_at=NOW() WHERE id=$id");
    header("Location: setting.php?msg=deleted");
    exit;
}

// ====== TAMPILAN PESAN DELETE ======
if (isset($_GET['msg']) && $_GET['msg'] == "deleted") {
    $alert = "<div class='alert alert-warning alert-dismissible fade show'>
                <i class='fas fa-trash-alt me-2'></i>
                Data berhasil dihapus (soft delete).
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Pondok Pesantren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px; color: white; overflow-y: auto;
        }
        .main-content { margin-left: 280px; padding: 20px; }
        .nav-link { color: rgba(255, 255, 255, 0.8); padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; transition: all 0.3s ease; }
        .nav-link:hover, .nav-link.active { color: white; background-color: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); margin-bottom: 20px; }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; border: none; }
        .btn-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 8px; }
        .table th { background-color: #f8f9fa; border-top: none; font-weight: 600; }
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
            <a class="nav-link" href="index.php"><i class="fas fa-users me-2"></i> Daftar Santri</a>
            <a class="nav-link" href="tagihan_santri.php"><i class="fas fa-file-invoice me-2"></i> Tagihan</a>
            <a class="nav-link" href="jenis_tagihan.php"><i class="fas fa-file-invoice me-2"></i> Jenis Tagihan</a>
            <a class="nav-link" href="sistem_diskon_new.php"><i class="fas fa-percentage me-2"></i> Sistem Diskon</a>
            <a class="nav-link active" href="setting.php"><i class="fas fa-cogs me-2"></i> Setting</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="fas fa-cogs text-primary me-2"></i> Pengaturan Sistem</h2>
                <p class="text-muted mb-0">Kelola konfigurasi sistem pondok pesantren</p>
            </div>
        </div>

        <?= $alert ?>

        <!-- Form Tambah/Edit Pengaturan -->
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-plus me-2"></i> Tambah / Edit Pengaturan</h5>
          </div>
          <div class="card-body">
            <form method="POST">
              <input type="hidden" name="id" id="id">

              <div class="mb-3">
                <label for="setting_key" class="form-label">Nama Setting</label>
                <input type="text" class="form-control" name="key" id="setting_key" required>
              </div>

              <div class="mb-3">
                <label for="setting_value" class="form-label">Nilai Setting</label>
                <input type="text" class="form-control" name="value" id="setting_value" required>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="text" class="form-control" name="deskripsi" id="description">
              </div>

              <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
              <button type="reset" class="btn btn-secondary">Batal</button>
            </form>
          </div>
        </div>

        <!-- Daftar Pengaturan -->
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Daftar Pengaturan</h5>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="50">ID</th>
                  <th>Nama Setting</th>
                  <th>Nilai Setting</th>
                  <th>Deskripsi</th>
                  <th width="150">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $result = $conn->query("SELECT * FROM setting WHERE is_deleted=0 ORDER BY id ASC");
              while($row = $result->fetch_assoc()):
              ?>
                <tr>
                  <td><?= htmlspecialchars($row['id']); ?></td>
                  <td><?= htmlspecialchars($row['key']); ?></td>
                  <td><?= htmlspecialchars($row['value']); ?></td>
                  <td><?= $row['deskripsi'] ? htmlspecialchars($row['deskripsi']) : '-'; ?></td>
                  <td>
                    <button class="btn btn-sm btn-warning" onclick='editSetting(<?= json_encode((string)$row["id"]) ?>, <?= json_encode($row["key"]) ?>, <?= json_encode($row["value"]) ?>, <?= json_encode($row["deskripsi"]) ?>)'>Edit</button>
                    <a href="setting.php?delete=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                  </td>
                </tr>
              <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function editSetting(id, key, val, desc) {
        document.getElementById('id').value = id;
        document.getElementById('setting_key').value = key;
        document.getElementById('setting_value').value = val;
        document.getElementById('description').value = desc;
      }
    </script>
</body>
</html>
