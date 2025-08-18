<?php
session_start();

// เชื่อมต่อฐานข้อมูล
$host = 'localhost';
$dbname = 'project_db';
$username = 'root'; // กรอกข้อมูลที่ถูกต้อง
$password = ''; // กรอกข้อมูลที่ถูกต้อง

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ไม่สามารถเชื่อมต่อกับฐานข้อมูล: " . $e->getMessage());
}

// ตรวจสอบการล็อกอิน
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // รีไดเร็กต์ไปหน้าแดชบอร์ดเมื่อเข้าสู่ระบบแล้ว
    exit();
}

// กรณีที่มีการส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลในทั้งสองตาราง
    $stmt = $pdo->prepare("SELECT student_id AS id, name, password FROM students WHERE email = :email UNION SELECT teacher_id AS id, name, password FROM teachers WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // ตรวจสอบรหัสผ่าน
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        header("Location: dashboard.php"); // รีไดเร็กต์ไปหน้าแดชบอร์ด
        exit();
    } else {
        $error_message = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
    }
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4e73df, #1e3d72);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-button {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .login-button:hover {
            background-color: #3b5bc0;
        }

        .links {
            margin-top: 15px;
        }

        .links a {
            color: #4e73df;
            text-decoration: none;
            font-size: 14px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>

        <form method="POST" action="">
            <input type="email" name="email" class="input-field" placeholder="อีเมล" required>
            <input type="password" name="password" class="input-field" placeholder="รหัสผ่าน" required>
            <button type="submit" class="login-button">เข้าสู่ระบบ</button>
        </form>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="links">
            <a href="#">ลืมรหัสผ่าน?</a> | <a href="#">สมัครสมาชิก</a>
        </div>
    </div>
</body>
</html>
