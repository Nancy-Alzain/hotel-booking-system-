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
    <title>تم الدفع بنجاح</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body { background-color: #e6f7ff; }
        .card { background-color: #ffffffcc; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card mx-auto p-5 text-center shadow-sm" style="max-width: 500px;">
        <h2 class="mb-4 text-success">✅ تم الدفع بنجاح!</h2>
        <p class="lead">شكراً لاستخدامك نظام حجوزاتي! 💙</p>
        <a href="home.php" class="btn btn-primary mt-3">🏠 العودة للصفحة الرئيسية</a>
    </div>
</div>

</body>
</html>
