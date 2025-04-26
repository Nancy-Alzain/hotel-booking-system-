<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// حذف فندق إذا ضغط المسؤول على حذف
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM hotels WHERE id = $id";
    $conn->query($delete);
    header("Location: admin_hotels.php");
    exit();
}

$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الفنادق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-light {
            background-color: #b2deff !important;
        }
        img.hotel-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
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
    <h2 class="mb-4">📋 قائمة الفنادق</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>الصورة</th>
                <th>الاسم</th>
                <th>الموقع</th>
                <th>التقييم</th>
                <th>الوصف</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="images/<?php echo $row['image']; ?>" class="hotel-img" alt="فندق"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['rating']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <!-- لاحقًا نضيف زر تعديل -->
                        <a href="admin_hotels.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟');">🗑 حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
