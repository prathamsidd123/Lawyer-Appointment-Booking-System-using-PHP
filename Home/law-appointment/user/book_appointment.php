<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

// Fetch approved lawyers
$lawyers = $conn->query("SELECT u.id, u.name, lp.specialization 
                         FROM users u 
                         JOIN lawyer_profiles lp ON u.id = lp.user_id 
                         WHERE u.role='lawyer' AND lp.approval_status='Approved'");

$message = "";

if (isset($_POST['book'])) {

    $lawyer_id = intval($_POST['lawyer_id']);
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $case_description = trim($_POST['case_description']);

    if (!empty($lawyer_id) && !empty($appointment_date) && !empty($appointment_time) && !empty($case_description)) {

        $stmt = $conn->prepare("INSERT INTO appointments 
            (user_id, lawyer_id, appointment_date, appointment_time, case_description) 
            VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("iisss", $_SESSION['user_id'], $lawyer_id, $appointment_date, $appointment_time, $case_description);

        if ($stmt->execute()) {
             $appointment_id = $stmt->insert_id;

        // ✅ Get lawyer consultation fee
        $fee_query = $conn->prepare(
            "SELECT consultation_fee FROM lawyer_profiles WHERE user_id=?"
        );

        $fee_query->bind_param("i", $lawyer_id);
        $fee_query->execute();
        $fee_result = $fee_query->get_result()->fetch_assoc();

        $amount = $fee_result['consultation_fee'];

        // ✅ Insert payment record
        $pay_stmt = $conn->prepare(
            "INSERT INTO payments
            (appointment_id, lawyer_id, user_id, amount, payment_status)
            VALUES (?, ?, ?, ?, 'Paid')"
        );

        $pay_stmt->bind_param(
            "iiid",
            $appointment_id,
            $lawyer_id,
            $_SESSION['user_id'],
            $amount
        );

        $pay_stmt->execute();

            $message = "<p style='color:green;'>Appointment booked successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        $message = "<p style='color:red;'>All fields are required!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate - Book Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
        overflow-x: hidden;
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

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-15px) rotate(0.5deg); }
        66% { transform: translateY(-5px) rotate(-0.5deg); }
    }

    .container {
        /* SMALLER BOX - Reduced from 800px to 550px max-width */
        max-width: 550px;
        margin: 0 auto;
        /* REDUCED PADDING from 50px to 30px */
        padding: 30px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.2);
        position: relative;
        animation: slideUp 0.8s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .header {
        text-align: center;
        /* REDUCED MARGIN from 40px to 25px */
        margin-bottom: 25px;
    }

    .logo {
        font-family: 'Playfair Display', serif;
        /* SLIGHTLY SMALLER LOGO */
        font-size: 2.2rem;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        /* SMALLER TITLE */
        font-size: 1.8rem;
        color: #1e3c72;
        margin-bottom: 3px;
        font-weight: 400;
    }

    .subtitle {
        color: #666;
        /* SMALLER SUBTITLE */
        font-size: 0.95rem;
        font-weight: 300;
    }

    .message {
        /* COMPACT MESSAGE */
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease-out;
        font-size: 0.9rem;
    }

    .message.success {
        background: linear-gradient(90deg, #10b981, #059669);
        color: white;
        border-left: 4px solid #34d399;
    }

    .message.error {
        background: linear-gradient(90deg, #ef4444, #dc2626);
        color: white;
        border-left: 4px solid #f87171;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* COMPACT GRID - Single column by default */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
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
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* COMPACTER INPUTS */
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        /* REDUCED PADDING from 18px to 14px */
        padding: 14px 0px;
        border: 2px solid #e1e8ed;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
        font-family: inherit;
        resize: vertical;
    }

    .form-group textarea {
        /* SMALLER TEXTAREA */
        min-height: 80px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1e3c72;
        background: white;
        box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
        transform: translateY(-1px);
    }

    .form-group select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 15px center;
        background-repeat: no-repeat;
        background-size: 18px;
        padding-right: 40px;
    }

    /* COMPACT BUTTON */
    .book-btn {
        width: 100%;
        /* REDUCED PADDING from 20px to 16px */
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
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        grid-column: 1;
    }

    .book-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(30, 60, 114, 0.4);
    }

    /* REMOVED FEATURES SECTION for smaller footprint */
    .features {
        display: none;
    }

    /* RESPONSIVE - Even smaller on mobile */
    @media (max-width: 768px) {
        .container {
            /* EVEN SMALLER MOBILE */
            padding: 25px 20px;
            margin: 10px;
            border-radius: 18px;
            max-width: 95%;
        }
        
        .logo {
            font-size: 2rem;
        }
        
        .page-title {
            font-size: 1.6rem;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 16px;
        }
    }

    /* LOADING STATES */
    .book-btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .book-btn.loading::after {
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

<div class="container">
    <div class="header">
        <div class="logo">
            <i class="fas fa-balance-scale"></i> Sarvaiya Associate
        </div>
        <h1 class="page-title">Book Appointment</h1>
        <p class="subtitle">Schedule a consultation with our approved lawyers</p>
    </div>

    <?php echo $message; ?>

    <form method="POST" id="appointmentForm">
        <div class="form-grid">
            <div class="form-group">
                <label><i class="fas fa-user-tie"></i> Choose Lawyer</label>
                <select name="lawyer_id" required>
                    <option value="">-- Select Approved Lawyer --</option>
                    <?php if ($lawyers->num_rows > 0): ?>
                        <?php while($row = $lawyers->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['name']); ?> 
                                <span style="color:#666;">• <?php echo htmlspecialchars($row['specialization']); ?></span>
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">No approved lawyers available</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fas fa-calendar-alt"></i> Appointment Date</label>
                <input type="date" name="appointment_date" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-clock"></i> Appointment Time</label>
                <input type="time" name="appointment_time" required>
            </div>

            <div class="form-group full-width">
                <label><i class="fas fa-file-alt"></i> Case Description</label>
                <textarea name="case_description" placeholder="Please provide details about your legal matter..." required></textarea>
            </div>
        </div>

        <button type="submit" name="book" class="book-btn" id="bookBtn">
            <i class="fas fa-calendar-check"></i>
            Book Appointment Now
        </button>
          <a href="my_appointments.php">← Back</a>
    </form>

</div>

<script>
document.getElementById('appointmentForm').addEventListener('submit', function() {
    const btn = document.getElementById('bookBtn');
    btn.classList.add('loading');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Booking Appointment...';
});
</script>

</body>
</html>