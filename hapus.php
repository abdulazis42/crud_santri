<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("UPDATE santri SET is_deleted=1 WHERE id=$id");
header("Location: index.php");
exit;
?>
