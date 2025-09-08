<?php
include 'conn.php'; // เชื่อมต่อฐานข้อมูล

// รับข้อมูลจากฟอร์ม
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// ตรวจสอบอีเมลซ้ำ
$stmt = $conn->prepare("SELECT * FROM teachers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  echo "<script>alert('❌ อีเมลนี้ถูกใช้งานแล้ว'); window.history.back();</script>";
  exit();
}
$stmt->close();

// เพิ่มข้อมูล
$stmt = $conn->prepare("INSERT INTO teachers (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
  // สมัครเสร็จ → ไปหน้า login
  echo "<script>alert('✅ สมัครสมาชิกอาจารย์สำเร็จ! กรุณาเข้าสู่ระบบ'); window.location.href='login.php';</script>";
  exit();
} else {
  echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
