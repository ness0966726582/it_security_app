<?php
require 'config.php'; // 連接資料庫

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $scanby_id = $_POST['scanby_id'];
    $quarantine = $_POST['quarantine_y_n'];
    $clear = $_POST['clear_y_n'];
    $backup = $_POST['backup_y_n'];
    $remark = $_POST['remark'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("INSERT INTO virus_report (user_id, scanby_id, quarantine_y_n, clear_y_n, backup_y_n, remark, status, update_time) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $scanby_id, $quarantine, $clear, $backup, $remark, $status]);

        header("Location: index.php?msg=Record added successfully");
        exit();
    } catch (PDOException $e) {
        die("❌ 無法新增資料：" . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Virus Report</title>
</head>
<body>
    <h1>Add Virus Report</h1>
    <form method="POST">
        <label>User ID: <input type="text" name="user_id"></label><br>
        <label>Scan By: <input type="text" name="scanby_id"></label><br>
        <label>Quarantine: <input type="text" name="quarantine_y_n"></label><br>
        <label>Clear: <input type="text" name="clear_y_n"></label><br>
        <label>Backup: <input type="text" name="backup_y_n"></label><br>
        <label>Remark: <textarea name="remark"></textarea></label><br>
        <label>Status: <input type="text" name="status"></label><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
