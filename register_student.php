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
$class_year = $_POST['class_year'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// ตรวจสอบอีเมลซ้ำ
$stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  echo "<script>alert('อีเมลนี้มีผู้ใช้งานแล้ว'); window.history.back();</script>";
  exit();
}
$stmt->close();

// เพิ่มข้อมูล
$stmt = $conn->prepare("INSERT INTO students (name, email, class_year, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $class_year, $password);

if ($stmt->execute()) {
  echo "<script>alert('สมัครสมาชิกนักศึกษาสำเร็จ!'); window.location.href='login.html';</script>";
} else {
  echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
