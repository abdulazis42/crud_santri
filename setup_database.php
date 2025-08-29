<?php
require_once 'db.php';

echo "<h2>🔧 Setup Database Pondok Pesantren</h2>";
echo "<hr>";

// Check if database exists
$db_check = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'pondok_pesantren'");
if ($db_check->num_rows == 0) {
    echo "<div style='color: red;'>❌ Database 'pondok_pesantren' tidak ditemukan!</div>";
    echo "<p>Silakan buat database 'pondok_pesantren' terlebih dahulu di phpMyAdmin.</p>";
    exit;
}

echo "<div style='color: green;'>✅ Database 'pondok_pesantren' ditemukan!</div>";

// Read and execute SQL file
$sql_file = 'pondok_pesantren.sql';
if (!file_exists($sql_file)) {
    echo "<div style='color: red;'>❌ File $sql_file tidak ditemukan!</div>";
    exit;
}

echo "<h3>📋 Menjalankan SQL Migration...</h3>";

$sql_content = file_get_contents($sql_file);
$queries = explode(';', $sql_content);

$success_count = 0;
$error_count = 0;

foreach ($queries as $query) {
    $query = trim($query);
    if (empty($query) || strpos($query, '--') === 0) {
        continue;
    }
    
    if ($conn->query($query)) {
        $success_count++;
        echo "<div style='color: green;'>✅ Query berhasil: " . substr($query, 0, 50) . "...</div>";
    } else {
        $error_count++;
        echo "<div style='color: red;'>❌ Query gagal: " . $conn->error . "</div>";
    }
}

echo "<hr>";
echo "<h3>📊 Hasil Setup Database:</h3>";
echo "<ul>";
echo "<li>✅ Query berhasil: $success_count</li>";
echo "<li>❌ Query gagal: $error_count</li>";
echo "</ul>";

// Check tables
echo "<h3>📋 Tabel yang Tersedia:</h3>";
$tables = ['santri', 'jenis_tagihan', 'kategori_diskon', 'diskon_rule', 'setting'];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
        echo "<div style='color: green;'>✅ Tabel '$table' - $count data</div>";
    } else {
        echo "<div style='color: red;'>❌ Tabel '$table' tidak ditemukan</div>";
    }
}

// Setup tabel setting jika belum ada
echo "<hr>";
echo "<h3>🔧 Setup Tabel Setting:</h3>";

$setting_table_sql = "
CREATE TABLE IF NOT EXISTS `setting` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `key` varchar(100) NOT NULL,
    `value` text NOT NULL,
    `deskripsi` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($conn->query($setting_table_sql)) {
    echo "<div style='color: green;'>✅ Tabel 'setting' berhasil dibuat/diverifikasi</div>";
    
    // Check if table has data
    $result = $conn->query("SELECT COUNT(*) as count FROM setting");
    $count = $result->fetch_assoc()['count'];
    
    if ($count == 0) {
        // Insert default settings
        $default_settings = [
            ['app_name', 'Sistem Pondok Pesantren', 'Nama aplikasi yang ditampilkan di header dan title'],
            ['app_version', '1.0.0', 'Versi aplikasi saat ini'],
            ['max_students', '500', 'Jumlah maksimal santri yang dapat didaftarkan'],
            ['academic_year', '2024/2025', 'Tahun ajaran saat ini'],
            ['school_address', 'Jl. Pesantren No. 123, Kota Santri', 'Alamat lengkap pondok pesantren'],
            ['school_phone', '+62 123 456 789', 'Nomor telepon pondok pesantren'],
            ['school_email', 'info@pondokpesantren.com', 'Email resmi pondok pesantren'],
            ['discount_max_percentage', '50', 'Persentase maksimal diskon yang dapat diberikan'],
            ['payment_due_days', '15', 'Jumlah hari tenggat waktu pembayaran tagihan'],
            ['system_maintenance', 'false', 'Status maintenance sistem (true/false)']
        ];
        
        $insert_count = 0;
        foreach ($default_settings as $setting) {
            $stmt = $conn->prepare("INSERT INTO setting (`key`, `value`, `deskripsi`) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $setting[0], $setting[1], $setting[2]);
            if ($stmt->execute()) {
                $insert_count++;
            }
            $stmt->close();
        }
        
        echo "<div style='color: blue;'>📝 Berhasil menambahkan <strong>$insert_count</strong> pengaturan default</div>";
    } else {
        echo "<div style='color: blue;'>📊 Tabel 'setting' sudah memiliki <strong>$count</strong> data</div>";
    }
    
} else {
    echo "<div style='color: red;'>❌ Gagal membuat tabel 'setting': " . $conn->error . "</div>";
}

echo "<hr>";
echo "<h3>🎯 Fitur Baru yang Tersedia:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px;'>";
echo "<h4>💰 Sistem Diskon</h4>";
echo "<ul>";
echo "<li><strong>Kategori Diskon:</strong> Mengelola kategori diskon (Anak Yatim, Prestasi, dll)</li>";
echo "<li><strong>Aturan Diskon:</strong> Membuat aturan diskon berdasarkan jenis tagihan dan kategori</li>";
echo "<li><strong>Kalkulator Diskon:</strong> Menghitung diskon otomatis untuk santri</li>";
echo "<li><strong>Relasi Database:</strong> Foreign key antara santri, jenis tagihan, dan kategori diskon</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px; margin-top: 15px;'>";
echo "<h4>⚙️ Pengaturan Sistem</h4>";
echo "<ul>";
echo "<li><strong>Konfigurasi Aplikasi:</strong> Nama aplikasi, versi, alamat, kontak</li>";
echo "<li><strong>Pengaturan Bisnis:</strong> Kuota santri, tahun ajaran, mata uang</li>";
echo "<li><strong>Konfigurasi Diskon:</strong> Persentase maksimal, tenggat pembayaran</li>";
echo "<li><strong>Pengaturan Sistem:</strong> Maintenance mode, backup, notifikasi</li>";
echo "</ul>";
echo "</div>";

echo "<hr>";
echo "<h3>🚀 Langkah Selanjutnya:</h3>";
echo "<ol>";
echo "<li>Buka <a href='http://localhost:8000' target='_blank'>http://localhost:8000</a></li>";
echo "<li>Klik tab 'Sistem Diskon' untuk melihat fitur diskon</li>";
echo "<li>Klik 'Pengaturan Sistem' untuk mengelola konfigurasi</li>";
echo "<li>Tambahkan kategori diskon dan aturan diskon</li>";
echo "<li>Test kalkulator diskon</li>";
echo "</ol>";

echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 20px;'>";
echo "<h4>🎉 Selamat! Sistem Diskon telah berhasil diinstal!</h4>";
echo "<p>Sekarang Anda dapat mengelola diskon untuk santri dengan mudah.</p>";
echo "</div>";
?>
