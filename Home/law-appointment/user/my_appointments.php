<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

// Fetch user's appointments
$stmt = $conn->prepare("
    SELECT a.*, u.name AS lawyer_name
    FROM appointments a
    JOIN users u ON a.lawyer_id = u.id
    WHERE a.user_id = ?
    ORDER BY a.appointment_date DESC
");

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$appointments = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate - My Appointments</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 5px;
            font-weight: 400;
        }

        .subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
            font-weight: 300;
        }

        .content {
            padding: 40px 30px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #1e3c72;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .no-appointments {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            margin-top: 20px;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
            margin-top: 20px;
        }

        .appointments-table thead {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
        }

        .appointments-table th {
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .appointments-table td {
            padding: 18px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .appointments-table tr:hover {
            background: #f8fafc;
        }

        .appointments-table tr:last-child td {
            border-bottom: none;
        }

        .status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status.pending { background: #fef3c7; color: #d97706; }
        .status.confirmed { background: #d1fae5; color: #059669; }
        .status.completed { background: #f3f4f6; color: #4b5563; }
        .status.cancelled { background: #fecaca; color: #dc2626; }

        .lawyer-name {
            font-weight: 600;
            color: #1e3c72;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-time {
            font-weight: 500;
            color: #374151;
            font-family: monospace;
        }

        .description {
            color: #6b7280;
            line-height: 1.5;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            .container { margin: 10px; border-radius: 16px; }
            .header, .content { padding: 30px 20px; }
            .appointments-table { font-size: 0.9rem; }
            .appointments-table th,
            .appointments-table td { padding: 14px 12px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">Sarvaiya Associate</div>
        <h1 class="page-title">My Appointments</h1>
        <p class="subtitle">View and manage your scheduled consultations</p>
    </div>

    <div class="content">
        <?php if ($appointments->num_rows > 0): ?>
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Lawyer</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Case</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $appointments->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="lawyer-name">
                                <?= htmlspecialchars($row['lawyer_name']) ?>
                            </div>
                        </td>
                        <td class="date-time"><?= date('M d, Y', strtotime($row['appointment_date'])) ?></td>
                        <td class="date-time"><?= date('g:i A', strtotime($row['appointment_time'])) ?></td>
                        <td><span class="status <?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></span></td>
                        <td class="description"><?= htmlspecialchars($row['case_description']) ?></td>
                        <td>
                            <a href="download_report.php?id=<?= $row['id'] ?>" class="btn">
                                Download PDF
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-appointments empty-state">
                <i class="fas fa-calendar-times" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h3>No Appointments</h3>
                <p>Book your first consultation with our approved lawyers</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>