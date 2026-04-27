<?php
session_start();
include("../config/db.php");

// Admin check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid User ID");
}

$id = intval($_GET['id']);

// FETCH USER DATA
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found");
}

$user = $result->fetch_assoc();

$msg = "";

// UPDATE USER
if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];
    $password = trim($_POST['password']);

    // If password entered → hash it
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, role=?, password=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $role, $hashed_password, $id);
    } else {
        // No password change
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $role, $id);
    }

    if ($stmt->execute()) {
        $msg = "User updated successfully!";
        // Refresh data
        $user['name'] = $name;
        $user['email'] = $email;
        $user['phone'] = $phone;
        $user['role'] = $role;
    } else {
        $msg = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; background:#0f2027; color:white; padding:20px;}
        .container { background:white; color:black; padding:30px; border-radius:10px; max-width:500px; margin:auto;}
        input, select { width:100%; padding:10px; margin-bottom:15px;}
        button { padding:10px; background:blue; color:white; border:none;}
        .msg { margin-bottom:15px; color:green;}
    </style>
</head>

<body>
<div class="container">
    <h2>Edit User</h2>

    <?php if ($msg): ?>
        <div class="msg"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

        <label>Role</label>
        <select name="role">
            <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
            <option value="lawyer" <?= $user['role']=='lawyer'?'selected':'' ?>>Lawyer</option>
            <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
        </select>

        <label>New Password (leave blank to keep same)</label>
        <input type="password" name="password">

        <button type="submit" name="update">Update User</button>
    </form>

    <br>
    <a href="manage_users.php">← Back</a>
</div>
</body>
</html>