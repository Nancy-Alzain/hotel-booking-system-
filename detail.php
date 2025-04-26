<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "لم يتم تحديد الفندق.";
    exit();
}

$hotel_id = $_GET['id'];

// جلب بيانات الفندق
$sql = "SELECT * FROM hotels WHERE id = $hotel_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "الفندق غير موجود.";
    exit();
}

// حجز غرفة وتحويل لتأكيد الحجز
if (isset($_POST['book'])) {
    $user_id = $_SESSION['user_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $insert = "INSERT INTO bookings (user_id, hotel_id, check_in, check_out)
               VALUES ('$user_id', '$hotel_id', '$check_in', '$check_out')";

    if ($conn->query($insert) === TRUE) {
        header("Location: booking_confirmation.php?hotel_id=$hotel_id&in=$check_in&out=$check_out");
        exit();
    } else {
        $errorMessage = "حدث خطأ أثناء الحجز: " . $conn->error;
    }
}

// تقييم الفندق
if (isset($_POST['submit_review'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $insertReview = "INSERT INTO reviews (user_id, hotel_id, rating, comment)
                     VALUES ('$user_id', '$hotel_id', '$rating', '$comment')";
    $conn->query($insertReview);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل الفندق</title>
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
        <a class="navbar-brand fw-bold" href="home.php">حجوزاتي</a>
        <div>
            <a href="mybookings.php" class="btn btn-outline-primary me-2">📅 حجوزاتي</a>
            <a href="logout.php" class="btn btn-outline-danger">تسجيل الخروج</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="card shadow-sm mb-4">
        <img src="images/<?php echo $row['image']; ?>" class="card-img-top" style="height:300px; object-fit:cover;">
        <div class="card-body">
            <h3 class="card-title"><?php echo $row['name']; ?> 🏨</h3>
            <p class="card-text">📍 <strong>الموقع:</strong> <?php echo $row['location']; ?></p>
            <p class="card-text">⭐ <strong>التقييم:</strong> <?php echo $row['rating']; ?></p>
            <p class="card-text text-success">💰 <strong>السعر:</strong> <?php echo $row['price']; ?> ريال</p>
            <p class="card-text"><strong>الوصف:</strong> <?php echo $row['description']; ?></p>
        </div>
    </div>
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger text-center"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <!-- نموذج الحجز -->
    <div class="card p-4 mb-5">
        <h4 class="mb-3">📝 احجز الآن</h4>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">تاريخ الوصول:</label>
                <input type="date" name="check_in" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">تاريخ المغادرة:</label>
                <input type="date" name="check_out" class="form-control" required>
            </div>

            <button type="submit" name="book" class="btn btn-primary">احجز الآن</button>
        </form>
    </div>

    <!-- نموذج التقييم -->
    <hr>
    <h4 class="mt-5">💬 أضف تقييمك</h4>
    <form method="POST" action="">
        <div class="mb-3">
            <label>التقييم (من 1 إلى 5):</label>
            <select name="rating" class="form-select" required>
                <option value="">اختر التقييم</option>
                <option value="5">⭐️⭐️⭐️⭐️⭐️ ممتاز</option>
                <option value="4">⭐️⭐️⭐️⭐️ جيد جداً</option>
                <option value="3">⭐️⭐️⭐️ عادي</option>
                <option value="2">⭐️⭐️ ضعيف</option>
                <option value="1">⭐️ سيء</option>
            </select>
        </div>
        <div class="mb-3">
            <label>تعليقك:</label>
            <textarea name="comment" class="form-control" required></textarea>
        </div>
        <button type="submit" name="submit_review" class="btn btn-success">إرسال التقييم</button>
    </form>
    <!-- عرض التقييمات -->
    <hr>
    <h4 class="mt-5">⭐️ التقييمات</h4>

    <?php
    $reviewSQL = "SELECT reviews.*, users.name FROM reviews 
                  JOIN users ON reviews.user_id = users.id 
                  WHERE hotel_id = $hotel_id ORDER BY created_at DESC";

    $reviews = $conn->query($reviewSQL);

    if ($reviews->num_rows > 0) {
        while ($r = $reviews->fetch_assoc()) {
            echo "<div class='mb-3 p-3 bg-light rounded'>";
            echo "<strong>" . $r['name'] . "</strong> ";
            echo "<span class='text-warning'>⭐ " . $r['rating'] . "/5</span><br>";
            echo "<p>" . $r['comment'] . "</p>";
            echo "<small class='text-muted'>" . $r['created_at'] . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-muted'>لا توجد تقييمات بعد.</p>";
    }
    ?>

    <div class="text-center mt-4">
        <a href="home.php" class="btn btn-secondary">⬅️ العودة إلى قائمة الفنادق</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
