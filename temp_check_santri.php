<?php
require_once 'db.php';

$query = "SELECT COUNT(*) AS total_santri FROM santri WHERE is_deleted = 0";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    echo "Total active santri: " . $row['total_santri'] . PHP_EOL;
} else {
    echo "Query failed: " . $conn->error . PHP_EOL;
}

$conn->close();
?>