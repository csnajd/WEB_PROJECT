<?php
// includes/db.php — الاتصال بقاعدة البيانات
$conn = mysqli_connect('localhost', 'joodifkc_saudi_user', 'joodifkc_jma2004', 'joodifkc_saudi_database');
 
if (!$conn) {
    die('فشل الاتصال بقاعدة البيانات: ' . mysqli_connect_error());
}
 
mysqli_set_charset($conn, 'utf8mb4');