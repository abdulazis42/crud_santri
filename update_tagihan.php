<?php
function updateTagihan() {
    global $conn;

    $id = (int)($_POST['id'] ?? 0);
    $nama_tagihan = trim($_POST['nama_tagihan'] ?? '');
    $jenis_tagihan_id = (int)($_POST['jenis_tagihan_id'] ?? 0);
    $tanggal_tagihan = $_POST['tanggal_tagihan'] ?? '';
    $deadline_tagihan = $_POST['deadline_tagihan'] ?? '';
    $target = trim($_POST['target'] ?? '');

    if ($id <= 0 || empty($nama_tagihan) || $jenis_tagihan_id <= 0 || empty($tanggal_tagihan) || empty($deadline_tagihan) || empty($target)) {
        echo json_encode(['success' => false, 'message' => 'Semua field harus diisi!']);
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
?>