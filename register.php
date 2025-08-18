<?php
$host = "localhost";       // หรือ 127.0.0.1
$user = "root";            // ชื่อผู้ใช้ MySQL
$password = "";            // รหัสผ่าน (ปกติ XAMPP ว่าง)
$dbname = "my_database";   // ชื่อฐานข้อมูล

$conn = new mysqli($host, $user, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
