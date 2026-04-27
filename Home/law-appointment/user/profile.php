<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];

    $stmt = $conn->prepare(
        "UPDATE users SET name=?, phone=?, role=? WHERE id=?"
    );

    $stmt->bind_param("sssi", $name, $phone, $role, $user_id);
    $stmt->execute();
    $stmt->close();
}

$user = $conn->query("SELECT * FROM users WHERE id=".$user_id)->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate - My Profile</title>
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

        .container {
            max-width: 550px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            padding: 30px;
            position: relative;
            animation: slideUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.2rem;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
            position: relative;
        }

        .profile-avatar::after {
            content: '\f007';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #1e3c72;
            font-weight: 400;
        }

        .success-message {
            background: linear-gradient(90deg, #10b981, #059669);
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            animation: fadeIn 0.5s ease-out;
        }

        /* PROFILE FORM */
        .profile-form {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 2px solid #f1f5f9;
        }

        .form-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #1e3c72;
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e3c72;
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
            transform: translateY(-1px);
        }

        .form-group input:disabled {
            background: #f1f5f9;
            color: #6b7280;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 15px center;
            background-repeat: no-repeat;
            background-size: 18px;
            padding-right: 50px;
        }

        /* ROLE BADGE */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 8px;
        }

        .role-badge.user { background: linear-gradient(135deg, #10b981, #059669); }
        .role-badge.lawyer { background: linear-gradient(135deg, #1e3c72, #2a5298); }
        .role-badge.admin { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }

        /* UPDATE BUTTON */
        .update-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .update-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(30, 60, 114, 0.4);
        }

        .update-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .update-btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container {
                padding: 25px 20px;
                margin: 10px;
                max-width: 95%;
            }
            
            .profile-avatar {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-15px) rotate(0.5deg); }
            66% { transform: translateY(-5px) rotate(-0.5deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="profile-avatar"></div>
        <div class="logo">Sarvaiya Associate</div>
        <h1 class="page-title">My Profile</h1>
    </div>

    <?php if (isset($_POST['update'])): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            Profile updated successfully!
        </div>
    <?php endif; ?>

    <form method="POST" class="profile-form" id="profileForm">
        <div class="form-grid">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Full Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                <div style="font-size: 0.8rem; color: #6b7280; margin-top: 4px;">Email cannot be changed</div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-phone"></i> Phone Number</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
            </div>
<!-- 
            <div class="form-group">
                <label><i class="fas fa-user-tag"></i> Role</label>
                <select name="role" required>
                    <option value="user" <?php if($user['role']=="user") echo "selected"; ?>>Client</option>
                    <option value="lawyer" <?php if($user['role']=="lawyer") echo "selected"; ?>>Lawyer</option>
                    <option value="admin" <?php if($user['role']=="admin") echo "selected"; ?>>Administrator</option>
                </select>
            </div>
        </div> -->

        <button type="submit" name="update" class="update-btn" id="updateBtn">
            <i class="fas fa-save"></i>
            Update Profile
        </button>

         <br>
    <a href="dashboard.php">← Back</a>
    </form>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function() {
    const btn = document.getElementById('updateBtn');
    btn.classList.add('loading');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
});
</script>
</body>
</html>