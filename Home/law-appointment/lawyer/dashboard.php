<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lawyer') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate - Lawyer Dashboard</title>
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
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.2) 0%, transparent 50%);
            animation: float 25s ease-in-out infinite;
            z-index: -1;
        }

        .dashboard-container {
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            animation: slideUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .dashboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #1e3c72, #2a5298, #3b82f6);
        }

        @keyframes slideUp {
            from { 
                opacity: 0; 
                transform: translateY(50px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-15px) rotate(0.5deg); }
            66% { transform: translateY(-5px) rotate(-0.5deg); }
        }

        .lawyer-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            box-shadow: 0 15px 35px rgba(30, 60, 114, 0.3);
            position: relative;
            animation: pulse 2s infinite;
        }

        .lawyer-avatar::before {
            content: '\f596';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }

        @keyframes pulse {
            0%, 100% { 
                box-shadow: 0 15px 35px rgba(30, 60, 114, 0.3);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 20px 45px rgba(30, 60, 114, 0.4);
                transform: scale(1.05);
            }
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            letter-spacing: -1px;
        }

        .dashboard-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #1e3c72;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .welcome-message {
            color: #1e3c72;
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .welcome-message i {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }

        .dashboard-desc {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 35px;
            padding: 0 10px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-btn {
            padding: 18px 24px;
            border: none;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .action-btn i {
            font-size: 1.5rem;
        }

        .btn-appointments {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-appointments:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
        }

        .btn-profile {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .btn-profile:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
        }

        .btn-schedule
        {
             background: linear-gradient(135deg, #3bf65aff, #77d81dff);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        .btn-earnings{
                background: linear-gradient(135deg, #f6a53bff, #d8421dff);
                            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        .logout-btn {
            padding: 14px 28px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 10px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 25px 0;
            padding: 20px;
            background: rgba(30, 60, 114, 0.05);
            border-radius: 16px;
            border: 1px solid rgba(30, 60, 114, 0.1);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 30px 25px;
                margin: 10px;
                max-width: 95%;
                border-radius: 20px;
            }
            
            .lawyer-avatar {
                width: 90px;
                height: 90px;
                font-size: 2rem;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- LAWYER AVATAR -->
    <div class="lawyer-avatar"></div>
    
    <!-- LOGO & TITLE -->
    <div class="logo">Sarvaiya Associate</div>
    <h1 class="dashboard-title">Lawyer Dashboard</h1>
    
    <!-- WELCOME -->
    <div class="welcome-message">
        <i class="fas fa-gavel"></i>
        Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Lawyer'); ?>!
    </div>
    
    <!-- DESCRIPTION -->
    <p class="dashboard-desc">
        Manage your appointments, clients, and professional profile efficiently.
    </p>
    
    <!-- QUICK STATS -->
  
    <!-- ACTION BUTTONS -->
    <div class="action-buttons">
        <a href="appointments.php" class="action-btn btn-appointments">
            <i class="fas fa-calendar-check"></i>
            Appointments
        </a>
        
        <a href="profile.php" class="action-btn btn-profile">
            <i class="fas fa-user-cog"></i>
            Profile Settings
        </a>


        <a href="schedule.php" class="action-btn btn-schedule">
            <i class="fas fa-user-cog"></i>
            Schedule 
        </a>

        
    </div>
    
    <!-- LOGOUT -->
    <a href="../login.php?logout=1" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
        <i class="fas fa-sign-out-alt"></i>
        Logout
    </a>
</div>
</body>
</html>