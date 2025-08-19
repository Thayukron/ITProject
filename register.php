<<?php
// เชื่อมต่อฐานข้อมูล
$host = 'localhost';        // หรือ 127.0.0.1
$db   = 'project_db';    // เปลี่ยนเป็นชื่อฐานข้อมูลจริง
$user = 'root';             // ชื่อผู้ใช้ฐานข้อมูล
$pass = '';                 // รหัสผ่านฐานข้อมูล (ถ้ามี)
$charset = 'utf8mb4';

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $user, $pass, $db);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$name = $_POST['name'];
$email = $_POST['email'];
$class_year = $_POST['class_year'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO students (name, email, class_year, password)
        VALUES (?, ?, ?, ?)";

// ใช้ prepared statement ป้องกัน SQL Injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $class_year, $password);

// ประมวลผล
if ($stmt->execute()) {
    echo "✅ สมัครสมาชิกเรียบร้อยแล้ว!";
} else {
    echo "❌ เกิดข้อผิดพลาด: " . $stmt->error;
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
