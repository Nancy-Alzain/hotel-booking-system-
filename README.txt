مشروع حجوزات الفنادق 🏨
👩‍💻 فكرة المشروع:
تطوير نظام حجز فنادق بسيط باستخدام PHP و MySQL، يسمح للمستخدمين بتصفح الفنادق، إجراء حجوزات، إضافة تقييمات، وكذلك يتيح للمسؤول إدارة النظام ومراقبة الإحصائيات العامة.

🛠️ الأدوات المستخدمة:
PHP 8

MySQL

Bootstrap 5 (RTL)

XAMPP للسيرفر المحلي


📋 الوظائف الأساسية:

    -- للمستخدم العادي:
        - تسجيل حساب وتسجيل دخول 🔐

        - تصفح قائمة الفنادق ومعرفة السعر والتفاصيل 💬

        - حجز غرفة بالتاريخ المطلوب 📝

        - استلام تأكيد الحجز ✉️

        - إضافة تقييم وتعليق على الفندق ⭐

        - دفع وهمي بعد تأكيد الحجز 💳

        - متابعة الحجوزات الشخصية 📅

    --للمسؤول:
        - تسجيل دخول خاص بـ Admin 🔐

        - لوحة تحكم تعرض:

           -- إدارة الفنادق 📋

           -- إدارة الحجوزات 🧾

           -- عرض إحصائيات (عدد الفنادق، الحجوزات، المستخدمين، ونسبة الإشغال) 📊


📁 بنية الملفات:

    الملف ||                 الوظيفة
    db.php                   | الاتصال بقاعدة البيانات
    login.php                | تسجيل الدخول
    register.php             | إنشاء حساب جديد
    logout.php               | تسجيل الخروج
    home.php                 | الصفحة الرئيسية لعرض الفنادق
    detail.php               | عرض تفاصيل الفندق والحجز والتقييمات
    booking_confirmation.php | تأكيد الحجز
    payment_success.php      | صفحة إتمام الدفع
    mybookings.php           | عرض حجوزات المستخدم
    admin.php                | لوحة تحكم المسؤول
    admin_hotels.php         | إدارة الفنادق
    admin_bookings.php       | إدارة الحجوزات
    admin_stats.php          | عرض الإحصائيات

⚙️ كيفية تشغيل المشروع:

    1- تأكد أن سيرفر Apache و MySQL يعملان عبر XAMPP

    2- أنشئ قاعدة بيانات جديدة باسم: hotel_booking_system

    3- استورد جداول SQL (أو أنشئهم يدويًا)

    4- ضع ملفات المشروع داخل مجلد htdocs

    5- افتح المتصفح واكتب:http://localhost/hotel/
    
    6- ابدأ باستخدام النظام كمستخدم أو كمسؤول.



📂 ملفات SQL للمشروع : 
    1. إنشاء قاعدة البيانات
        create_database.sql :ملف اسمه  
        :محتواه 
        CREATE DATABASE IF NOT EXISTS hotel_booking_system;
        USE hotel_booking_system;
    2. إنشاء جدول المستخدمين
        create_users_table.sql :ملف اسمه
        :محتواه
        CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') DEFAULT 'user'
        );
    3. إنشاء جدول الفنادق
        create_hotels_table.sql :ملف اسمه
        : محتواه   
        CREATE TABLE IF NOT EXISTS hotels (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        location VARCHAR(100) NOT NULL,
        rating FLOAT NOT NULL,
        description TEXT,
        image VARCHAR(255),
        price DECIMAL(10,2) NOT NULL DEFAULT 0.00
        );
    
     4. إنشاء جدول الحجوزات
        create_bookings_table.sql :ملف اسمه
        : محتواه
        CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        hotel_id INT,
        check_in DATE,
        check_out DATE,
        status VARCHAR(50) DEFAULT 'قيد المعالجة',
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (hotel_id) REFERENCES hotels(id)
        );
     5. إنشاء جدول التقييمات
        create_reviews_table.sql :ملف اسمه 
        : محتواه
        CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        hotel_id INT,
        comment TEXT,
        rating INT CHECK (rating BETWEEN 1 AND 5),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (hotel_id) REFERENCES hotels(id)
        );
    6. إضافة مسؤول Admin جاهز
        insert_admin_user.sql : ملف اسمه
        : محتواه
        INSERT INTO users (name, email, password, role)
        VALUES ('Admin', 'admin@hotel.com', '$2y$10$EXAMPLE_HASHED_PASSWORD', 'admin');


📂 ترتبيهم بهيك شكل:
    hotel/
    ├── create_database.sql
    ├── create_users_table.sql
    ├── create_hotels_table.sql
    ├── create_bookings_table.sql
    ├── create_reviews_table.sql
    ├── insert_admin_user.sql
    ├── README.txt
    ├── db.php
    ├── login.php
    ├── register.php
    ├── logout.php
    ├── home.php
    ├── detail.php
    ├── booking_confirmation.php
    ├── payment_success.php
    ├── mybookings.php
    ├── admin.php
    ├── admin_hotels.php
    ├── admin_bookings.php
    ├── admin_stats.php
    ├── images/
