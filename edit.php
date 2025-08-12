<?php 
include 'db.php'; 
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM santri WHERE id=$id AND is_deleted = 0");
$data = $result->fetch_assoc();

// Jika data tidak ditemukan
if (!$data) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE santri SET nama=?, kelas=?, nomor_hp=?, is_aktif=? WHERE id=?");
    $stmt->bind_param("sssii", $_POST['nama'], $_POST['kelas'], $_POST['nomor_hp'], $_POST['is_aktif'], $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Santri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">✏ Edit Santri</h2>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control" value="<?= $data['kelas'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" value="<?= $data['nomor_hp'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Status Aktif</label>
            <select name="is_aktif" class="form-control">
                <option value="1" <?= $data['is_aktif'] ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= !$data['is_aktif'] ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
