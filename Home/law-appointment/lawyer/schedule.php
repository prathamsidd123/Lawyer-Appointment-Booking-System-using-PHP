<?php
session_start();
require_once("../config/db.php");

/* ---------- LOGIN CHECK ---------- */
if(!isset($_SESSION['user_id']) || $_SESSION['role']!='lawyer'){
    header("Location: ../login.php");
    exit();
}

$lawyer_id = $_SESSION['user_id'];

/* ================================
   ADD NEW AVAILABLE SLOT
================================ */

if(isset($_POST['add'])){

    $day   = $_POST['day'];
    $start = $_POST['start'];
    $end   = $_POST['end'];

    $insert = $conn->prepare("
        INSERT INTO lawyer_schedule
        (lawyer_id, available_day, start_time, end_time)
        VALUES (?,?,?,?)
    ");

    $insert->bind_param("isss",$lawyer_id,$day,$start,$end);
    $insert->execute();
}


/* ================================
   DELETE SLOT
================================ */

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $delete = $conn->prepare("
        DELETE FROM lawyer_schedule
        WHERE id=? AND lawyer_id=?
    ");

    $delete->bind_param("ii",$id,$lawyer_id);
    $delete->execute();

    header("Location: lawyer_schedule.php");
    exit();
}


/* ================================
   FETCH LAWYER AVAILABILITY
================================ */

$schedules = $conn->prepare("
SELECT * FROM lawyer_schedule
WHERE lawyer_id=?
ORDER BY available_day
");

$schedules->bind_param("i",$lawyer_id);
$schedules->execute();
$schedule_result = $schedules->get_result();


/* ================================
   FETCH APPOINTMENTS
================================ */

$stmt = $conn->prepare("
SELECT a.*, u.name AS client_name
FROM appointments a
JOIN users u ON a.user_id=u.id
WHERE a.lawyer_id=?
ORDER BY appointment_date, appointment_time
");

$stmt->bind_param("i",$lawyer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Lawyer Schedule</title>

<style>
body{font-family:Arial;background:#f4f6f9}
.container{
width:85%;
margin:auto;
background:white;
padding:25px;
margin-top:40px;
border-radius:10px
}

table{
width:100%;
border-collapse:collapse;
margin-top:15px
}

th{
background:#1e3c72;
color:white;
padding:10px
}

td{
padding:10px;
border-bottom:1px solid #ddd;
text-align:center
}

.btn{
padding:6px 10px;
background:red;
color:white;
text-decoration:none;
border-radius:5px
}

form input,select{
padding:8px;
margin:5px
}
</style>
</head>

<body>

<div class="container">

<h2>🗓 Manage Availability</h2>

<form method="POST">

<select name="day" required>
<option value="">Select Day</option>
<option>Monday</option>
<option>Tuesday</option>
<option>Wednesday</option>
<option>Thursday</option>
<option>Friday</option>
<option>Saturday</option>
<option>Sunday</option>
</select>

<input type="time" name="start" required>
<input type="time" name="end" required>

<button name="add">Add Slot</button>

</form>

<hr>

<h3>Available Time Slots</h3>

<table>
<tr>
<th>Day</th>
<th>Start</th>
<th>End</th>
<th>Action</th>
</tr>

<?php while($row=$schedule_result->fetch_assoc()): ?>
<tr>
<td><?= $row['available_day']?></td>
<td><?= $row['start_time']?></td>
<td><?= $row['end_time']?></td>
<td>
<a class="btn" href="?delete=<?=$row['id']?>">Delete</a>
</td>
</tr>
<?php endwhile; ?>

</table>

<hr>

<h2>📅 My Appointments</h2>

<table>
<tr>
<th>Client</th>
<th>Date</th>
<th>Time</th>
<th>Case</th>
</tr>

<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= $row['client_name']; ?></td>
<td><?= $row['appointment_date']; ?></td>
<td><?= $row['appointment_time']; ?></td>
<td><?= $row['case_description']; ?></td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>