<?php
// ไฟล์นี้ใช้สำหรับสร้าง password hash
// วิธีใช้งาน: เปิดผ่าน browser เช่น http://localhost/gen_password.php?pass=123456

if (isset($_GET['pass'])) {
    $plain = $_GET['pass'];
    $hash = password_hash($plain, PASSWORD_DEFAULT);
    echo "<h3>🔑 Password: " . htmlspecialchars($plain) . "</h3>";
    echo "<h3>🔒 Hash: " . $hash . "</h3>";
} else {
    echo "<h3>❌ กรุณาใส่พารามิเตอร์ ?pass=รหัสผ่าน</h3>";
    echo "<p>เช่น <code>gen_password.php?pass=123456</code></p>";
}
?>
