<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id']) || !isset($_GET['hotel_id'])) {
    header("Location: home.php");
    exit();
}
$hotel_id = $_GET['hotel_id'];
$check_in = $_GET['in'];
$check_out = $_GET['out'];

$sql = "SELECT * FROM hotels WHERE id = $hotel_id";
$result = $conn->query($sql);
$hotel = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد الحجز</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f2ff;}
        .card {
            background-color: #ffffffcc;}
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2>✅ تم الحجز بنجاح!</h2>
        <p class="lead">شكراً لاستخدامك نظام حجوزاتي 💙</p>
    </div>

    <div class="card mx-auto p-4 shadow-sm" style="max-width: 600px;">
        <h4 class="mb-3">تفاصيل الحجز</h4>
        <p><strong>الفندق:</strong> <?php echo $hotel['name']; ?></p>
        <p><strong>الموقع:</strong> <?php echo $hotel['location']; ?></p>
        <p><strong>تاريخ الوصول:</strong> <?php echo $check_in; ?></p>
        <p><strong>تاريخ المغادرة:</strong> <?php echo $check_out; ?></p>
        <p><strong>السعر لليلة:</strong> <?php echo $hotel['price']; ?> ريال</p>

        <a href="payment_success.php" class="btn btn-success mt-3">💳 إتمام الدفع</a>


        <a href="mybookings.php" class="btn btn-primary mt-3">📅 الذهاب إلى حجوزاتي</a>
    </div>
</div>

</body>
</html>
