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
$tables = ['santri', 'jenis_tagihan', 'kategori_diskon', 'diskon_rule'];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        $count = $conn->query("SELECT COUNT(*) as count FROM $table")->fetch_assoc()['count'];
        echo "<div style='color: green;'>✅ Tabel '$table' - $count data</div>";
    } else {
        echo "<div style='color: red;'>❌ Tabel '$table' tidak ditemukan</div>";
    }
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

echo "<hr>";
echo "<h3>🚀 Langkah Selanjutnya:</h3>";
echo "<ol>";
echo "<li>Buka <a href='http://localhost:8000' target='_blank'>http://localhost:8000</a></li>";
echo "<li>Klik tab 'Sistem Diskon' untuk melihat fitur baru</li>";
echo "<li>Tambahkan kategori diskon dan aturan diskon</li>";
echo "<li>Test kalkulator diskon</li>";
echo "</ol>";

echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 20px;'>";
echo "<h4>🎉 Selamat! Sistem Diskon telah berhasil diinstal!</h4>";
echo "<p>Sekarang Anda dapat mengelola diskon untuk santri dengan mudah.</p>";
echo "</div>";
?>
