<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/db.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid appointment ID");
}

$id = intval($_GET['id']);
if ($id <= 0) {
    die("Invalid appointment ID");
}

$stmt = $conn->prepare("
SELECT a.*, 
       u.name AS user_name, 
       u.email, 
       u.phone,
       l.name AS lawyer_name,
       lp.specialization, 
       lp.experience
FROM appointments a
LEFT JOIN users u ON a.user_id = u.id
LEFT JOIN users l ON a.lawyer_id = l.id
LEFT JOIN lawyer_profiles lp ON lp.user_id = l.id
WHERE a.id = ?
");

if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("No data found for appointment ID: " . $id);
}

$stmt->close();

function safe_output($text) {
    if ($text === null || $text === '') {
        return 'N/A';
    }
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

$user_name = safe_output($data['user_name'] ?? null);
$email = safe_output($data['email'] ?? null);
$phone = safe_output($data['phone'] ?? null);
$lawyer_name = safe_output($data['lawyer_name'] ?? null);
$specialization = safe_output($data['specialization'] ?? null);
$experience = intval($data['experience'] ?? 0);
$appointment_date = safe_output($data['appointment_date'] ?? null);
$appointment_time = safe_output($data['appointment_time'] ?? null);
$status = ucfirst(safe_output($data['status'] ?? null));
$case_description = safe_output(substr($data['case_description'] ?? 'No description', 0, 500));

$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Case Report #' . $id . '</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #333; background: #f5f5f5; }
        .page { max-width: 800px; margin: 20px auto; padding: 30px; background: white; }
        .header { text-align: center; border-bottom: 3px solid #1a4d99; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { font-size: 28px; color: #1a4d99; margin-bottom: 5px; }
        .header p { font-size: 13px; color: #666; }
        .section { margin-bottom: 25px; }
        .section-title { background: #1a4d99; color: white; padding: 10px 15px; font-size: 12px; font-weight: bold; margin-bottom: 12px; }
        .field { display: grid; grid-template-columns: 140px 1fr; padding: 8px 0; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #1a4d99; }
        .value { padding-left: 15px; }
        .description { background: #f9f9f9; padding: 12px; border-left: 4px solid #1a4d99; margin-top: 10px; font-size: 12px; line-height: 1.5; }
        .footer { border-top: 2px solid #1a4d99; margin-top: 40px; padding-top: 15px; text-align: right; font-size: 10px; color: #999; }
        @media print { body { margin: 0; background: white; } .page { margin: 0; } }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>SARVAIYA ASSOCIATE</h1>
            <p>Law Appointment Case Report</p>
        </div>
        
        <div class="section">
            <div class="section-title">CLIENT INFORMATION</div>
            <div class="field"><div class="label">Name:</div><div class="value">' . $user_name . '</div></div>
            <div class="field"><div class="label">Email:</div><div class="value">' . $email . '</div></div>
            <div class="field"><div class="label">Phone:</div><div class="value">' . $phone . '</div></div>
        </div>
        
        <div class="section">
            <div class="section-title">ATTORNEY INFORMATION</div>
            <div class="field"><div class="label">Name:</div><div class="value">' . $lawyer_name . '</div></div>
            <div class="field"><div class="label">Specialization:</div><div class="value">' . $specialization . '</div></div>
            <div class="field"><div class="label">Experience:</div><div class="value">' . $experience . ' Years</div></div>
        </div>
        
        <div class="section">
            <div class="section-title">APPOINTMENT DETAILS</div>
            <div class="field"><div class="label">Appointment ID:</div><div class="value">' . $id . '</div></div>
            <div class="field"><div class="label">Date:</div><div class="value">' . $appointment_date . '</div></div>
            <div class="field"><div class="label">Time:</div><div class="value">' . $appointment_time . '</div></div>
            <div class="field"><div class="label">Status:</div><div class="value">' . $status . '</div></div>
        </div>
        
        <div class="section">
            <div class="section-title">CASE DESCRIPTION</div>
            <div class="description">' . nl2br($case_description) . '</div>
        </div>
        
        <div class="footer">
            <p>Generated on: ' . date("d-m-Y H:i:s") . '</p>
        </div>
    </div>
    
    <script>
        window.addEventListener("load", function() {
            setTimeout(function() { window.print(); }, 500);
        });
    </script>
</body>
</html>';

header('Content-Type: text/html; charset=UTF-8');
header('Content-Disposition: inline; filename="Case_Report_' . $id . '_' . date("Y-m-d") . '.html"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

echo $html;
exit;
?>