<?php
// db.php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'password';      // ganti sesuai environment
$DB_NAME = 'pondok_pesantren';
$DB_PORT = 3336;    // Port database

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

if ($conn->connect_errno) {
    die("Koneksi gagal: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

// development: set charset
$conn->set_charset('utf8mb4');
