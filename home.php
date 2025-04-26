<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الرئيسية | حجوزات الفنادق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-light {
            background-color: #b2deff !important;
        }
        .card-title a {
            text-decoration: none;
            color: #0d6efd;
        }
        .card-title a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">حجوزاتي</a>
        <div>
            <a href="mybookings.php" class="btn btn-outline-primary me-2">📅 حجوزاتي</a>
            <a href="logout.php" class="btn btn-outline-danger">تسجيل الخروج</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="text-center mb-4">
        <h2>أهلاً، <?php echo $_SESSION['user_name']; ?> 👋</h2>
        <p class="lead">ابحث عن الفندق المناسب واحجز الآن 🏨</p>
    </div>

    <form method="GET" class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="ابحث عن فندق أو مدينة..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">بحث 🔍</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php
        include 'db.php';
        $where = "";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $term = $_GET['search'];
            $where = "WHERE name LIKE '%$term%' OR location LIKE '%$term%'";
        }
        $sql = "SELECT * FROM hotels $where";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '  <div class="card h-100 shadow-sm">';
                echo '    <img src="images/' . $row['image'] . '" class="card-img-top" style="height: 200px; object-fit: cover;">';
                echo '    <div class="card-body d-flex flex-column">';
                echo '      <h5 class="card-title"><a href="detail.php?id=' . $row['id'] . '">' . $row['name'] . '</a></h5>';
                echo '      <p class="card-text text-muted">📍 ' . $row['location'] . '</p>';
                echo '      <p class="card-text text-warning">⭐ ' . $row['rating'] . '</p>';
                echo '      <p class="card-text text-success">💰 السعر: ' . $row['price'] . ' ريال</p>';
                echo '      <a href="detail.php?id=' . $row['id'] . '" class="mt-auto btn btn-primary">عرض التفاصيل</a>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center">لا توجد نتائج مطابقة 😕</p>';
        }
        $conn->close();
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
