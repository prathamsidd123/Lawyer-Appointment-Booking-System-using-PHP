<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// SAFE QUERY
$sql = "
    SELECT u.id, u.name, lp.specialization, lp.experience, lp.qualification, lp.address
    FROM users u
    LEFT JOIN lawyer_profiles lp ON u.id = lp.user_id
    WHERE u.role='lawyer' AND lp.approval_status='Approved'
";

// SEARCH FILTER
if ($search != "") {
    $searchEscaped = $conn->real_escape_string($search);
    $sql .= " AND (u.name LIKE '%$searchEscaped%' OR lp.specialization LIKE '%$searchEscaped%')";
}

$lawyers = $conn->query($sql);

// ERROR CHECK
if (!$lawyers) {
    die("Query Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarvaiya Associate - Find Lawyers</title>

    <!-- YOUR CSS (UNCHANGED) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* KEEPING YOUR CSS EXACTLY SAME */
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family:'Roboto',sans-serif;
            background:linear-gradient(135deg,#0f2027 0%,#203a43 50%,#2c5364 100%);
            min-height:100vh;
            padding:20px;
        }

        .container {
            max-width:550px;
            margin:0 auto;
            background:rgba(255,255,255,0.95);
            border-radius:20px;
            padding:30px;
        }

        .search-form { margin-bottom:20px; }

        .search-input-group { display:flex; gap:10px; }

        .search-input {
            flex:1;
            padding:12px;
            border-radius:10px;
            border:1px solid #ccc;
        }

        .search-btn {
            padding:12px 20px;
            background:#1e3c72;
            color:#fff;
            border:none;
            border-radius:10px;
            cursor:pointer;
        }

        .lawyer-card {
            background:#fff;
            padding:20px;
            border-radius:12px;
            margin-bottom:15px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .lawyer-avatar {
            width:40px;
            height:40px;
            background:#1e3c72;
            color:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .specialization {
            background:#10b981;
            color:white;
            padding:3px 10px;
            border-radius:10px;
            font-size:12px;
        }
    </style>
</head>

<body>

<div class="container">

    <form method="GET" class="search-form">
        <div class="search-input-group">
            <input type="text" name="search" class="search-input"
                   placeholder="Search lawyer..."
                   value="<?php echo htmlspecialchars($search); ?>">

            <button type="submit" class="search-btn">Search</button>
        </div>
    </form>

    <?php if ($lawyers->num_rows > 0): ?>

        <p><strong><?php echo $lawyers->num_rows; ?> lawyers found</strong></p>

        <?php while($row = $lawyers->fetch_assoc()): ?>
            <div class="lawyer-card">

                <div class="lawyer-avatar">
                    <?php echo strtoupper(substr($row['name'],0,1)); ?>
                </div>

                <h3><?php echo htmlspecialchars($row['name']); ?></h3>

                <span class="specialization">
                    <?php echo htmlspecialchars($row['specialization'] ?? 'N/A'); ?>
                </span>

                <p><b>Experience:</b> <?php echo $row['experience'] ?? '0'; ?> years</p>
                <p><b>Qualification:</b> <?php echo htmlspecialchars($row['qualification'] ?? 'N/A'); ?></p>
                <p><b>Address:</b> <?php echo htmlspecialchars($row['address'] ?? 'N/A'); ?></p>

            </div>
        <?php endwhile; ?>

    <?php else: ?>
        <p>No lawyers found</p>
    <?php endif; ?>

</div>

</body>
</html>