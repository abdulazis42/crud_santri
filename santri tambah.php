<?php
include 'db.php';

if (isset($_POST['simpan'])) {
    $stmt = $conn->prepare("INSERT INTO santri (nama, kelas, nomor_hp, is_aktif, is_deleted) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("sssi", $_POST['nama'], $_POST['kelas'], $_POST['nomor_hp'], $_POST['is_aktif']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Santri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>➕ Tambah Santri</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status Aktif</label>
            <select name="is_aktif" class="form-control">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
