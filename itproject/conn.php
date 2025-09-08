<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "localhost";     // เซิร์ฟเวอร์ฐานข้อมูล
$username = "root";      // ชื่อผู้ใช้ MySQL (ค่าเริ่มต้นคือ root)
$password = "";          // รหัสผ่าน MySQL (ถ้าไม่ได้ตั้งจะว่าง)
$database = "project_db"; // ชื่อฐานข้อมูลที่สร้างไว้
$port = 3306;            // พอร์ต MySQL ปกติคือ 3306

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $database, $port);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("❌ การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
} else {
    // สำหรับ debug (สามารถปิดทิ้งได้)
    // echo "✅ เชื่อมต่อฐานข้อมูลสำเร็จ!";
}
?>