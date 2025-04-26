<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_booking_system";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// فحص الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>
