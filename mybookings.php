<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT bookings.*, hotels.name AS hotel_name, hotels.image, hotels.location 
        FROM bookings 
        JOIN hotels ON bookings.hotel_id = hotels.id 
        WHERE bookings.user_id = $user_id 
        ORDER BY bookings.check_in DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حجوزاتي</title>
    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-light {
            background-color: #b2deff !important;
        }
        .card-title {
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="home.php">حجوزاتي</a>
        <div>
            <a href="logout.php" class="btn btn-outline-danger">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="text-center mb-4">حجوزاتك يا <?php echo $_SESSION['user_name']; ?> 🧳</h2>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-6 mb-4">';
                echo '  <div class="card h-100 shadow-sm">';
                echo '    <img src="images/' . $row['image'] . '" class="card-img-top" alt="صورة الفندق" style="height: 200px; object-fit: cover;">';
                echo '    <div class="card-body">';
                echo '      <h5 class="card-title">' . $row['hotel_name'] . '</h5>';
                echo '      <p class="card-text text-muted">📍 الموقع: ' . $row['location'] . '</p>';
                echo '      <p class="card-text">📅 من <strong>' . $row['check_in'] . '</strong> إلى <strong>' . $row['check_out'] . '</strong></p>';
                echo '      <p class="card-text">📌 الحالة: <span class="badge bg-secondary">' . $row['status'] . '</span></p>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center">ما عندك أي حجوزات حالياً 💤</p>';
        }
        $conn->close();
        ?>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
