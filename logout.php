<?php
session_start();
session_unset(); // ล้างข้อมูลทั้งหมดใน session
session_destroy(); // ทำลาย session
header("Location: login.php"); // รีไดเร็กต์ไปหน้า login
exit();
?>
