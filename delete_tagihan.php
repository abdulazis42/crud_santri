<?php
function deleteTagihan() {
    global $conn;

    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
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
?>