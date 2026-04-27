<?php
$conn = new mysqli("localhost", "root", "", "law_appointment");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>