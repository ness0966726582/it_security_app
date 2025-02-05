<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM virus_report WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php?msg=Record deleted successfully");
        exit();
    } catch (PDOException $e) {
        die("❌ 無法刪除資料：" . $e->getMessage());
    }
} else {
    die("❌ 無效的請求");
}
?>
