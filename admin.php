<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المسؤول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        .navbar-light {
            background-color: #b2deff !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">لوحة التحكم</a>
        <a href="logout.php" class="btn btn-danger">تسجيل الخروج</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">مرحباً بك يا مسؤول 👨‍💼</h2>

    <div class="row g-3">
    <div class="col-md-4">
        <a href="admin_hotels.php" class="btn btn-outline-primary w-100">📋 إدارة الفنادق</a>
    </div>
    <div class="col-md-4">
        <a href="admin_bookings.php" class="btn btn-outline-secondary w-100">🧾 إدارة الحجوزات</a>
    </div>
    <div class="col-md-4">
        <a href="admin_stats.php" class="btn btn-outline-info w-100">📊 إحصائيات النظام</a>
    </div>
</div>

</div>

</body>
</html>
