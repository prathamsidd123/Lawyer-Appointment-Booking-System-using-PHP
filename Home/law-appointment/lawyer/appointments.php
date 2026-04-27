<?php
session_start();
require_once("../config/db.php");

/* ---------------- SECURITY CHECK ---------------- */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lawyer') {
    header("Location: ../login.php");
    exit();
}

$lawyer_id = $_SESSION['user_id'];

/* ---------------- UPDATE STATUS ---------------- */
if (isset($_GET['action']) && isset($_GET['id'])) {

    $appointment_id = intval($_GET['id']);
    $action = $_GET['action'];

    if (in_array($action, ['Approved','Rejected','Completed'])) {

        $update = $conn->prepare("
            UPDATE appointments 
            SET status=? 
            WHERE id=? AND lawyer_id=?
        ");

        $update->bind_param("sii", $action, $appointment_id, $lawyer_id);
        $update->execute();
    }

    header("Location: appointments.php");
    exit();
}


/* ---------------- FETCH APPOINTMENTS ---------------- */
$stmt = $conn->prepare("
    SELECT a.*, u.name AS client_name
    FROM appointments a
    JOIN users u ON a.user_id = u.id
    WHERE a.lawyer_id = ?
    ORDER BY a.appointment_date DESC
");

$stmt->bind_param("i", $lawyer_id);
$stmt->execute();
$appointments = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Lawyer Appointments</title>

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
}

.container{
    width:90%;
    margin:auto;
    background:white;
    padding:25px;
    margin-top:40px;
    border-radius:10px;
}

h2{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#1e3c72;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

.status{
    padding:5px 10px;
    border-radius:6px;
    color:white;
}

.Pending{background:orange;}
.Approved{background:green;}
.Rejected{background:red;}
.Completed{background:gray;}

.btn{
    padding:6px 10px;
    text-decoration:none;
    color:white;
    border-radius:5px;
    margin-right:5px;
}

.approve{background:green;}
.reject{background:red;}
.complete{background:#555;}
</style>

</head>
<body>

<div class="container">

<h2>📅 Lawyer Appointment Requests</h2>

<?php if($appointments->num_rows > 0): ?>

<table>

<tr>
<th>Client</th>
<th>Date</th>
<th>Time</th>
<th>Case</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = $appointments->fetch_assoc()): ?>

<tr>

<td><?= htmlspecialchars($row['client_name']) ?></td>

<td><?= date('M d, Y', strtotime($row['appointment_date'])) ?></td>

<td><?= date('g:i A', strtotime($row['appointment_time'])) ?></td>

<td><?= htmlspecialchars($row['case_description']) ?></td>

<td>
<span class="status <?= $row['status'] ?>">
<?= $row['status'] ?>
</span>
</td>

<td>

<?php if($row['status']=='Pending'): ?>

<a class="btn approve"
href="?action=Approved&id=<?= $row['id'] ?>">
Approve
</a>

<a class="btn reject"
href="?action=Rejected&id=<?= $row['id'] ?>">
Reject
</a>

<?php elseif($row['status']=='Approved'): ?>

<a class="btn complete"
href="?action=Completed&id=<?= $row['id'] ?>">
Complete
</a>

<?php else: ?>
—
<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

<?php else: ?>

<h3 style="text-align:center;">No Appointments Found</h3>

<?php endif; ?>

</div>

</body>
</html>