<?php
require_once 'db.php';

header('Content-Type: application/json');

// Check if jenis_tagihan table exists, if not create it
$table_check = $conn->query("SHOW TABLES LIKE 'jenis_tagihan'");
if ($table_check->num_rows == 0) {
    $create_table = "CREATE TABLE `jenis_tagihan` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nama` varchar(100) NOT NULL,
        `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if (!$conn->query($create_table)) {
        die(json_encode(['success' => false, 'message' => 'Error creating table: ' . $conn->error]));
    }
} else {
    // Check if is_deleted column exists, if not add it
    $column_check = $conn->query("SHOW COLUMNS FROM `jenis_tagihan` LIKE 'is_deleted'");
    if ($column_check->num_rows == 0) {
        $add_column = "ALTER TABLE `jenis_tagihan` ADD COLUMN `is_deleted` tinyint(1) NOT NULL DEFAULT 0";
        if (!$conn->query($add_column)) {
            die(json_encode(['success' => false, 'message' => 'Error adding column: ' . $conn->error]));
        }
    }
}

// Check if santri table has is_deleted column, if not add it
$santri_column_check = $conn->query("SHOW COLUMNS FROM `santri` LIKE 'is_deleted'");
if ($santri_column_check->num_rows == 0) {
    $add_santri_column = "ALTER TABLE `santri` ADD COLUMN `is_deleted` tinyint(1) NOT NULL DEFAULT 0";
    if (!$conn->query($add_santri_column)) {
        die(json_encode(['success' => false, 'message' => 'Error adding column to santri table: ' . $conn->error]));
    }
}

// Check if santri table has is_aktif column, if not add it
$santri_aktif_check = $conn->query("SHOW COLUMNS FROM `santri` LIKE 'is_aktif'");
if ($santri_aktif_check->num_rows == 0) {
    $add_aktif_column = "ALTER TABLE `santri` ADD COLUMN `is_aktif` tinyint(1) NOT NULL DEFAULT 1";
    if (!$conn->query($add_aktif_column)) {
        die(json_encode(['success' => false, 'message' => 'Error adding is_aktif column to santri table: ' . $conn->error]));
    }
}

// Ensure kategori_diskon table exists
$kategori_diskon_table_check = $conn->query("SHOW TABLES LIKE 'kategori_diskon'");
if ($kategori_diskon_table_check->num_rows == 0) {
    $create_kategori_diskon = "CREATE TABLE `kategori_diskon` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nama` varchar(100) NOT NULL,
        `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`),
        UNIQUE KEY `uniq_nama` (`nama`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!$conn->query($create_kategori_diskon)) {
        die(json_encode(['success' => false, 'message' => 'Error creating kategori_diskon: ' . $conn->error]));
    }
} else {
    // Ensure is_deleted column exists
    $kategori_deleted_check = $conn->query("SHOW COLUMNS FROM `kategori_diskon` LIKE 'is_deleted'");
    if ($kategori_deleted_check->num_rows == 0) {
        $add_is_deleted_kategori = "ALTER TABLE `kategori_diskon` ADD COLUMN `is_deleted` tinyint(1) NOT NULL DEFAULT 0";
        if (!$conn->query($add_is_deleted_kategori)) {
            die(json_encode(['success' => false, 'message' => 'Error adding is_deleted to kategori_diskon: ' . $conn->error]));
        }
    }
}

// Ensure santri has kategori_diskon_id column
$santri_kategori_check = $conn->query("SHOW COLUMNS FROM `santri` LIKE 'kategori_diskon_id'");
if ($santri_kategori_check->num_rows == 0) {
    $add_kategori_to_santri = "ALTER TABLE `santri` ADD COLUMN `kategori_diskon_id` int(11) NULL AFTER `nomor_hp`";
    if (!$conn->query($add_kategori_to_santri)) {
        die(json_encode(['success' => false, 'message' => 'Error adding kategori_diskon_id to santri: ' . $conn->error]));
    }
}

// Ensure diskon_rule table exists
$diskon_rule_table_check = $conn->query("SHOW TABLES LIKE 'diskon_rule'");
if ($diskon_rule_table_check->num_rows == 0) {
    $create_diskon_rule = "CREATE TABLE `diskon_rule` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `jenis_tagihan_id` int(11) NOT NULL,
        `kategori_diskon_id` int(11) NOT NULL,
        `diskon_persen` decimal(5,2) NOT NULL DEFAULT 0.00,
        `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
        `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`),
        KEY `idx_jenis_tagihan` (`jenis_tagihan_id`),
        KEY `idx_kategori_diskon` (`kategori_diskon_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!$conn->query($create_diskon_rule)) {
        die(json_encode(['success' => false, 'message' => 'Error creating diskon_rule: ' . $conn->error]));
    }
} else {
    // Ensure required columns exist
    $rule_is_deleted_check = $conn->query("SHOW COLUMNS FROM `diskon_rule` LIKE 'is_deleted'");
    if ($rule_is_deleted_check->num_rows == 0) {
        if (!$conn->query("ALTER TABLE `diskon_rule` ADD COLUMN `is_deleted` tinyint(1) NOT NULL DEFAULT 0")) {
            die(json_encode(['success' => false, 'message' => 'Error adding is_deleted to diskon_rule: ' . $conn->error]));
        }
    }
    $rule_is_aktif_check = $conn->query("SHOW COLUMNS FROM `diskon_rule` LIKE 'is_aktif'");
    if ($rule_is_aktif_check->num_rows == 0) {
        if (!$conn->query("ALTER TABLE `diskon_rule` ADD COLUMN `is_aktif` tinyint(1) NOT NULL DEFAULT 1")) {
            die(json_encode(['success' => false, 'message' => 'Error adding is_aktif to diskon_rule: ' . $conn->error]));
        }
    }
}

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'add_santri':
        addSantri();
        break;
    case 'add_jenis_tagihan':
        addJenisTagihan();
        break;
    case 'get_santri':
        getSantri();
        break;
    case 'get_santri_dropdown':
        getSantriDropdown();
        break;
    case 'get_jenis_tagihan':
        getJenisTagihan();
        break;
    case 'get_jenis_tagihan_dropdown':
        getJenisTagihanDropdown();
        break;
    case 'get_kategori_diskon_dropdown':
        getKategoriDiskonDropdown();
        break;
    case 'delete_santri':
        deleteSantri();
        break;
    case 'delete_jenis_tagihan':
        deleteJenisTagihan();
        break;
    case 'edit_santri':
        editSantri();
        break;
    case 'edit_jenis_tagihan':
        editJenisTagihan();
        break;
    case 'update_santri':
        updateSantri();
        break;
    case 'update_jenis_tagihan':
        updateJenisTagihan();
        break;
    // Discount system actions
    case 'get_kategori_diskon':
        getKategoriDiskon();
        break;
    case 'add_kategori_diskon':
        addKategoriDiskon();
        break;
    case 'edit_kategori_diskon':
        editKategoriDiskon();
        break;
    case 'update_kategori_diskon':
        updateKategoriDiskon();
        break;
    case 'delete_kategori_diskon':
        deleteKategoriDiskon();
        break;
    case 'get_diskon_rule':
        getDiskonRule();
        break;
    case 'add_diskon_rule':
        addDiskonRule();
        break;
    case 'edit_diskon_rule':
        editDiskonRule();
        break;
    case 'update_diskon_rule':
        updateDiskonRule();
        break;
    case 'delete_diskon_rule':
        deleteDiskonRule();
        break;
    case 'calculate_diskon':
        calculateDiskon();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

function addSantri() {
    global $conn;
    
    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $nomor_hp = trim($_POST['nomor_hp'] ?? '');
    $is_aktif = (int)($_POST['aktif'] ?? 1);
    
    if (empty($nama) || empty($kelas) || empty($nomor_hp)) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
        return;
    }
    
    // Check if nama already exists
    $stmt = $conn->prepare("SELECT id FROM santri WHERE nama = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nama santri sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Insert new santri
    $stmt = $conn->prepare("INSERT INTO santri (nama, kelas, nomor_hp, is_aktif, is_deleted) VALUES (?, ?, ?, ?, 0)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    $stmt->bind_param("sssi", $nama, $kelas, $nomor_hp, $is_aktif);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Santri berhasil ditambahkan!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan santri: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function addJenisTagihan() {
    global $conn;
    
    $nama = trim($_POST['nama_tagihan'] ?? '');
    
    if (empty($nama)) {
        echo json_encode(['success' => false, 'message' => 'Nama jenis tagihan harus diisi!']);
        return;
    }
    
    // Check if nama already exists
    $stmt = $conn->prepare("SELECT id FROM jenis_tagihan WHERE nama = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nama jenis tagihan sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Insert new jenis tagihan
    $stmt = $conn->prepare("INSERT INTO jenis_tagihan (nama, is_deleted) VALUES (?, 0)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $nama);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Jenis tagihan berhasil ditambahkan!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan jenis tagihan: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function getSantri() {
    global $conn;
    
    $query = "SELECT * FROM santri WHERE is_deleted = 0 ORDER BY nama";
    $result = $conn->query($query);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $html = '';
    if ($result->num_rows > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Nama</th>';
        $html .= '<th>Kelas</th>';
        $html .= '<th>Nomor HP</th>';
        $html .= '<th>Status</th>';
        $html .= '<th>Aksi</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            $status_class = $row['is_aktif'] ? 'status-active' : 'status-inactive';
            $status_text = $row['is_aktif'] ? 'Aktif' : 'Tidak Aktif';
            
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['nama']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['kelas']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['nomor_hp']) . '</td>';
            $html .= '<td><span class="status-badge ' . $status_class . '">' . $status_text . '</span></td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editSantri(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-edit me-1"></i>Edit</button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteSantri(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-trash me-1"></i>Hapus</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-inbox"></i>';
        $html .= '<h5>Belum ada data santri</h5>';
        $html .= '<p>Mulai dengan menambahkan santri pertama</p>';
        $html .= '</div>';
    }
    
    echo json_encode(['success' => true, 'html' => $html]);
}

function getJenisTagihan() {
    global $conn;
    
    $query = "SELECT * FROM jenis_tagihan WHERE is_deleted = 0 ORDER BY nama";
    $result = $conn->query($query);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $html = '';
    if ($result->num_rows > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th width="10%">No</th>';
        $html .= '<th width="70%">Jenis Tagihan</th>';
        $html .= '<th width="20%">Aksi</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td><span class="badge bg-primary rounded-pill">' . $no++ . '</span></td>';
            $html .= '<td>';
            $html .= '<div class="d-flex align-items-center">';
            $html .= '<i class="fas fa-tag text-primary me-3"></i>';
            $html .= '<span class="fw-semibold">' . htmlspecialchars($row['nama']) . '</span>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editJenisTagihan(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-edit me-1"></i>Edit</button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteJenisTagihan(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-trash me-1"></i>Hapus</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-inbox"></i>';
        $html .= '<h5>Belum ada jenis tagihan</h5>';
        $html .= '<p>Mulai dengan menambahkan jenis tagihan pertama</p>';
        $html .= '</div>';
    }
    
    echo json_encode(['success' => true, 'html' => $html]);
}

function getSantriDropdown() {
    global $conn;
    
    $query = "SELECT id, nama, kelas FROM santri WHERE is_deleted = 0 AND is_aktif = 1 ORDER BY nama";
    $result = $conn->query($query);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'kelas' => $row['kelas']
        ];
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
}

function getJenisTagihanDropdown() {
    global $conn;
    
    $query = "SELECT id, nama FROM jenis_tagihan WHERE is_deleted = 0 ORDER BY nama";
    $result = $conn->query($query);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'nama' => $row['nama']
        ];
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
}

function getKategoriDiskonDropdown() {
    global $conn;
    $query = "SELECT id, nama FROM kategori_diskon WHERE is_deleted = 0 ORDER BY nama";
    $result = $conn->query($query);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [ 'id' => $row['id'], 'nama' => $row['nama'] ];
    }
    echo json_encode(['success' => true, 'data' => $data]);
}

function deleteSantri() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
        return;
    }
    
    // Soft delete - set is_deleted to 1
    $stmt = $conn->prepare("UPDATE santri SET is_deleted = 1 WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Santri berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus santri: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function deleteJenisTagihan() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
        return;
    }
    
    // Soft delete - set is_deleted to 1
    $stmt = $conn->prepare("UPDATE jenis_tagihan SET is_deleted = 1 WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Jenis tagihan berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus jenis tagihan: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function editSantri() {
    global $conn;
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT * FROM santri WHERE id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Santri tidak ditemukan!']);
        $stmt->close();
        return;
    }
    
    $santri = $result->fetch_assoc();
    $stmt->close();
    
    echo json_encode(['success' => true, 'data' => $santri]);
}

function editJenisTagihan() {
    global $conn;
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT * FROM jenis_tagihan WHERE id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Jenis tagihan tidak ditemukan!']);
        $stmt->close();
        return;
    }
    
    $jenis_tagihan = $result->fetch_assoc();
    $stmt->close();
    
    echo json_encode(['success' => true, 'data' => $jenis_tagihan]);
}

function updateSantri() {
    global $conn;
    
    // Debug: Log received data
    error_log("updateSantri - POST data: " . print_r($_POST, true));
    
    $id = (int)($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $nomor_hp = trim($_POST['nomor_hp'] ?? '');
    $is_aktif = (int)($_POST['aktif'] ?? 1);
    
    // Debug: Log processed data
    error_log("updateSantri - Processed data: id=$id, nama='$nama', kelas='$kelas', nomor_hp='$nomor_hp', is_aktif=$is_aktif");
    
    if ($id <= 0 || empty($nama) || empty($kelas) || empty($nomor_hp)) {
        $missing_fields = [];
        if ($id <= 0) $missing_fields[] = 'ID';
        if (empty($nama)) $missing_fields[] = 'Nama';
        if (empty($kelas)) $missing_fields[] = 'Kelas';
        if (empty($nomor_hp)) $missing_fields[] = 'Nomor HP';
        
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap! Field yang kosong: ' . implode(', ', $missing_fields)]);
        return;
    }
    
    // Check if nama already exists (excluding current record)
    $stmt = $conn->prepare("SELECT id FROM santri WHERE nama = ? AND id != ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("si", $nama, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nama santri sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Update santri
    $stmt = $conn->prepare("UPDATE santri SET nama = ?, kelas = ?, nomor_hp = ?, is_aktif = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    $stmt->bind_param("sssii", $nama, $kelas, $nomor_hp, $is_aktif, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Santri berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui santri: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function updateJenisTagihan() {
    global $conn;
    
    // Debug: Log received data
    error_log("updateJenisTagihan - POST data: " . print_r($_POST, true));
    
    $id = (int)($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    
    // Debug: Log processed data
    error_log("updateJenisTagihan - Processed data: id=$id, nama='$nama'");
    
    if ($id <= 0 || empty($nama)) {
        $missing_fields = [];
        if ($id <= 0) $missing_fields[] = 'ID';
        if (empty($nama)) $missing_fields[] = 'Nama';
        
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap! Field yang kosong: ' . implode(', ', $missing_fields)]);
        return;
    }
    
    // Check if nama already exists (excluding current record)
    $stmt = $conn->prepare("SELECT id FROM jenis_tagihan WHERE nama = ? AND id != ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("si", $nama, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nama jenis tagihan sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Update jenis tagihan
    $stmt = $conn->prepare("UPDATE jenis_tagihan SET nama = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("si", $nama, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Jenis tagihan berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui jenis tagihan: ' . $stmt->error]);
    }
    
    $stmt->close();
}

// ========================================
// DISCOUNT SYSTEM FUNCTIONS
// ========================================

function getKategoriDiskon() {
    global $conn;
    
    $query = "SELECT * FROM kategori_diskon WHERE is_deleted = 0 ORDER BY nama";
    error_log("getKategoriDiskon query: " . $query);
    $result = $conn->query($query);
    
    if (!$result) {
        error_log("getKategoriDiskon database error: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    error_log("getKategoriDiskon found " . $result->num_rows . " rows");
    
    $html = '';
    if ($result->num_rows > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead><tr><th>ID</th><th>Nama Kategori</th><th>Aksi</th></tr></thead>';
        $html .= '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($row['nama']) . '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editKategoriDiskon(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-edit me-1"></i>Edit</button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteKategoriDiskon(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-trash me-1"></i>Hapus</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-inbox"></i>';
        $html .= '<h5>Belum ada kategori diskon</h5>';
        $html .= '<p>Mulai dengan menambahkan kategori diskon pertama</p>';
        $html .= '</div>';
    }
    
    error_log("getKategoriDiskon returning HTML length: " . strlen($html));
    echo json_encode(['success' => true, 'html' => $html]);
}

function addKategoriDiskon() {
    global $conn;
    
    $nama = trim($_REQUEST['nama'] ?? '');
    
    // Log untuk debugging
    error_log("addKategoriDiskon called with nama: " . $nama);
    
    if (empty($nama)) {
        echo json_encode(['success' => false, 'message' => 'Nama kategori diskon harus diisi!']);
        return;
    }
    
    // Check if nama already exists (including soft-deleted)
    $stmt = $conn->prepare("SELECT id, is_deleted FROM kategori_diskon WHERE nama = ? LIMIT 1");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        // If previously soft-deleted, reactivate instead of failing unique constraint
        if ((int)$row['is_deleted'] === 1) {
            $reactivate = $conn->prepare("UPDATE kategori_diskon SET is_deleted = 0 WHERE id = ?");
            if ($reactivate === false) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
                return;
            }
            $reactivate->bind_param("i", $row['id']);
            if ($reactivate->execute()) {
                echo json_encode(['success' => true, 'message' => 'Kategori diskon diaktifkan kembali.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengaktifkan kembali kategori: ' . $reactivate->error]);
            }
            $reactivate->close();
            return;
        }
        // Active duplicate
        echo json_encode(['success' => false, 'message' => 'Nama kategori diskon sudah ada!']);
        return;
    }
    $stmt->close();
    
    // Insert new kategori diskon
    $stmt = $conn->prepare("INSERT INTO kategori_diskon (nama) VALUES (?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $nama);
    
    if ($stmt->execute()) {
        $inserted_id = $conn->insert_id;
        error_log("Kategori diskon berhasil ditambahkan dengan ID: " . $inserted_id);
        echo json_encode(['success' => true, 'message' => 'Kategori diskon berhasil ditambahkan!', 'id' => $inserted_id]);
    } else {
        error_log("Gagal menambahkan kategori diskon: " . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan kategori diskon: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function editKategoriDiskon() {
    global $conn;
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID kategori diskon tidak valid!']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT * FROM kategori_diskon WHERE id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Kategori diskon tidak ditemukan!']);
        $stmt->close();
        return;
    }
    
    $data = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $data]);
    
    $stmt->close();
}

function updateKategoriDiskon() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');
    
    if ($id <= 0 || empty($nama)) {
        $missing_fields = [];
        if ($id <= 0) $missing_fields[] = 'ID';
        if (empty($nama)) $missing_fields[] = 'Nama';
        
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap! Field yang kosong: ' . implode(', ', $missing_fields)]);
        return;
    }
    
    // Check if nama already exists (excluding current record)
    $stmt = $conn->prepare("SELECT id FROM kategori_diskon WHERE nama = ? AND id != ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("si", $nama, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nama kategori diskon sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Update kategori diskon
    $stmt = $conn->prepare("UPDATE kategori_diskon SET nama = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("si", $nama, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Kategori diskon berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui kategori diskon: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function deleteKategoriDiskon() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID kategori diskon tidak valid!']);
        return;
    }
    
    // Check if kategori diskon is being used
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM santri WHERE kategori_diskon_id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'Kategori diskon tidak dapat dihapus karena masih digunakan oleh santri!']);
        return;
    }
    
    // Check if kategori diskon is being used in diskon rules
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM diskon_rule WHERE kategori_diskon_id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'Kategori diskon tidak dapat dihapus karena masih digunakan dalam aturan diskon!']);
        return;
    }
    
    // Soft delete kategori diskon
    $stmt = $conn->prepare("UPDATE kategori_diskon SET is_deleted = 1 WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Kategori diskon berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus kategori diskon: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function getDiskonRule() {
    global $conn;
    
    $query = "SELECT dr.*, jt.nama as jenis_tagihan_nama, kd.nama as kategori_diskon_nama 
              FROM diskon_rule dr 
              LEFT JOIN jenis_tagihan jt ON dr.jenis_tagihan_id = jt.id 
              LEFT JOIN kategori_diskon kd ON dr.kategori_diskon_id = kd.id 
              WHERE dr.is_deleted = 0 
              ORDER BY jt.nama, kd.nama";
    $result = $conn->query($query);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $html = '';
    if ($result->num_rows > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead><tr><th>Jenis Tagihan</th><th>Kategori Diskon</th><th>Persentase</th><th>Status</th><th>Aksi</th></tr></thead>';
        $html .= '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            $status_badge = $row['is_aktif'] ? 
                '<span class="status-badge status-active">Aktif</span>' : 
                '<span class="status-badge status-inactive">Tidak Aktif</span>';
            
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['jenis_tagihan_nama']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['kategori_diskon_nama']) . '</td>';
            $html .= '<td>' . $row['diskon_persen'] . '%</td>';
            $html .= '<td>' . $status_badge . '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editDiskonRule(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-edit me-1"></i>Edit</button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteDiskonRule(' . $row['id'] . ')">';
            $html .= '<i class="fas fa-trash me-1"></i>Hapus</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-inbox"></i>';
        $html .= '<h5>Belum ada aturan diskon</h5>';
        $html .= '<p>Mulai dengan menambahkan aturan diskon pertama</p>';
        $html .= '</div>';
    }
    
    echo json_encode(['success' => true, 'html' => $html]);
}

function addDiskonRule() {
    global $conn;
    
    $jenis_tagihan_id = (int)($_POST['jenis_tagihan_id'] ?? 0);
    $kategori_diskon_id = (int)($_POST['kategori_diskon_id'] ?? 0);
    $diskon_persen = (float)($_POST['diskon_persen'] ?? 0);
    $is_aktif = (int)($_POST['is_aktif'] ?? 1);
    
    if ($jenis_tagihan_id <= 0 || $kategori_diskon_id <= 0 || $diskon_persen < 0 || $diskon_persen > 100) {
        echo json_encode(['success' => false, 'message' => 'Data tidak valid! Pastikan semua field diisi dengan benar.']);
        return;
    }
    
    // Check if rule already exists
    $stmt = $conn->prepare("SELECT id FROM diskon_rule WHERE jenis_tagihan_id = ? AND kategori_diskon_id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("ii", $jenis_tagihan_id, $kategori_diskon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Aturan diskon untuk kombinasi ini sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Insert new diskon rule
    $stmt = $conn->prepare("INSERT INTO diskon_rule (jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("iidi", $jenis_tagihan_id, $kategori_diskon_id, $diskon_persen, $is_aktif);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Aturan diskon berhasil ditambahkan!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan aturan diskon: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function editDiskonRule() {
    global $conn;
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID aturan diskon tidak valid!']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT * FROM diskon_rule WHERE id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Aturan diskon tidak ditemukan!']);
        $stmt->close();
        return;
    }
    
    $data = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $data]);
    
    $stmt->close();
}

function updateDiskonRule() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    $jenis_tagihan_id = (int)($_POST['jenis_tagihan_id'] ?? 0);
    $kategori_diskon_id = (int)($_POST['kategori_diskon_id'] ?? 0);
    $diskon_persen = (float)($_POST['diskon_persen'] ?? 0);
    $is_aktif = (int)($_POST['is_aktif'] ?? 1);
    
    if ($id <= 0 || $jenis_tagihan_id <= 0 || $kategori_diskon_id <= 0 || $diskon_persen < 0 || $diskon_persen > 100) {
        echo json_encode(['success' => false, 'message' => 'Data tidak valid! Pastikan semua field diisi dengan benar.']);
        return;
    }
    
    // Check if rule already exists (excluding current record)
    $stmt = $conn->prepare("SELECT id FROM diskon_rule WHERE jenis_tagihan_id = ? AND kategori_diskon_id = ? AND id != ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("iii", $jenis_tagihan_id, $kategori_diskon_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Aturan diskon untuk kombinasi ini sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Update diskon rule
    $stmt = $conn->prepare("UPDATE diskon_rule SET jenis_tagihan_id = ?, kategori_diskon_id = ?, diskon_persen = ?, is_aktif = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("iidii", $jenis_tagihan_id, $kategori_diskon_id, $diskon_persen, $is_aktif, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Aturan diskon berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui aturan diskon: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function deleteDiskonRule() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID aturan diskon tidak valid!']);
        return;
    }
    
    // Soft delete diskon rule
    $stmt = $conn->prepare("UPDATE diskon_rule SET is_deleted = 1 WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Aturan diskon berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus aturan diskon: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function calculateDiskon() {
    global $conn;
    
    $santri_id = (int)($_POST['santri_id'] ?? 0);
    $jenis_tagihan_id = (int)($_POST['jenis_tagihan_id'] ?? 0);
    $jumlah_tagihan = (float)($_POST['jumlah_tagihan'] ?? 0);
    
    if ($santri_id <= 0 || $jenis_tagihan_id <= 0 || $jumlah_tagihan <= 0) {
        echo json_encode(['success' => false, 'message' => 'Data tidak valid!']);
        return;
    }
    
    // Get santri's discount category
    $stmt = $conn->prepare("SELECT s.nama as nama_santri, kd.nama as kategori_diskon, kd.id as kategori_diskon_id 
                           FROM santri s 
                           LEFT JOIN kategori_diskon kd ON s.kategori_diskon_id = kd.id 
                           WHERE s.id = ? AND s.is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $santri_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Santri tidak ditemukan!']);
        $stmt->close();
        return;
    }
    
    $santri_data = $result->fetch_assoc();
    $stmt->close();
    
    // If no discount category, return no discount
    if (!$santri_data['kategori_diskon_id']) {
        echo json_encode([
            'success' => true,
            'data' => [
                'nama_santri' => $santri_data['nama_santri'],
                'kategori_diskon' => 'Tidak ada',
                'diskon_persen' => 0,
                'jumlah_diskon' => 0,
                'jumlah_setelah_diskon' => $jumlah_tagihan
            ]
        ]);
        return;
    }
    
    // Get discount rule
    $stmt = $conn->prepare("SELECT dr.diskon_persen 
                           FROM diskon_rule dr 
                           WHERE dr.jenis_tagihan_id = ? 
                           AND dr.kategori_diskon_id = ? 
                           AND dr.is_aktif = 1 
                           AND dr.is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("ii", $jenis_tagihan_id, $santri_data['kategori_diskon_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // No discount rule found
        echo json_encode([
            'success' => true,
            'data' => [
                'nama_santri' => $santri_data['nama_santri'],
                'kategori_diskon' => $santri_data['kategori_diskon'],
                'diskon_persen' => 0,
                'jumlah_diskon' => 0,
                'jumlah_setelah_diskon' => $jumlah_tagihan
            ]
        ]);
        $stmt->close();
        return;
    }
    
    $diskon_data = $result->fetch_assoc();
    $stmt->close();
    
    $diskon_persen = $diskon_data['diskon_persen'];
    $jumlah_diskon = ($jumlah_tagihan * $diskon_persen) / 100;
    $jumlah_setelah_diskon = $jumlah_tagihan - $jumlah_diskon;
    
    echo json_encode([
        'success' => true,
        'data' => [
            'nama_santri' => $santri_data['nama_santri'],
            'kategori_diskon' => $santri_data['kategori_diskon'],
            'diskon_persen' => $diskon_persen,
            'jumlah_diskon' => $jumlah_diskon,
            'jumlah_setelah_diskon' => $jumlah_setelah_diskon
        ]
    ]);
}
?> 