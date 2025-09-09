<?php
session_start();
session_destroy(); // ลบ session ทั้งหมด
header("Location: login.php");
exit();
?>