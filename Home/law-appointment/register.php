<?php
session_start();
require_once("config/db.php"); 

$message = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Email already exists!";
    } else {

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $role);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate - Create Account</title>
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

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .container {
            /* COMPACT SIZE */
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            border-radius: 24px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.3);
            padding: 40px 35px;
            position: relative;
            z-index: 2;
            animation: slideUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes slideUp {
            from { 
                opacity: 0; 
                transform: translateY(40px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            letter-spacing: -1px;
        }

        .register-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #1e3c72;
            margin-bottom: 5px;
            font-weight: 400;
        }

        .subtitle {
            color: #666;
            font-size: 1rem;
            font-weight: 300;
        }

        /* MESSAGE */
        .msg {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 500;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: msgSlide 0.5s ease-out;
        }

        .msg.success {
            background: linear-gradient(90deg, #10b981, #059669);
            color: white;
            border-left: 5px solid #34d399;
        }

        .msg.error {
            background: linear-gradient(90deg, #ef4444, #dc2626);
            color: white;
            border-left: 5px solid #f87171;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes msgSlide {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* FORM */
        .register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e1e8ed;
            border-radius: 14px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            background: #f8fafc;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #1e3c72;
            background: white;
            box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.1);
            transform: translateY(-2px);
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 16px center;
            background-repeat: no-repeat;
            background-size: 20px;
            padding-right: 55px;
        }

        /* REGISTER BUTTON */
        .register-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .register-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(30, 60, 114, 0.4);
        }

        .register-btn:active {
            transform: translateY(-2px);
        }

        .register-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .register-btn.loading::after {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            top: 50%;
            left: 50%;
            margin-left: -11px;
            margin-top: -11px;
            border: 3px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* LOGIN LINK */
        .login-link {
            text-align: center;
            margin-top: 25px;
            padding: 15px;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 12px;
            border: 2px solid #e1e8ed;
        }

        .login-link a {
            color: #1e3c72;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #2a5298;
            transform: translateX(5px);
        }

        /* RESPONSIVE */
        @media (max-width: 480px) {
            .container {
                padding: 30px 25px;
                margin: 10px;
                border-radius: 20px;
            }
            
            .logo {
                font-size: 2.1rem;
            }
            
            .register-title {
                font-size: 1.7rem;
            }
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
        <div class="logo">
            <i class="fas fa-balance-scale"></i> Sarvaiya Associate
        </div>
        <h1 class="register-title">Create Account</h1>
        <p class="subtitle">Join our legal management platform</p>
    </div>

    <?php if ($message != ""): ?>
        <div class="msg <?php echo strpos($message, 'successful') !== false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="register-form" id="registerForm">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Full Name</label>
            <input type="text" name="name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" name="email" placeholder="your@email.com" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" placeholder="Create a strong password" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-phone"></i> Phone Number</label>
            <input type="tel" name="phone" placeholder="+1 (555) 123-4567" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-user-tag"></i> Account Type</label>
            <select name="role" required>
                <option value="" disabled selected>Select account type</option>
                <option value="user">Client</option>
                <option value="lawyer">Lawyer</option>
                <option value="admin">Administrator</option>
            </select>
        </div>

        <button type="submit" name="register" class="register-btn" id="registerBtn">
            <i class="fas fa-user-plus"></i>
            Create Account
        </button>
    </form>

    <div class="login-link">
        <a href="login.php">
            <i class="fas fa-sign-in-alt"></i>
            Already have an account? Login
        </a>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function() {
    const btn = document.getElementById('registerBtn');
    btn.classList.add('loading');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
});
</script>
</body>
</html>