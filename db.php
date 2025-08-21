<?php
// db.php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';      // ganti sesuai environment
$DB_NAME = 'pondok_pesantren';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_errno) {
    die("Koneksi gagal: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

// development: set charset
$conn->set_charset('utf8mb4');
