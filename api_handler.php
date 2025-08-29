<?php
error_log("api_handler.php accessed at " . date('Y-m-d H:i:s')); // Tambahkan log ini
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

// Ensure setting table exists
$setting_table_check = $conn->query("SHOW TABLES LIKE 'setting'");
if ($setting_table_check->num_rows == 0) {
    $create_setting = "CREATE TABLE `setting` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `key` varchar(100) NOT NULL,
        `value` text NOT NULL,
        `deskripsi` text NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_key` (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!$conn->query($create_setting)) {
        die(json_encode(['success' => false, 'message' => 'Error creating setting table: ' . $conn->error]));
    }
    
    // Insert default settings
    $default_settings = [
        ['app_name', 'Pondok Pesantren', 'Nama aplikasi yang ditampilkan'],
        ['app_version', '1.0.0', 'Versi aplikasi saat ini'],
        ['timezone', 'Asia/Jakarta', 'Zona waktu aplikasi'],
        ['currency', 'IDR', 'Mata uang default'],
        ['per_page', '10', 'Jumlah data per halaman'],
        ['date_format', 'Y-m-d', 'Format tanggal default'],
        ['time_format', 'H:i:s', 'Format waktu default']
    ];
    
    foreach ($default_settings as $setting) {
        $stmt = $conn->prepare("INSERT INTO setting (`key`, `value`, `deskripsi`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $setting[0], $setting[1], $setting[2]);
        $stmt->execute();
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
    // Setting actions
    case 'get_setting':
        getSetting();
        break;
    case 'add_setting':
        addSetting();
        break;
    case 'edit_setting':
        editSetting();
        break;
    case 'update_setting':
        updateSetting();
        break;
    case 'delete_setting':
        deleteSetting();
        break;
    case 'add_tagihan':
        addTagihan();
        break;
    case 'get_tagihan':
        getTagihan();
        break;
    case 'edit_tagihan':
        editTagihan();
        break;
    case 'update_tagihan':
        updateTagihan();
        break;
    case 'delete_tagihan':
        deleteTagihan();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

// Pastikan tabel tagihan ada
$tagihan_table_check = $conn->query("SHOW TABLES LIKE 'tagihan'");
if ($tagihan_table_check->num_rows == 0) {
    $create_tagihan_table = "CREATE TABLE `tagihan` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nama_tagihan` varchar(255) NOT NULL,
        `jenis_tagihan_id` int(11) NOT NULL,
        `tanggal_tagihan` date NOT NULL,
        `deadline_tagihan` date NOT NULL,
        `target` varchar(255) NOT NULL,
        `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`jenis_tagihan_id`) REFERENCES `jenis_tagihan`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!$conn->query($create_tagihan_table)) {
        die(json_encode(['success' => false, 'message' => 'Error creating tagihan table: ' . $conn->error]));
    }
} else {
    // Pastikan kolom is_deleted ada
    $tagihan_deleted_check = $conn->query("SHOW COLUMNS FROM `tagihan` LIKE 'is_deleted'");
    if ($tagihan_deleted_check->num_rows == 0) {
        if (!$conn->query("ALTER TABLE `tagihan` ADD COLUMN `is_deleted` tinyint(1) NOT NULL DEFAULT 0")) {
            die(json_encode(['success' => false, 'message' => 'Error adding is_deleted to tagihan: ' . $conn->error]));
        }
    }
}

function addTagihan() {
    global $conn;

    $nama_tagihan = trim($_POST['nama_tagihan'] ?? '');
    $jenis_tagihan_id = (int)($_POST['jenis_tagihan_id'] ?? 0);
    $tanggal_tagihan = trim($_POST['tanggal_tagihan'] ?? '');
    $deadline_tagihan = trim($_POST['deadline_tagihan'] ?? '');
    $target = trim($_POST['target'] ?? '');

    if (empty($nama_tagihan) || $jenis_tagihan_id <= 0 || empty($tanggal_tagihan) || empty($deadline_tagihan) || empty($target)) {
        echo json_encode(['success' => false, 'message' => 'Semua field tagihan harus diisi!']);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO tagihan (nama_tagihan, jenis_tagihan_id, tanggal_tagihan, deadline_tagihan, target, is_deleted) VALUES (?, ?, ?, ?, ?, 0)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }

    $stmt->bind_param("sisss", $nama_tagihan, $jenis_tagihan_id, $tanggal_tagihan, $deadline_tagihan, $target);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Tagihan berhasil ditambahkan!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan tagihan: ' . $stmt->error]);
    }

    $stmt->close();
}

function getTagihan() {
    global $conn;
    
    $query = "SELECT t.*, jt.nama AS jenis_tagihan_nama FROM tagihan t JOIN jenis_tagihan jt ON t.jenis_tagihan_id = jt.id WHERE t.is_deleted = 0 ORDER BY t.tanggal_tagihan DESC";
    error_log("getTagihan query: " . $query); // Log query
    $result = $conn->query($query);
    
    if (!$result) {
        error_log("getTagihan database error: " . $conn->error); // Log database error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $tagihan = [];
    while ($row = $result->fetch_assoc()) {
        $tagihan[] = $row;
    }
    
    error_log("getTagihan found " . count($tagihan) . " rows"); // Log number of rows
    
    $html = '';
    if (count($tagihan) > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Nama Tagihan</th>';
        $html .= '<th>Jenis Tagihan</th>';
        $html .= '<th>Tanggal Tagihan</th>';
        $html .= '<th>Deadline Tagihan</th>';
        $html .= '<th>Target</th>';
        $html .= '<th>Aksi</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        foreach ($tagihan as $item) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($item['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['nama_tagihan']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['jenis_tagihan_nama']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['tanggal_tagihan']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['deadline_tagihan']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['target']) . '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editTagihan(' . $item['id'] . ', \'' . addslashes(htmlspecialchars($item['nama_tagihan'])) . '\', ' . $item['jenis_tagihan_id'] . ', \'' . addslashes(htmlspecialchars($item['tanggal_tagihan'])) . '\', \'' . addslashes(htmlspecialchars($item['deadline_tagihan'])) . '\', \'' . addslashes(htmlspecialchars($item['target'])) . '\')"><i class="fas fa-edit me-1"></i>Edit</button> | ';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteTagihan(' . $item['id'] . ')"><i class="fas fa-trash me-1"></i>Hapus</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-inbox"></i>';
        $html .= '<h5>Belum ada data tagihan</h5>';
        $html .= '<p>Silakan tambahkan tagihan.</p>';
        $html .= '</div>';
    }
    
    echo json_encode(['success' => true, 'html' => $html]);
}

function editTagihan() {
    global $conn;

    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tagihan tidak valid!']);
        return;
    }

    $stmt = $conn->prepare("SELECT * FROM tagihan WHERE id = ? AND is_deleted = 0");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Tagihan tidak ditemukan!']);
        $stmt->close();
        return;
    }

    $tagihan = $result->fetch_assoc();
    $stmt->close();

    echo json_encode(['success' => true, 'data' => $tagihan]);
}

function updateTagihan() {
    global $conn;

    $id = (int)($_POST['id'] ?? 0);
    $nama_tagihan = trim($_POST['nama_tagihan'] ?? '');
    $jenis_tagihan_id = (int)($_POST['jenis_tagihan_id'] ?? 0);
    $tanggal_tagihan = trim($_POST['tanggal_tagihan'] ?? '');
    $deadline_tagihan = trim($_POST['deadline_tagihan'] ?? '');
    $target = trim($_POST['target'] ?? '');

    if ($id <= 0 || empty($nama_tagihan) || $jenis_tagihan_id <= 0 || empty($tanggal_tagihan) || empty($deadline_tagihan) || empty($target)) {
        echo json_encode(['success' => false, 'message' => 'Semua field tagihan harus diisi!']);
        return;
    }

    $stmt = $conn->prepare("UPDATE tagihan SET nama_tagihan = ?, jenis_tagihan_id = ?, tanggal_tagihan = ?, deadline_tagihan = ?, target = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }

    $stmt->bind_param("sisssi", $nama_tagihan, $jenis_tagihan_id, $tanggal_tagihan, $deadline_tagihan, $target, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Tagihan berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui tagihan: ' . $stmt->error]);
    }

    $stmt->close();
}

function deleteTagihan() {
    global $conn;

    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tagihan tidak valid!']);
        return;
    }

    $stmt = $conn->prepare("UPDATE tagihan SET is_deleted = 1 WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Tagihan berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus tagihan: ' . $stmt->error]);
    }

    $stmt->close();
}

function addSantri() {
    global $conn;

    error_log("addSantri: POST data received: " . print_r($_POST, true));

    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $nomor_hp = trim($_POST['nomor_hp'] ?? '');
    $is_aktif = (int)($_POST['aktif'] ?? 1);
    $kategori_diskon_id = !empty($_POST['kategori_diskon_id']) ? (int)$_POST['kategori_diskon_id'] : null;

    error_log("addSantri: Processed data - Nama: '$nama', Kelas: '$kelas', Nomor HP: '$nomor_hp', Aktif: $is_aktif, Kategori Diskon ID: " . ($kategori_diskon_id ?? 'NULL'));
    
    if (empty($nama) || empty($kelas) || empty($nomor_hp)) {
        error_log("addSantri: Validation failed - missing fields.");
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
        return;
    }
    
    // Check if nama already exists
    $stmt = $conn->prepare("SELECT id FROM santri WHERE nama = ? AND is_deleted = 0");
    if ($stmt === false) {
        error_log("addSantri: Database error during name check prepare: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        error_log("addSantri: Validation failed - duplicate name: '$nama'.");
        echo json_encode(['success' => false, 'message' => 'Nama santri sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Insert new santri
    $stmt = $conn->prepare("INSERT INTO santri (nama, kelas, nomor_hp, is_aktif, kategori_diskon_id, is_deleted) VALUES (?, ?, ?, ?, ?, 0)");
    if ($stmt === false) {
        error_log("addSantri: Database error during insert prepare: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    $stmt->bind_param("sssii", $nama, $kelas, $nomor_hp, $is_aktif, $kategori_diskon_id);
    
    if ($stmt->execute()) {
        error_log("addSantri: Santri added successfully. ID: " . $conn->insert_id);
        echo json_encode(['success' => true, 'message' => 'Santri berhasil ditambahkan!']);
    } else {
        error_log("addSantri: Failed to add santri: " . $stmt->error);
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
    
    $query = "SELECT s.*, kd.nama as kategori_diskon_nama 
              FROM santri s 
              LEFT JOIN kategori_diskon kd ON s.kategori_diskon_id = kd.id 
              WHERE s.is_deleted = 0 
              ORDER BY s.nama";
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
        $html .= '<th>Kategori Diskon</th>';
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
            $html .= '<td>' . ($row['kategori_diskon_id'] ? '<span class="badge bg-info">' . htmlspecialchars($row['kategori_diskon_nama'] ?? 'Kategori') . '</span>' : '<span class="badge bg-secondary">Tidak Ada</span>') . '</td>';
            $html .= '<td><span class="status-badge ' . $status_class . '">' . $status_text . '</span></td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editSantri(' . $row['id'] . ', \'' . htmlspecialchars($row['nama']) . '\', \'' . htmlspecialchars($row['kelas']) . '\', \'' . htmlspecialchars($row['nomor_hp']) . '\', ' . $row['is_aktif'] . ', ' . ($row['kategori_diskon_id'] ?? 'null') . ')">';
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
    $kategori_diskon_id = !empty($_POST['kategori_diskon_id']) ? (int)$_POST['kategori_diskon_id'] : null;
    
    // Debug: Log processed data
    error_log("updateSantri - Processed data: id=$id, nama='$nama', kelas='$kelas', nomor_hp='$nomor_hp', is_aktif=$is_aktif, kategori_diskon_id=" . ($kategori_diskon_id ?? 'null'));
    
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
    $stmt = $conn->prepare("UPDATE santri SET nama = ?, kelas = ?, nomor_hp = ?, is_aktif = ?, kategori_diskon_id = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    $stmt->bind_param("sssiii", $nama, $kelas, $nomor_hp, $is_aktif, $kategori_diskon_id, $id);
    
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
            $html .= '<button class="btn btn-warning btn-sm" onclick="editKategori(' . $row['id'] . ', \'' . htmlspecialchars($row['nama']) . '\')">';
            $html .= '<i class="fas fa-edit me-1"></i>Edit</button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteKategori(' . $row['id'] . ', \'' . htmlspecialchars($row['nama']) . '\')">';
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
    error_log("addKategoriDiskon: Full REQUEST data: " . print_r($_REQUEST, true));
    
    if (empty($nama)) {
        error_log("addKategoriDiskon: Validation failed - Nama kategori diskon kosong.");
        echo json_encode(['success' => false, 'message' => 'Nama kategori diskon harus diisi!']);
        return;
    }
    
    // Check if nama already exists (including soft-deleted)
    $stmt = $conn->prepare("SELECT id, is_deleted FROM kategori_diskon WHERE nama = ? LIMIT 1");
    if ($stmt === false) {
        error_log("addKategoriDiskon: Database error during name check prepare: " . $conn->error);
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
                error_log("addKategoriDiskon: Database error during reactivate prepare: " . $conn->error);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
                return;
            }
            $reactivate->bind_param("i", $row['id']);
            if ($reactivate->execute()) {
                error_log("addKategoriDiskon: Kategori diskon diaktifkan kembali. ID: " . $row['id']);
                echo json_encode(['success' => true, 'message' => 'Kategori diskon diaktifkan kembali.']);
            } else {
                error_log("addKategoriDiskon: Gagal mengaktifkan kembali kategori: " . $reactivate->error);
                echo json_encode(['success' => false, 'message' => 'Gagal mengaktifkan kembali kategori: ' . $reactivate->error]);
            }
            $reactivate->close();
            return;
        }
        // Active duplicate
        error_log("addKategoriDiskon: Validation failed - Nama kategori diskon sudah ada: " . $nama);
        echo json_encode(['success' => false, 'message' => 'Nama kategori diskon sudah ada!']);
        return;
    }
    $stmt->close();
    
    // Insert new kategori diskon
    $stmt = $conn->prepare("INSERT INTO kategori_diskon (nama) VALUES (?)");
    if ($stmt === false) {
        error_log("addKategoriDiskon: Database error during insert prepare: " . $conn->error);
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
        error_log("updateKategoriDiskon: Kategori diskon berhasil diperbarui! ID: " . $id);
        echo json_encode(['success' => true, 'message' => 'Kategori diskon berhasil diperbarui!']);
    } else {
        error_log("updateKategoriDiskon: Gagal memperbarui kategori diskon: " . $stmt->error);
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
            $html .= '<button class="btn btn-warning btn-sm" onclick="editAturan(' . $row['id'] . ', ' . $row['jenis_tagihan_id'] . ', ' . $row['kategori_diskon_id'] . ', ' . $row['diskon_persen'] . ', ' . $row['is_aktif'] . ')">';
            $html .= '<i class="fas fa-edit me-1"></i>Edit</button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteAturan(' . $row['id'] . ', \'' . htmlspecialchars($row['jenis_tagihan_nama']) . '\', \'' . htmlspecialchars($row['kategori_diskon_nama']) . '\')">';
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

    error_log("addDiskonRule called with: jenis_tagihan_id=$jenis_tagihan_id, kategori_diskon_id=$kategori_diskon_id, diskon_persen=$diskon_persen, is_aktif=$is_aktif");
    error_log("addDiskonRule: Full POST data: " . print_r($_POST, true));
    
    if ($jenis_tagihan_id <= 0 || $kategori_diskon_id <= 0 || $diskon_persen < 0 || $diskon_persen > 100) {
        error_log("addDiskonRule: Validation failed - invalid data. jenis_tagihan_id=$jenis_tagihan_id, kategori_diskon_id=$kategori_diskon_id, diskon_persen=$diskon_persen");
        echo json_encode(['success' => false, 'message' => 'Data tidak valid! Pastikan semua field diisi dengan benar dan persentase diskon antara 0-100.']);
        return;
    }
    
    // Check if rule already exists
    $stmt = $conn->prepare("SELECT id FROM diskon_rule WHERE jenis_tagihan_id = ? AND kategori_diskon_id = ? AND is_deleted = 0");
    if ($stmt === false) {
        error_log("addDiskonRule: Database error during rule check prepare: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("ii", $jenis_tagihan_id, $kategori_diskon_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        error_log("addDiskonRule: Validation failed - Aturan diskon untuk kombinasi ini sudah ada.");
        echo json_encode(['success' => false, 'message' => 'Aturan diskon untuk kombinasi ini sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Insert new diskon rule
    $stmt = $conn->prepare("INSERT INTO diskon_rule (jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        error_log("addDiskonRule: Database error during insert prepare: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("iidi", $jenis_tagihan_id, $kategori_diskon_id, $diskon_persen, $is_aktif);
    
    if ($stmt->execute()) {
        $inserted_id = $conn->insert_id;
        error_log("addDiskonRule: Aturan diskon berhasil ditambahkan! ID: " . $inserted_id);
        echo json_encode(['success' => true, 'message' => 'Aturan diskon berhasil ditambahkan!', 'id' => $inserted_id]);
    } else {
        error_log("addDiskonRule: Gagal menambahkan aturan diskon: " . $stmt->error);
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
        error_log("updateDiskonRule: Aturan diskon berhasil diperbarui! ID: " . $id);
        echo json_encode(['success' => true, 'message' => 'Aturan diskon berhasil diperbarui!']);
    } else {
        error_log("updateDiskonRule: Gagal memperbarui aturan diskon: " . $stmt->error);
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

// Setting CRUD Functions
function getSetting() {
    global $conn;
    
    $query = "SELECT id, `key`, `value`, `deskripsi` FROM setting ORDER BY `key`";
    $result = $conn->query($query);
    
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $html = '';
    if ($result->num_rows > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead><tr><th width="5%">ID</th><th width="25%">Key</th><th width="30%">Value</th><th width="25%">Deskripsi</th><th width="15%">Aksi</th></tr></thead>';
        $html .= '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td><span class="badge bg-primary">' . $row['id'] . '</span></td>';
            $html .= '<td><code class="setting-key">' . htmlspecialchars($row['key']) . '</code></td>';
            $html .= '<td><div class="setting-value" title="' . htmlspecialchars($row['value']) . '">' . htmlspecialchars($row['value']) . '</div></td>';
            $html .= '<td><small class="setting-description">' . htmlspecialchars($row['deskripsi'] ?? '') . '</small></td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm me-1" onclick="editSetting(' . $row['id'] . ', \'' . htmlspecialchars($row['key']) . '\', \'' . htmlspecialchars($row['value']) . '\', \'' . htmlspecialchars($row['deskripsi'] ?? '') . '\')">';
            $html .= '<i class="fas fa-edit"></i></button>';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteSetting(' . $row['id'] . ', \'' . htmlspecialchars($row['key']) . '\')">';
            $html .= '<i class="fas fa-trash"></i></button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-cogs"></i>';
        $html .= '<h5>Belum ada pengaturan</h5>';
        $html .= '<p>Mulai dengan menambahkan pengaturan pertama</p>';
        $html .= '</div>';
    }
    
    echo json_encode(['success' => true, 'html' => $html]);
}

function addSetting() {
    global $conn;
    
    $key = trim($_POST['key'] ?? '');
    $value = trim($_POST['value'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    
    if (empty($key) || empty($value)) {
        echo json_encode(['success' => false, 'message' => 'Kunci dan Nilai harus diisi!']);
        return;
    }
    
    // Validate key format (lowercase, underscore, alphanumeric)
    if (!preg_match('/^[a-z0-9_]+$/', $key)) {
        echo json_encode(['success' => false, 'message' => 'Kunci harus menggunakan format lowercase, angka, dan underscore saja!']);
        return;
    }
    
    // Check if key already exists
    $stmt = $conn->prepare("SELECT id FROM setting WHERE `key` = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Kunci pengaturan sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Insert new setting
    $stmt = $conn->prepare("INSERT INTO setting (`key`, `value`, `deskripsi`) VALUES (?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("sss", $key, $value, $deskripsi);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Pengaturan berhasil ditambahkan!']);
    } else {
        error_log("Gagal menambahkan pengaturan: " . $stmt->error); // Tambahkan logging
        echo json_encode(['success' => false, 'message' => 'Gagal menambahkan pengaturan: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function editSetting() {
    global $conn;
    
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID pengaturan tidak valid!']);
        return;
    }
    
    $stmt = $conn->prepare("SELECT id, `key`, `value`, `deskripsi` FROM setting WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Pengaturan tidak ditemukan!']);
        $stmt->close();
        return;
    }
    
    $data = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $data]);
    
    $stmt->close();
}

function updateSetting() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    $key = trim($_POST['key'] ?? '');
    $value = trim($_POST['value'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    
    if ($id <= 0 || empty($key) || empty($value)) {
        echo json_encode(['success' => false, 'message' => 'ID, Kunci dan Nilai harus diisi!']);
        return;
    }
    
    // Validate key format
    if (!preg_match('/^[a-z0-9_]+$/', $key)) {
        echo json_encode(['success' => false, 'message' => 'Kunci harus menggunakan format lowercase, angka, dan underscore saja!']);
        return;
    }
    
    // Check if key already exists (excluding current record)
    $stmt = $conn->prepare("SELECT id FROM setting WHERE `key` = ? AND id != ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("si", $key, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Kunci pengaturan sudah ada!']);
        $stmt->close();
        return;
    }
    $stmt->close();
    
    // Update setting
    $stmt = $conn->prepare("UPDATE setting SET `key` = ?, `value` = ?, `deskripsi` = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("sssi", $key, $value, $deskripsi, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Pengaturan berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui pengaturan: ' . $stmt->error]);
    }
    
    $stmt->close();
}

function deleteSetting() {
    global $conn;
    
    $id = (int)($_POST['id'] ?? 0);
    
        if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID pengaturan tidak valid!']);
        return;
    }
    
    // Delete setting
    $stmt = $conn->prepare("DELETE FROM setting WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Pengaturan berhasil dihapus!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Pengaturan tidak ditemukan!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menghapus pengaturan: ' . $stmt->error]);
    }
    
    $stmt->close();
}
?> 