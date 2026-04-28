<?php
// this file is to be included in any page that needs connection to the database
$conn = mysqli_connect("localhost", "root", "", "saudi_database");

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");