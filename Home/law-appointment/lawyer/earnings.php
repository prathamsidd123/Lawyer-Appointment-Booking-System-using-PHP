<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
require_once("../config/db.php");

/* ---------- LOGIN CHECK ---------- */
if(!isset($_SESSION['user_id']) || $_SESSION['role']!='lawyer'){
    header("Location: ../login.php");
    exit();
}

$lawyer_id = $_SESSION['user_id'];

/* ---------- TOTAL EARNINGS ---------- */
$total_query = $conn->prepare("
    SELECT SUM(amount) AS total_earnings
    FROM payments
    WHERE lawyer_id=? AND payment_status='Paid'
");

$total_query->bind_param("i",$lawyer_id);
$total_query->execute();
$total_result = $total_query->get_result()->fetch_assoc();

$total_earnings = $total_result['total_earnings'] ?? 0;


/* ---------- PAYMENT HISTORY ---------- */
$payments = $conn->prepare("
    SELECT p.amount, p.payment_date,
           a.appointment_date, a.appointment_time,
           u.name AS client_name
    FROM payments p
    JOIN appointments a ON p.appointment_id=a.id
    JOIN users u ON a.user_id=u.id
    WHERE p.lawyer_id=? AND p.payment_status='Paid'
    ORDER BY p.payment_date DESC
");

$payments->bind_param("i",$lawyer_id);
$payments->execute();
$result = $payments->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Lawyer Earnings</title>

<style>
body{
    font-family:Arial;
    background:#f0f2f5;
}
.container{
    width:85%;
    margin:auto;
    margin-top:40px;
}
.card{
    background:white;
    padding:30px;
    border-radius:10px;
    margin-bottom:20px;
    text-align:center;
}
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}
th{
    background:#1e3c72;
    color:white;
    padding:12px;
}
td{
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:center;
}
</style>

</head>
<body>

<div class="container">

<div class="card">
<h2>Total Earnings</h2>
<h1>₹ <?= number_format($total_earnings,2); ?></h1>
</div>

<h3>Completed Consultations</h3>

<table>
<tr>
<th>Client</th>
<th>Appointment Date</th>
<th>Time</th>
<th>Amount</th>
<th>Payment Date</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['client_name']; ?></td>
<td><?= $row['appointment_date']; ?></td>
<td><?= $row['appointment_time']; ?></td>
<td>₹ <?= $row['amount']; ?></td>
<td><?= $row['payment_date']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>