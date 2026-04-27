<?php
session_start();
include("../config/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Count data
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();
$lawyers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='lawyer'")->fetch_assoc();
$appointments = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Reports</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #0f2027, #2c5364);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255,255,255,0.95);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: #1e293b;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .content {
            padding: 40px;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #6b7280;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            margin-bottom: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-top: 4px solid;
        }
        
        .stat-card:nth-child(1) { border-top-color: #3b82f6; }
        .stat-card:nth-child(2) { border-top-color: #10b981; }
        .stat-card:nth-child(3) { border-top-color: #8b5cf6; }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        .summary {
            background: #f8fafc;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        
        .summary h3 {
            color: #374151;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .total-users {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e2937;
        }
        
        @media (max-width: 768px) {
            body { padding: 10px; }
            .content { padding: 30px 20px; }
            .stats-grid { grid-template-columns: 1fr; }
            .stat-number { font-size: 2rem; }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>System Reports</h1>
        </div>

        <div class="content">
            <a href="dashboard.php" class="back-btn">← Back</a>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?= $users['total'] ?></div>
                    <div class="stat-label">Total Users</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number"><?= $lawyers['total'] ?></div>
                    <div class="stat-label">Total Lawyers</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number"><?= $appointments['total'] ?></div>
                    <div class="stat-label">Total Appointments</div>
                </div>
            </div>

            <div class="summary">
                <h3>System Overview</h3>
                <div class="total-users"><?= number_format($users['total'] + $lawyers['total']) ?> Active Accounts</div>
            </div>
        </div>
    </div>
</body>
</html>