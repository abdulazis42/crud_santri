<?php
function getTagihan() {
    global $conn;

    $query = "SELECT t.*, jt.nama AS jenis_tagihan_nama FROM tagihan t JOIN jenis_tagihan jt ON t.jenis_tagihan_id = jt.id WHERE t.is_deleted = 0 ORDER BY t.tanggal_tagihan DESC";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        return;
    }

    $tagihan = [];
    while ($row = $result->fetch_assoc()) {
        $tagihan[] = $row;
    }

    $html = '';
    if (count($tagihan) > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Nama Tagihan</th>';
        $html .= '<th>Jenis Tagihan</th>';
        $html .= '<th>Tanggal Tagihan</th>';
        $html .= '<th>Deadline Tagihan</th>';
        $html .= '<th>Target</th>';
        $html .= '<th>Aksi</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach ($tagihan as $item) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($item['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['nama_tagihan']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['jenis_tagihan_nama']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['tanggal_tagihan']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['deadline_tagihan']) . '</td>';
            $html .= '<td>' . htmlspecialchars($item['target']) . '</td>';
            $html .= '<td>';
            $html .= '<button class="btn btn-warning btn-sm" onclick="editTagihan(' . $item['id'] . ')"><i class="fas fa-edit me-1"></i>Edit</button> | ';
            $html .= '<button class="btn btn-danger btn-sm" onclick="deleteTagihan(' . $item['id'] . ')"><i class="fas fa-trash me-1"></i>Hapus</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-inbox"></i>';
        $html .= '<h5>Belum ada data tagihan</h5>';
        $html .= '<p>Silakan tambahkan tagihan.</p>';
        $html .= '</div>';
    }

    echo json_encode(['success' => true, 'html' => $html]);
}
?>