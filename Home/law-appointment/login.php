<?php
session_start();

// DB connection
include("config/db.php");   
$error = "";

// Handle login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role=?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password'] || password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect by role
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] === 'lawyer') {
                header("Location: lawyer/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit();

        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid email or role!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate Login</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            padding: 50px;
            max-width: 450px;
            width: 100%;
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: -1px;
        }

        .tagline {
            color: #666;
            font-size: 0.95rem;
            font-weight: 300;
            margin-bottom: 30px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #1e3c72;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 400;
        }

        .error {
            background: linear-gradient(90deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            border-left: 4px solid #ff3838;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-family: inherit;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border-color: #1e3c72;
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
            transform: translateY(-2px);
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 18px;
            padding-right: 50px;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        /* Security badge */
        .security-badge {
            text-align: center;
            margin-top: 25px;
            padding: 15px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .security-badge i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 40px 30px;
                margin: 10px;
            }
            
            .logo h1 {
                font-size: 2rem;
            }
        }

        /* Loading animation */
        .login-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .login-btn.loading::after {
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

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1><i class="fas fa-balance-scale"></i> Sarvaiya Associate</h1>
            <div class="tagline">Professional Legal Management System</div>
        </div>

        <h2>Secure Login</h2>

        <?php if ($error != ""): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="user">User</option>
                    <option value="lawyer">Lawyer</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <button type="submit" name="login" class="login-btn" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
          <div style="text-align:right; margin-top:8px;">
    <a href="forget_password.php" style="color:#1e3c72; font-size:0.9rem;">
        Forgot Password?
    </a>
</div>

     

    <script>
        // Simple form validation and loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
        });
    </script>
</body>
</html>