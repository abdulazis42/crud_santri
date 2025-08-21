<?php
include 'db.php';

// Ambil data santri yang tidak dihapus
$result = $conn->query("SELECT * FROM santri WHERE is_deleted = 0 ORDER BY id DESC");

// Proses tambah data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $nomor_hp = $_POST['nomor_hp'];
    $is_aktif = $_POST['is_aktif'];

    $stmt = $conn->prepare("INSERT INTO santri (nama, kelas, nomor_hp, is_aktif, is_deleted) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("sssi", $nama, $kelas, $nomor_hp, $is_aktif);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

// Proses hapus (soft delete)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("UPDATE santri SET is_deleted = 1 WHERE id = $id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Santri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <!-- Form Tambah Santri -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fs-4 fw-bold">
            ➕ Tambah Santri
        </div>
        <div class="card-body">
            <form method="POST" action="tambah.php">
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
                <button type="submit" class="btn btn-success">Tambah</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Santri -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white fs-4 fw-bold">
            📋 Daftar Santri
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Nomor HP</th>
                        <th>Status Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include 'db.php';
                $result = $conn->query("SELECT * FROM santri WHERE is_deleted=0");
                $no = 1;
                while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['kelas']) ?></td>
                        <td><?= htmlspecialchars($row['nomor_hp']) ?></td>
                        <td><?= $row['is_aktif'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">🗑 Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
