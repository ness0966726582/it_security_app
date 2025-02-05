<?php
require 'config.php'; // 連接資料庫

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $user_id = $_POST['user_id'];
    $scanby_id = $_POST['scanby_id'];
    $quarantine = $_POST['quarantine_y_n'];
    $clear = $_POST['clear_y_n'];
    $backup = $_POST['backup_y_n'];
    $remark = $_POST['remark'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE virus_report SET user_id=?, scanby_id=?, quarantine_y_n=?, clear_y_n=?, backup_y_n=?, remark=?, status=?, update_time=NOW() WHERE id=?");
        $stmt->execute([$user_id, $scanby_id, $quarantine, $clear, $backup, $remark, $status, $id]);

        header("Location: index.php?msg=Record updated successfully");
        exit();
    } catch (PDOException $e) {
        die("❌ 無法更新資料：" . $e->getMessage());
    }
}

// 讀取現有資料
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM virus_report WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch();
    if (!$record) {
        die("❌ 找不到該筆資料");
    }
} else {
    die("❌ 無效的 ID");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Virus Report</title>
</head>
<body>
    <h1>Update Virus Report</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($record['id']) ?>">
        <label>User ID: <input type="text" name="user_id" value="
