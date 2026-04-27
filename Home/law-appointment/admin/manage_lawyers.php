<?php
session_start();
include("../config/db.php");

// Admin check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// DELETE LOGIC
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='lawyer'");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }

    header("Location: manage_lawyers.php");
    exit();
}

// FETCH LAWYERS
$result = $conn->query("SELECT * FROM users WHERE role='lawyer'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Lawyers - Sarvaiya Associate</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 30px 40px;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0;
        }

        .lawyer-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .content {
            padding: 40px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #374151;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 800px;
        }

        th {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            padding: 20px 24px;
            text-align: left;
            font-weight: 600;
            color: #065f46;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #bbf7d0;
        }

        td {
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        tr:hover {
            background: #f0fdf4;
        }

        .id-cell {
            font-weight: 600;
            color: #059669;
        }

        .lawyer-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #047857;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .action-cell {
            white-space: nowrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-right: 8px;
        }

        .delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .delete:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }

        .edit {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .edit:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body { padding: 10px; }
            .content { padding: 24px; }
            .header { padding: 24px 28px; }
            .header h1 { font-size: 1.8rem; }
            th, td { padding: 16px 12px; }
            .btn { padding: 8px 14px; font-size: 0.85rem; }
        }

        @media (max-width: 480px) {
            .header-content { flex-direction: column; text-align: center; gap: 10px; }
            .action-cell { text-align: center; }
            .btn { display: block; margin: 4px 0; width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <div class="header-content">
            <i class="fas fa-gavel" style="font-size: 2.5rem;"></i>
            <div>
                <h1>Manage Lawyers</h1>
                <div class="lawyer-count">
                    <i class="fas fa-user-tie"></i> 
                    <?= $result->num_rows ?> Lawyers
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <?php if($result->num_rows == 0): ?>
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <h3>No lawyers found</h3>
                <p style="color: #94a3b8;">No lawyer accounts have been created yet.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="id-cell">#<?= $row['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row['name']) ?></strong>
                                <div class="lawyer-badge">
                                    <i class="fas fa-user-tie"></i> Lawyer
                                </div>
                            </td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td class="action-cell">
                                <a href="?delete=<?= $row['id'] ?>" 
                                   class="btn delete"
                                   onclick="return confirm('⚠️ Delete lawyer <?= htmlspecialchars($row['name']) ?>?')"
                                   title="Delete Lawyer">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                                <a href="edit_user.php?id=<?= $row['id'] ?>" 
                                   class="btn edit"
                                   title="Edit Lawyer">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>