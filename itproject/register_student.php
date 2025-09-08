<?php
include 'conn.php'; // เชื่อมต่อฐานข้อมูล

// รับข้อมูลจากฟอร์ม
$name = $_POST['name'];
$email = $_POST['email'];
$class_year = $_POST['class_year'];
$stu_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// ตรวจสอบอีเมลซ้ำ
$stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  echo "<script>alert('❌ อีเมลนี้ถูกใช้งานแล้ว'); window.history.back();</script>";
  exit();
}
$stmt->close();

// เพิ่มข้อมูล
$stmt = $conn->prepare("INSERT INTO students (name, email, class_year, stu_password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $class_year, $stu_password);

if ($stmt->execute()) {
  // สมัครเสร็จ → ไปหน้า login
  echo "<script>alert('✅ สมัครสมาชิกนักศึกษาสำเร็จ! กรุณาเข้าสู่ระบบ'); window.location.href='login.php';</script>";
  exit();
} else {
  echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
