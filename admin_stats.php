<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// إحصائيات
$total_hotels = $conn->query("SELECT COUNT(*) AS total FROM hotels")->fetch_assoc()['total'];
$total_bookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'user'")->fetch_assoc()['total'];

$occupancy_rate = $total_hotels > 0 ? round(($total_bookings / $total_hotels) * 100, 1) : 0;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إحصائيات الإدارة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f8ff; }
        .navbar-light { background-color: #b2deff !important; }
        .stat-card { background-color: white; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px #ddd; }
    </style>
</head>
<body>

<nav class="navbar navbar-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin.php">لوحة التحكم</a>
        <a href="logout.php" class="btn btn-danger">تسجيل الخروج</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4 text-center">📊 إحصائيات النظام</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <h5>🏨 عدد الفنادق</h5>
                <h2><?php echo $total_hotels; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <h5>📅 عدد الحجوزات</h5>
                <h2><?php echo $total_bookings; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <h5>👤 عدد المستخدمين</h5>
                <h2><?php echo $total_users; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <h5>📈 نسبة الإشغال</h5>
                <h2><?php echo $occupancy_rate; ?>%</h2>
            </div>
        </div>
    </div>
</div>

</body>
</html>
