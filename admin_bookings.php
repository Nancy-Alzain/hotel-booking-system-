<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT bookings.*, 
               hotels.name AS hotel_name, 
               users.name AS user_name 
        FROM bookings 
        JOIN hotels ON bookings.hotel_id = hotels.id 
        JOIN users ON bookings.user_id = users.id 
        ORDER BY bookings.check_in DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الحجوزات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-light {
            background-color: #b2deff !important;
        }
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
    <h2 class="mb-4">🧾 قائمة الحجوزات</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>اسم المستخدم</th>
                <th>الفندق</th>
                <th>من</th>
                <th>إلى</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['hotel_name']; ?></td>
                    <td><?php echo $row['check_in']; ?></td>
                    <td><?php echo $row['check_out']; ?></td>
                    <td><span class="badge bg-secondary"><?php echo $row['status']; ?></span></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
