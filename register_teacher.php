<?php
// config database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'project_db';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
  die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับข้อมูล
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// ตรวจสอบอีเมลซ้ำ
$stmt = $conn->prepare("SELECT * FROM teachers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  echo "<script>alert('อีเมลนี้มีผู้ใช้งานแล้ว'); window.history.back();</script>";
  exit();
}
$stmt->close();

// เพิ่มข้อมูล
$stmt = $conn->prepare("INSERT INTO teachers (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
  echo "<script>alert('สมัครสมาชิกอาจารย์สำเร็จ!'); window.location.href='login.html';</script>";
} else {
  echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
