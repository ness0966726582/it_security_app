<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virus Report Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
        }
        #detailsModal .modal-content {
            width: 210mm; /* A4 寬度 */
            height: 297mm; /* A4 高度 */
            max-width: 100%;
            max-height: 100%;
            box-sizing: border-box;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        .modal p {
            font-size: 16px;
            margin: 10px 0;
        }
		
        .signature {
            display: flex;
            justify-content: space-between;
        }

        .signature div {
            width: 30%;
            text-align: center;
            border-top: 1px solid black;
            padding-top: 5px;
        }
    </style>
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function openEditModal(id, user_id, scanby_id, quarantine_y_n, clear_y_n, backup_y_n, remark, status) {
            document.getElementById("edit-id").value = id;
            document.getElementById("edit-user_id").value = user_id;
            document.getElementById("edit-scanby_id").value = scanby_id;
            document.getElementById("edit-quarantine_y_n").value = quarantine_y_n;
            document.getElementById("edit-clear_y_n").value = clear_y_n;
            document.getElementById("edit-backup_y_n").value = backup_y_n;
            document.getElementById("edit-remark").value = remark;
            document.getElementById("edit-status").value = status;
            openModal('editModal');
        }

        function openDeleteModal(id) {
            document.getElementById("delete-id").value = id;
            openModal('deleteModal');
        }

        function openDetailsModal(id, user_id, scanby_id, status) {
            document.getElementById("details-id").textContent = id;
            document.getElementById("details-user_id").textContent = user_id;
            document.getElementById("details-scanby_id").textContent = scanby_id;
            document.getElementById("details-status").textContent = status;

            document.getElementById("details-scanby_signature").textContent = scanby_id;
            document.getElementById("details-user_signature").textContent = user_id;

            openModal('detailsModal');
        }
    </script>
</head>
<body>
    <h1>Virus Report Management</h1>
    <button class="action-btn" onclick="openModal('addModal')">Add New Event</button>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Add New Report</h2>
            <form action="upload.php" method="POST">
                <input type="text" name="user_id" placeholder="User ID" required>
                <input type="text" name="scanby_id" placeholder="Scan By" required>
                <input type="text" name="quarantine_y_n" placeholder="Quarantine (Y/N)" required>
                <input type="text" name="clear_y_n" placeholder="Clear (Y/N)" required>
                <input type="text" name="backup_y_n" placeholder="Backup (Y/N)" required>
                <textarea name="remark" placeholder="Remark"></textarea>
                <input type="text" name="status" placeholder="Status" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Report</h2>
            <form action="update.php" method="POST">
                <input type="hidden" id="edit-id" name="id">
                <input type="text" id="edit-user_id" name="user_id" placeholder="User ID" required>
                <input type="text" id="edit-scanby_id" name="scanby_id" placeholder="Scan By" required>
                <input type="text" id="edit-quarantine_y_n" name="quarantine_y_n" placeholder="Quarantine (Y/N)" required>
                <input type="text" id="edit-clear_y_n" name="clear_y_n" placeholder="Clear (Y/N)" required>
                <input type="text" id="edit-backup_y_n" name="backup_y_n" placeholder="Backup (Y/N)" required>
                <textarea id="edit-remark" name="remark" placeholder="Remark"></textarea>
                <input type="text" id="edit-status" name="status" placeholder="Status" required>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h2>Confirm Delete</h2>
            <form action="delete.php" method="POST">
                <input type="hidden" id="delete-id" name="id">
                <p>Are you sure you want to delete this record?</p>
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>

    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('detailsModal')">&times;</span>
            <h1>1.1 Event ID Form Provided by TW</h1>
			<p class="attention">Pay attention: This document needs to be completed and signed back</p>

			<h2>事件詳情</h2>
            <p><strong>事件ID:</strong> <span id="details-id"></span></p>
            <p><strong>使用者:</strong> <span id="details-user_id"></span></p>
            <p><strong>處理人員:</strong> <span id="details-scanby_id"></span></p>
            <p><strong>事件處理狀態:</strong> <span id="details-status"></span></p>
            
    <table class="table">
        <thead>
            <tr>
                <th>Task</th>
                <th>M</th>
                <th>Event Handling Items</th>
                <th>Completion Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>T1</td>
                <td></td>
                <td>Start of Event ID record form. (Start)<br>1. Perform tasks assigned by supervisor.</td>
                <td>2025 - __ - __ </td>
            </tr>
            <tr>
                <td>T2</td>
                <td>M1</td>
                <td>Isolation and damage control measures.<br>1. Disconnect from the network.<br>2. Remove the hard drive.</td>
                <td>Troubleshooting</td>
            </tr>
            <tr>
                <td>T3</td>
                <td></td>
                <td>Cleanup and recovery process.<br>1. Kaspersky (Safe mode)<br>2. McAfee (Safe mode)</td>
                <td>Troubleshooting</td>
            </tr>
            <tr>
                <td>T4</td>
                <td>M2</td>
                <td>Notify user comes to IT transfer data to NAS Backup.<br>1. Provide backup environment for User or Supervisor.<br>2. Notify User comes to IT transfer data to NAS backup.</td>
                <td>Troubleshooting</td>
            </tr>
            <tr>
                <td>T5</td>
                <td>M3</td>
                <td>Re-install return PC.<br>1. Complete computer settings and go to site.</td>
                <td>Troubleshooting</td>
            </tr>
            <tr>
                <td>T6</td>
                <td></td>
                <td>Close ID Event form.<br>1. Event ID form completed and signed off.</td>
                <td>Supervisor</td>
            </tr>
        </tbody>
    </table>
	<div class="signature">
            <br><div>Troubleshooting by:<br><br><br><span id="details-scanby_signature"></span></div>
            <br><div>Event by:<br><br><br><span id="details-user_signature"></span></div>
            <br><div>Received by:<br><br><br>資安主管: Neil</div>
    </div>
		
    <div class="signature">
		<div>SIGNED</div>
		<div>SIGNED</div>
		<div>SIGNED</div>
    </div>
    
	</div>
            
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Scan By</th>
                <th>Quarantine</th>
                <th>Clear</th>
                <th>Backup</th>
                <th>Remark</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'config.php';
            try {
                $stmt = $pdo->query("SELECT * FROM virus_report");
                $reports = $stmt->fetchAll();
            } catch (PDOException $e) {
                die("❌ 無法讀取資料：" . $e->getMessage());
            }

            foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['id']) ?></td>
                    <td><?= htmlspecialchars($report['user_id']) ?></td>
                    <td><?= htmlspecialchars($report['scanby_id']) ?></td>
                    <td><?= htmlspecialchars($report['quarantine_y_n']) ?></td>
                    <td><?= htmlspecialchars($report['clear_y_n']) ?></td>
                    <td><?= htmlspecialchars($report['backup_y_n']) ?></td>
                    <td><?= htmlspecialchars($report['remark']) ?></td>
                    <td><?= htmlspecialchars($report['status']) ?></td>
                    <td>
                        <button class="action-btn" onclick="openEditModal(
                            '<?= htmlspecialchars($report['id']) ?>',
                            '<?= htmlspecialchars($report['user_id']) ?>',
                            '<?= htmlspecialchars($report['scanby_id']) ?>',
                            '<?= htmlspecialchars($report['quarantine_y_n']) ?>',
                            '<?= htmlspecialchars($report['clear_y_n']) ?>',
                            '<?= htmlspecialchars($report['backup_y_n']) ?>',
                            '<?= htmlspecialchars($report['remark']) ?>',
                            '<?= htmlspecialchars($report['status']) ?>'
                        )">Edit</button>
                        <button class="action-btn" onclick="openDetailsModal(
                            '<?= htmlspecialchars($report['id']) ?>',
                            '<?= htmlspecialchars($report['user_id']) ?>',
                            '<?= htmlspecialchars($report['scanby_id']) ?>',
                            '<?= htmlspecialchars($report['status']) ?>'
                        )">View Details</button>
                        <button class="action-btn delete-btn" onclick="openDeleteModal(<?= htmlspecialchars($report['id']) ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
