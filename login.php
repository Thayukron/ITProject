<?php
session_start();
include 'conn.php'; // เชื่อมต่อฐานข้อมูล

$message = "";

if (isset($_POST['login'])) {
    $role = $_POST['role']; // student หรือ teacher
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ป้องกัน SQL Injection
    $email = mysqli_real_escape_string($conn, $email);

    // เลือกตารางตาม role
    if ($role === "student") {
        $sql = "SELECT * FROM students WHERE email = '$email' LIMIT 1";
    } else {
        $sql = "SELECT * FROM teachers WHERE email = '$email' LIMIT 1";
    }

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // ตรวจสอบรหัสผ่าน
        $dbPassword = ($role === "student") ? $row['stu_password'] : $row['password'];

        if (password_verify($password, $dbPassword)) {
            // สร้าง session
            if ($role === "student") {
                $_SESSION['student_id'] = $row['student_id'];
                $_SESSION['student_name'] = $row['name'];
                $_SESSION['student_email'] = $row['email'];
            } else {
                $_SESSION['teacher_id'] = $row['teacher_id'];
                $_SESSION['teacher_name'] = $row['name'];
                $_SESSION['teacher_email'] = $row['email'];
            }

            // เข้าสู่ระบบสำเร็จ → ไปหน้า index.php
            header("Location: index.php");
            exit();
        } else {
            $message = "❌ รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $message = "❌ ไม่พบอีเมลนี้";
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            border-color: #3498db;
            outline: none;
        }

        button.submit-btn {
            width: 100%;
            padding: 14px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button.submit-btn:hover {
            background: #2980b9;
        }

        .message {
            text-align: center;
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .footer-text a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>

        <?php if ($message)
            echo "<div class='message'>$message</div>"; ?>

        <form action="" method="POST">
            <label for="role">ประเภทผู้ใช้งาน:</label>
            <select name="role" id="role" required>
                <option value="student">นักศึกษา</option>
                <option value="teacher">อาจารย์</option>
            </select>

            <label for="email">อีเมล:</label>
            <input type="email" name="email" id="email" placeholder="กรอกอีเมล" required>

            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่าน" required>

            <button type="submit" name="login" class="submit-btn">เข้าสู่ระบบ</button>
        </form>

        <div class="footer-text">
            ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a>
        </div>
    </div>

</body>

</html>
