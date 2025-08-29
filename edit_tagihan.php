<?php
function editTagihan() {
    global $conn;

    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
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
?>